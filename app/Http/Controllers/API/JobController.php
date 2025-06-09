<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Models\JobList;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class JobController extends BaseController
{
    /**
     * Menampilkan daftar lowongan kerja
     */
    public function index(Request $request)
    {
        try {
            $query = JobList::query();

            // Filter by category
            if ($request->has('category') && $request->category) {
                $query->where('category', $request->category);
            }

            // Filter by status
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            // Filter by location
            if ($request->has('location') && $request->location) {
                $query->where('location', 'like', '%' . $request->location . '%');
            }

            // Filter by search term
            if ($request->has('search') && $request->search) {
                $searchTerm = $request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('title', 'like', '%' . $searchTerm . '%')
                        ->orWhere('description', 'like', '%' . $searchTerm . '%')
                        ->orWhere('location', 'like', '%' . $searchTerm . '%');
                });
            }

            // Add applications count
            $query->withCount('applications');

            // Order by latest by default
            $query->orderBy('created_at', 'DESC');

            $perPage = $request->get('per_page', 10);
            $jobs = $query->paginate($perPage);

            return $this->sendResponse($jobs, 'Daftar lowongan kerja berhasil diambil');
        } catch (\Exception $e) {
            return $this->sendError('Gagal mengambil data lowongan kerja', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Menambahkan lowongan kerja
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required',
                'category' => 'required|in:Full-time,Part-time,Freelance',
                'salary' => 'required|numeric',
                'salary_type' => 'required|in:Per Jam,Per Hari,Per Bulan,Proyek',
                'duration' => 'required|string',
                'target' => 'nullable|string',
                'location' => 'required|string',
                'requirements' => 'nullable|string',
                'benefits' => 'nullable|string',
                'deadline' => 'nullable|date',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'required|in:Dibuka,Ditutup,Selesai'
            ]);

            $data = $request->all();

            // Handle image upload menggunakan metode yang sama seperti contoh Anda
            $imagePath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . \Illuminate\Support\Str::random(6) . '.' . $file->getClientOriginalExtension();
                // Move to public/uploads/image_job
                $file->move(public_path('uploads/image_job'), $filename);
                // Save relative path for asset()
                $imagePath = 'uploads/image_job/' . $filename;
            } else {
                // Set default image based on job category
                $category = $request->category;
                switch ($category) {
                    case 'Full-time':
                        $imagePath = 'uploads/image_job/default/full-time.jpg';
                        break;
                    case 'Part-time':
                        $imagePath = 'uploads/image_job/default/part-time.jpg';
                        break;
                    case 'Freelance':
                        $imagePath = 'uploads/image_job/default/freelance.jpg';
                        break;
                    default:
                        $imagePath = 'uploads/image_job/default/job.jpg';
                }
            }

            $data['image'] = $imagePath;

            $job = JobList::create($data);
            return $this->sendResponse($job, 'Lowongan kerja berhasil dibuat');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->sendError('Validasi gagal', $e->errors(), 422);
        } catch (\Exception $e) {
            return $this->sendError('Gagal membuat lowongan kerja', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Menampilkan detail lowongan
     */
    public function show($id)
    {
        try {
            $job = JobList::withCount('applications')->find($id);
            if (!$job) {
                return $this->sendError('Lowongan kerja tidak ditemukan', [], 404);
            }
            return $this->sendResponse($job, 'Detail lowongan kerja berhasil diambil');
        } catch (\Exception $e) {
            return $this->sendError('Gagal mengambil detail lowongan kerja', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Mengupdate lowongan
     */
    public function update(Request $request, $id)
    {
        try {
            $job = JobList::find($id);
            if (!$job) {
                return $this->sendError('Lowongan kerja tidak ditemukan', [], 404);
            }

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required',
                'category' => 'required|in:Full-time,Part-time,Freelance',
                'salary' => 'required|numeric',
                'salary_type' => 'required|in:Per Jam,Per Hari,Per Bulan,Proyek',
                'duration' => 'required|string',
                'target' => 'nullable|string',
                'location' => 'required|string',
                'requirements' => 'nullable|string',
                'benefits' => 'nullable|string',
                'deadline' => 'nullable|date',
                'status' => 'required|in:Dibuka,Ditutup,Selesai',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $data = $request->except(['image']);

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if it exists and is not a default image
                if ($job->image && !str_contains($job->image, 'default/')) {
                    $oldImagePath = public_path($job->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $file = $request->file('image');
                $filename = time() . '_' . \Illuminate\Support\Str::random(6) . '.' . $file->getClientOriginalExtension();
                // Move to public/uploads/image_job
                $file->move(public_path('uploads/image_job'), $filename);
                // Save relative path for asset()
                $data['image'] = 'uploads/image_job/' . $filename;
            }

            $job->update($data);
            return $this->sendResponse($job, 'Lowongan kerja berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->sendError('Validasi gagal', $e->errors(), 422);
        } catch (\Exception $e) {
            return $this->sendError('Gagal memperbarui lowongan kerja', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Menghapus lowongan kerja
     */
    public function destroy($id)
    {
        try {
            $job = JobList::find($id);
            if (!$job) {
                return $this->sendError('Lowongan kerja tidak ditemukan', [], 404);
            }

            // Check if there are applications
            $applicationsCount = $job->applications()->count();
            if ($applicationsCount > 0) {
                return $this->sendError('Tidak dapat menghapus lowongan yang sudah memiliki pelamar', [], 400);
            }

            // Delete job image if it's not a default image
            if ($job->image && !str_contains($job->image, 'default/')) {
                $imagePath = public_path($job->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $job->delete();
            return $this->sendResponse([], 'Lowongan kerja berhasil dihapus');
        } catch (\Exception $e) {
            return $this->sendError('Gagal menghapus lowongan kerja', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Export lowongan kerja ke Excel/CSV
     */
    public function export(Request $request)
    {
        try {
            $query = JobList::query();

            // Apply filters if provided
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            if ($request->has('category') && $request->category) {
                $query->where('category', $request->category);
            }

            if ($request->has('location') && $request->location) {
                $query->where('location', 'like', '%' . $request->location . '%');
            }

            if ($request->has('search') && $request->search) {
                $searchTerm = $request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('title', 'like', '%' . $searchTerm . '%')
                        ->orWhere('description', 'like', '%' . $searchTerm . '%')
                        ->orWhere('location', 'like', '%' . $searchTerm . '%');
                });
            }

            $jobs = $query->with('applications')->orderBy('created_at', 'DESC')->get();

            $filename = 'lowongan_kerja_' . date('Y-m-d_H-i-s') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($jobs) {
                $file = fopen('php://output', 'w');

                // Add BOM for UTF-8
                fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

                // CSV Headers
                fputcsv($file, [
                    'ID',
                    'Judul',
                    'Kategori',
                    'Gaji',
                    'Tipe Gaji',
                    'Lokasi',
                    'Durasi',
                    'Target',
                    'Status',
                    'Total Pelamar',
                    'Pelamar Diterima',
                    'Pelamar Ditolak',
                    'Tanggal Dibuat',
                    'Tanggal Diupdate'
                ]);

                // Data rows
                foreach ($jobs as $job) {
                    $applicationsCount = $job->applications->count();
                    $acceptedCount = $job->applications->where('status', 'Diterima')->count();
                    $rejectedCount = $job->applications->where('status', 'Ditolak')->count();

                    fputcsv($file, [
                        $job->id,
                        $job->title,
                        $job->category,
                        'Rp ' . number_format($job->salary, 0, ',', '.'),
                        $job->salary_type,
                        $job->location,
                        $job->duration,
                        $job->target ?: '-',
                        $job->status,
                        $applicationsCount,
                        $acceptedCount,
                        $rejectedCount,
                        $job->created_at->format('d/m/Y H:i'),
                        $job->updated_at->format('d/m/Y H:i')
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            return $this->sendError('Gagal mengexport data', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get job statistics
     */
    public function getStatistics()
    {
        try {
            $totalJobs = JobList::count();
            $activeJobs = JobList::where('status', 'Dibuka')->count();
            $closedJobs = JobList::where('status', 'Ditutup')->count();
            $completedJobs = JobList::where('status', 'Selesai')->count();

            // Get jobs by category
            $categoriesStats = JobList::select('category', DB::raw('count(*) as total'))
                ->groupBy('category')
                ->get();

            // Get recent jobs (last 30 days)
            $recentJobsCount = JobList::where('created_at', '>=', now()->subDays(30))->count();

            // Get jobs with most applications
            $popularJobs = JobList::withCount('applications')
                ->orderBy('applications_count', 'desc')
                ->limit(5)
                ->get(['id', 'title', 'applications_count']);

            return $this->sendResponse([
                'total' => $totalJobs,
                'active' => $activeJobs,
                'closed' => $closedJobs,
                'completed' => $completedJobs,
                'recent' => $recentJobsCount,
                'categories' => $categoriesStats,
                'popular_jobs' => $popularJobs
            ], 'Statistik lowongan berhasil diambil');
        } catch (\Exception $e) {
            return $this->sendError('Gagal mengambil statistik', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Bulk delete jobs
     */
    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'job_ids' => 'required|array',
                'job_ids.*' => 'exists:job_lists,id'
            ]);

            $jobs = JobList::whereIn('id', $request->job_ids)->get();
            $deletedCount = 0;
            $errors = [];

            foreach ($jobs as $job) {
                // Check if job has applications
                if ($job->applications()->count() > 0) {
                    $errors[] = "Lowongan '{$job->title}' memiliki pelamar dan tidak dapat dihapus";
                    continue;
                }

                // Delete image if not default
                if ($job->image && !str_contains($job->image, 'default/')) {
                    Storage::disk('public')->delete($job->image);
                }

                $job->delete();
                $deletedCount++;
            }

            $message = "Berhasil menghapus {$deletedCount} lowongan";
            if (!empty($errors)) {
                $message .= ". " . implode(', ', $errors);
            }

            return $this->sendResponse([
                'deleted_count' => $deletedCount,
                'errors' => $errors
            ], $message);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->sendError('Validasi gagal', $e->errors(), 422);
        } catch (\Exception $e) {
            return $this->sendError('Gagal menghapus lowongan', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Duplicate job
     */
    public function duplicate($id)
    {
        try {
            $originalJob = JobList::find($id);
            if (!$originalJob) {
                return $this->sendError('Lowongan kerja tidak ditemukan', [], 404);
            }

            $newJobData = $originalJob->toArray();
            unset($newJobData['id'], $newJobData['created_at'], $newJobData['updated_at']);

            // Add "Copy" to title
            $newJobData['title'] = 'Copy of ' . $newJobData['title'];
            $newJobData['status'] = 'Ditutup'; // Set as closed by default

            $newJob = JobList::create($newJobData);
            return $this->sendResponse($newJob, 'Lowongan berhasil diduplikasi');
        } catch (\Exception $e) {
            return $this->sendError('Gagal menduplikasi lowongan', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get jobs by status count for dashboard
     */
    public function getStatusCounts()
    {
        try {
            $counts = [
                'dibuka' => JobList::where('status', 'Dibuka')->count(),
                'ditutup' => JobList::where('status', 'Ditutup')->count(),
                'selesai' => JobList::where('status', 'Selesai')->count(),
            ];

            return $this->sendResponse($counts, 'Status count berhasil diambil');
        } catch (\Exception $e) {
            return $this->sendError('Gagal mengambil status count', ['error' => $e->getMessage()], 500);
        }
    }
}
