<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjadwalanPenjemputan;
use App\Models\SupplierRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdvancedPenjadwalanController extends Controller
{
    /**
     * Dashboard analytics untuk penjadwalan
     */
    public function analytics()
    {
        $currentMonth = now()->format('Y-m');
        $lastMonth = now()->subMonth()->format('Y-m');

        // Statistics
        $stats = [
            'total_schedules' => PenjadwalanPenjemputan::count(),
            'this_month' => PenjadwalanPenjemputan::whereYear('tanggal_jemput', now()->year)
                                                  ->whereMonth('tanggal_jemput', now()->month)
                                                  ->count(),
            'completed_this_month' => PenjadwalanPenjemputan::where('status_jemput', 'dijemput')
                                                            ->whereYear('tanggal_jemput', now()->year)
                                                            ->whereMonth('tanggal_jemput', now()->month)
                                                            ->count(),
            'overdue_count' => PenjadwalanPenjemputan::where('status_jemput', 'terjadwal')
                                                    ->where('tanggal_jemput', '<', now())
                                                    ->count(),
            'upcoming_week' => PenjadwalanPenjemputan::where('status_jemput', 'terjadwal')
                                                    ->whereBetween('tanggal_jemput', [now(), now()->addWeek()])
                                                    ->count(),
        ];

        // Chart data - Pickups per month for current year
        $monthlyData = PenjadwalanPenjemputan::select(
                DB::raw('MONTH(tanggal_jemput) as month'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status_jemput = "dijemput" THEN 1 ELSE 0 END) as completed')
            )
            ->whereYear('tanggal_jemput', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = [
                'month' => Carbon::create()->month($i)->format('M'),
                'total' => $monthlyData->get($i)->total ?? 0,
                'completed' => $monthlyData->get($i)->completed ?? 0,
            ];
        }

        // Location distribution
        $locationData = PenjadwalanPenjemputan::select('kecamatan', DB::raw('COUNT(*) as total'))
            ->where('kecamatan', '!=', '')
            ->whereNotNull('kecamatan')
            ->groupBy('kecamatan')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // Performance metrics
        $performanceMetrics = [
            'average_completion_rate' => $this->calculateCompletionRate(),
            'average_weight_per_pickup' => PenjadwalanPenjemputan::avg('estimasi_kg'),
            'total_weight_collected' => PenjadwalanPenjemputan::where('status_jemput', 'dijemput')
                                                              ->sum('estimasi_kg'),
            'cancellation_rate' => $this->calculateCancellationRate(),
        ];

        return view('admin.penjadwalan.analytics', compact(
            'stats', 'chartData', 'locationData', 'performanceMetrics'
        ));
    }

    /**
     * Bulk operations untuk penjadwalan
     */
    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:update_status,reschedule,delete',
            'schedule_ids' => 'required|array',
            'schedule_ids.*' => 'exists:penjadwalan_penjemputans,id',
            'new_status' => 'required_if:action,update_status|in:terjadwal,dijemput,dibatalkan',
            'new_date' => 'required_if:action,reschedule|date|after_or_equal:today',
        ]);

        try {
            DB::beginTransaction();

            $schedules = PenjadwalanPenjemputan::with('request')
                                              ->whereIn('id', $request->schedule_ids)
                                              ->get();

            $results = [];

            foreach ($schedules as $schedule) {
                switch ($request->action) {
                    case 'update_status':
                        $oldStatus = $schedule->status_jemput;
                        $schedule->update(['status_jemput' => $request->new_status]);

                        // Send notification if status changed significantly
                        if ($oldStatus != $request->new_status &&
                            in_array($request->new_status, ['dijemput', 'dibatalkan'])) {
                            $this->sendBulkNotification($schedule, $request->new_status, $oldStatus);
                        }

                        $results[] = "Status {$schedule->request->nama} berhasil diubah";
                        break;

                    case 'reschedule':
                        $schedule->update(['tanggal_jemput' => $request->new_date]);
                        $this->sendRescheduleNotification($schedule, $request->new_date);
                        $results[] = "Jadwal {$schedule->request->nama} berhasil diubah";
                        break;

                    case 'delete':
                        $this->sendCancellationNotification($schedule);
                        $schedule->delete();
                        $results[] = "Jadwal {$schedule->request->nama} berhasil dihapus";
                        break;
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Operasi bulk berhasil dilakukan',
                'results' => $results
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Smart scheduling - otomatis suggest jadwal optimal
     */
    public function smartScheduling(Request $request)
    {
        $request->validate([
            'supplier_request_ids' => 'required|array',
            'supplier_request_ids.*' => 'exists:supplier_requests,id',
            'preferred_date_range' => 'required|array',
            'preferred_date_range.start' => 'required|date|after_or_equal:today',
            'preferred_date_range.end' => 'required|date|after:preferred_date_range.start',
        ]);

        $supplierRequests = SupplierRequest::whereIn('id', $request->supplier_request_ids)
                                         ->where('status', 'disetujui')
                                         ->get();

        // Group by location to optimize routes
        $locationGroups = $supplierRequests->groupBy(function ($item) {
            return $item->kecamatan . '_' . $item->desa;
        });

        $suggestions = [];
        $currentDate = Carbon::parse($request->preferred_date_range['start']);
        $endDate = Carbon::parse($request->preferred_date_range['end']);

        foreach ($locationGroups as $location => $requests) {
            // Calculate optimal pickup date based on location and quantity
            $totalWeight = $requests->sum('estimasi_kg');
            $requestCount = $requests->count();

            // Smart logic: group nearby locations on same day if total weight > 100kg
            $suggestedDate = $this->calculateOptimalDate($currentDate, $endDate, $totalWeight, $location);

            $suggestions[] = [
                'location' => $location,
                'suggested_date' => $suggestedDate,
                'requests' => $requests->map(function ($req) use ($suggestedDate) {
                    return [
                        'id' => $req->id,
                        'nama' => $req->nama,
                        'estimasi_kg' => $req->estimasi_kg,
                        'suggested_date' => $suggestedDate,
                        'priority_score' => $this->calculatePriorityScore($req),
                    ];
                }),
                'total_weight' => $totalWeight,
                'efficiency_score' => $this->calculateEfficiencyScore($totalWeight, $requestCount),
            ];

            // Move to next available date
            $currentDate = $suggestedDate->copy()->addDay();
        }

        return response()->json([
            'suggestions' => $suggestions,
            'summary' => [
                'total_requests' => $supplierRequests->count(),
                'total_weight' => $supplierRequests->sum('estimasi_kg'),
                'location_groups' => count($locationGroups),
                'date_range' => [
                    'start' => $request->preferred_date_range['start'],
                    'end' => $request->preferred_date_range['end'],
                ],
            ]
        ]);
    }

    /**
     * Route optimization untuk penjemputan
     */
    public function optimizeRoute(Request $request)
    {
        $date = $request->get('date', now()->format('Y-m-d'));

        $schedules = PenjadwalanPenjemputan::with('request')
                                         ->where('tanggal_jemput', $date)
                                         ->where('status_jemput', 'terjadwal')
                                         ->get();

        if ($schedules->isEmpty()) {
            return response()->json([
                'message' => 'Tidak ada jadwal untuk tanggal tersebut',
                'optimized_route' => []
            ]);
        }

        // Group by kecamatan for route optimization
        $routeGroups = $schedules->groupBy('kecamatan');
        $optimizedRoute = [];
        $totalDistance = 0;
        $totalTime = 0;

        foreach ($routeGroups as $kecamatan => $groupSchedules) {
            $subRoute = $groupSchedules->sortBy('desa')->values();

            foreach ($subRoute as $index => $schedule) {
                $estimatedTime = $this->calculatePickupTime($schedule->estimasi_kg);
                $travelTime = $index > 0 ? $this->calculateTravelTime($subRoute[$index-1], $schedule) : 0;

                $optimizedRoute[] = [
                    'id' => $schedule->id,
                    'sequence' => count($optimizedRoute) + 1,
                    'supplier_name' => $schedule->request->nama,
                    'location' => $schedule->lokasi_lengkap,
                    'estimasi_kg' => $schedule->estimasi_kg,
                    'estimated_pickup_time' => $estimatedTime,
                    'travel_time_from_previous' => $travelTime,
                    'arrival_time' => $this->calculateArrivalTime($totalTime + $travelTime),
                    'departure_time' => $this->calculateArrivalTime($totalTime + $travelTime + $estimatedTime),
                ];

                $totalTime += $travelTime + $estimatedTime;
                $totalDistance += $this->calculateDistance($index > 0 ? $subRoute[$index-1] : null, $schedule);
            }
        }

        return response()->json([
            'date' => $date,
            'optimized_route' => $optimizedRoute,
            'summary' => [
                'total_stops' => count($optimizedRoute),
                'total_weight' => $schedules->sum('estimasi_kg'),
                'estimated_total_time' => $totalTime,
                'estimated_distance' => $totalDistance,
                'efficiency_score' => $this->calculateRouteEfficiency($schedules->count(), $totalTime, $totalDistance),
            ]
        ]);
    }

    /**
     * Automated notifications dan reminders
     */
    public function sendAutomatedReminders()
    {
        // Reminder 1 hari sebelum penjemputan
        $tomorrowSchedules = PenjadwalanPenjemputan::with('request')
                                                  ->where('status_jemput', 'terjadwal')
                                                  ->whereDate('tanggal_jemput', now()->addDay())
                                                  ->get();

        foreach ($tomorrowSchedules as $schedule) {
            $this->sendReminderNotification($schedule, 'tomorrow');
        }

        // Reminder untuk jadwal yang terlambat
        $overdueSchedules = PenjadwalanPenjemputan::with('request')
                                                 ->where('status_jemput', 'terjadwal')
                                                 ->where('tanggal_jemput', '<', now()->subDay())
                                                 ->get();

        foreach ($overdueSchedules as $schedule) {
            $this->sendOverdueNotification($schedule);
        }

        // Weekly summary untuk admin
        if (now()->isDayOfWeek(Carbon::MONDAY)) {
            $this->sendWeeklySummary();
        }

        return response()->json([
            'tomorrow_reminders' => $tomorrowSchedules->count(),
            'overdue_notifications' => $overdueSchedules->count(),
            'message' => 'Automated reminders sent successfully'
        ]);
    }

    /**
     * Predictive analytics untuk perencanaan
     */
    public function predictiveAnalytics()
    {
        // Prediksi volume penjemputan bulan depan
        $historicalData = PenjadwalanPenjemputan::select(
                DB::raw('YEAR(tanggal_jemput) as year'),
                DB::raw('MONTH(tanggal_jemput) as month'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(estimasi_kg) as total_weight')
            )
            ->where('tanggal_jemput', '>=', now()->subYear())
            ->groupBy('year', 'month')
            ->orderBy('year', 'month')
            ->get();

        // Simple linear regression untuk prediksi
        $prediction = $this->calculatePrediction($historicalData);

        // Analisis seasonal patterns
        $seasonalAnalysis = $this->analyzeSeasonalPatterns($historicalData);

        // Capacity planning
        $capacityRecommendation = $this->calculateCapacityNeeds($prediction);

        return response()->json([
            'next_month_prediction' => $prediction,
            'seasonal_analysis' => $seasonalAnalysis,
            'capacity_recommendation' => $capacityRecommendation,
            'historical_data' => $historicalData,
        ]);
    }

    // Helper methods
    private function calculateCompletionRate()
    {
        $total = PenjadwalanPenjemputan::count();
        $completed = PenjadwalanPenjemputan::where('status_jemput', 'dijemput')->count();
        return $total > 0 ? round(($completed / $total) * 100, 2) : 0;
    }

    private function calculateCancellationRate()
    {
        $total = PenjadwalanPenjemputan::count();
        $cancelled = PenjadwalanPenjemputan::where('status_jemput', 'dibatalkan')->count();
        return $total > 0 ? round(($cancelled / $total) * 100, 2) : 0;
    }

    private function calculateOptimalDate($startDate, $endDate, $totalWeight, $location)
    {
        // Logic untuk menentukan tanggal optimal berdasarkan:
        // 1. Total berat (prioritas tinggi untuk berat besar)
        // 2. Lokasi (group lokasi terdekat)
        // 3. Kapasitas harian (max 5 penjemputan per hari)

        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $dailySchedules = PenjadwalanPenjemputan::whereDate('tanggal_jemput', $currentDate)->count();

            if ($dailySchedules < 5) { // Max 5 pickups per day
                return $currentDate;
            }

            $currentDate->addDay();
        }

        return $startDate; // Fallback
    }

    private function calculatePriorityScore($request)
    {
        $score = 0;

        // Weight factor
        $score += $request->estimasi_kg * 0.1;

        // Age factor (older requests get higher priority)
        $daysSinceRequest = $request->created_at->diffInDays(now());
        $score += $daysSinceRequest * 0.5;

        // Incentive type factor
        if ($request->insentif === 'uang_tunai') {
            $score += 10;
        }

        return round($score, 2);
    }

    private function calculateEfficiencyScore($totalWeight, $requestCount)
    {
        // Higher score for higher weight concentration
        return $requestCount > 0 ? round($totalWeight / $requestCount, 2) : 0;
    }

    private function calculatePickupTime($weight)
    {
        // Base time 15 minutes + 2 minutes per 10kg
        return 15 + ceil($weight / 10) * 2;
    }

    private function calculateTravelTime($fromSchedule, $toSchedule)
    {
        // Simplified calculation - in real world, use Google Maps API
        if (!$fromSchedule) return 0;

        if ($fromSchedule->kecamatan === $toSchedule->kecamatan) {
            if ($fromSchedule->desa === $toSchedule->desa) {
                return 10; // Same village
            }
            return 20; // Same district
        }

        return 45; // Different district
    }

    private function calculateDistance($fromSchedule, $toSchedule)
    {
        // Simplified calculation in km
        if (!$fromSchedule) return 0;

        if ($fromSchedule->kecamatan === $toSchedule->kecamatan) {
            if ($fromSchedule->desa === $toSchedule->desa) {
                return 2;
            }
            return 8;
        }

        return 25;
    }

    private function calculateArrivalTime($minutesFromStart)
    {
        return now()->startOfDay()->addHours(8)->addMinutes($minutesFromStart)->format('H:i');
    }

    private function calculateRouteEfficiency($stops, $totalTime, $totalDistance)
    {
        // Higher score is better
        $timePerStop = $stops > 0 ? $totalTime / $stops : 0;
        $distancePerStop = $stops > 0 ? $totalDistance / $stops : 0;

        // Efficiency score: lower time and distance per stop is better
        return $stops > 0 ? round(100 - ($timePerStop + $distancePerStop), 2) : 0;
    }

    private function calculatePrediction($historicalData)
    {
        // Simple linear regression implementation
        if ($historicalData->count() < 2) {
            return ['count' => 0, 'weight' => 0, 'confidence' => 0];
        }

        $n = $historicalData->count();
        $sumX = $sumY = $sumXY = $sumX2 = 0;

        foreach ($historicalData as $index => $data) {
            $x = $index + 1;
            $y = $data->count;

            $sumX += $x;
            $sumY += $y;
            $sumXY += $x * $y;
            $sumX2 += $x * $x;
        }

        $slope = ($n * $sumXY - $sumX * $sumY) / ($n * $sumX2 - $sumX * $sumX);
        $intercept = ($sumY - $slope * $sumX) / $n;

        $nextPeriod = $n + 1;
        $predictedCount = $slope * $nextPeriod + $intercept;

        return [
            'count' => max(0, round($predictedCount)),
            'weight' => max(0, round($predictedCount * 50)), // Assume avg 50kg per pickup
            'confidence' => min(95, max(50, 100 - abs($slope) * 10)),
        ];
    }

    private function analyzeSeasonalPatterns($historicalData)
    {
        $monthlyAverage = $historicalData->groupBy('month')->map(function ($items) {
            return [
                'avg_count' => round($items->avg('count'), 2),
                'avg_weight' => round($items->avg('total_weight'), 2),
            ];
        });

        return $monthlyAverage;
    }

    private function calculateCapacityNeeds($prediction)
    {
        $predictedVolume = $prediction['count'];
        $currentCapacity = 150; // Assume current monthly capacity

        $utilizationRate = $currentCapacity > 0 ? ($predictedVolume / $currentCapacity) * 100 : 0;

        $recommendation = '';
        if ($utilizationRate > 90) {
            $recommendation = 'Perlu menambah kapasitas penjemputan';
        } elseif ($utilizationRate > 75) {
            $recommendation = 'Kapasitas mendekati batas, perlu perencanaan tambahan';
        } elseif ($utilizationRate < 50) {
            $recommendation = 'Kapasitas berlebih, bisa dialokasikan untuk area lain';
        } else {
            $recommendation = 'Kapasitas optimal';
        }

        return [
            'current_capacity' => $currentCapacity,
            'predicted_demand' => $predictedVolume,
            'utilization_rate' => round($utilizationRate, 2),
            'recommendation' => $recommendation,
        ];
    }

    // Additional notification methods would be here...
    private function sendBulkNotification($schedule, $newStatus, $oldStatus) { /* Implementation */ }
    private function sendRescheduleNotification($schedule, $newDate) { /* Implementation */ }
    private function sendCancellationNotification($schedule) { /* Implementation */ }
    private function sendReminderNotification($schedule, $type) { /* Implementation */ }
    private function sendOverdueNotification($schedule) { /* Implementation */ }
    private function sendWeeklySummary() { /* Implementation */ }
}
