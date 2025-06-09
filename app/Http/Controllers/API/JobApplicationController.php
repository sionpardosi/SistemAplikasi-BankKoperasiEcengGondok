<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\JobApplication;
use App\Models\JobList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends BaseController
{
    /**
     * Menampilkan halaman daftar pelamar untuk job tertentu (View)
     */
    public function index($id)
    {
        try {
            // Validasi job exists
            $job = JobList::find($id);
            if (!$job) {
                return redirect()->route('admin.jobs')->with('error', 'Lowongan tidak ditemukan');
            }

            // Get applications with user data
            $applications = JobApplication::with('user')
                ->where('job_id', $id)
                ->orderBy('created_at', 'DESC')
                ->get();

            return view('admin.jobs.job_applications', [
                'applications' => $applications,
                'jobId' => $id,
                'job' => $job
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.jobs')->with('error', 'Gagal memuat data pelamar: ' . $e->getMessage());
        }
    }

    /**
     * Melamar pekerjaan
     */
    public function apply(Request $request, $jobId)
    {
        try {
            $job = JobList::find($jobId);
            if (!$job) {
                return $this->sendError('Lowongan pekerjaan tidak ditemukan', [], 404);
            }

            if ($job->status !== 'Dibuka') {
                return $this->sendError('Lowongan pekerjaan ini sudah tidak menerima lamaran', [], 400);
            }

            $user = Auth::guard('sanctum')->user();
            if (!$user && Auth::check()) {
                $user = Auth::user();
            }
            if (!$user) {
                return $this->sendError('Silakan login terlebih dahulu untuk melamar pekerjaan', [], 401);
            }

            // Validasi input - disesuaikan dengan field yang ada
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone_number' => 'required|string|max:20',
                'whatsapp_number' => 'required|string|max:20',
                'gender' => 'required|in:Laki-laki,Perempuan',
                'education_level' => 'required|string',
                'experience' => 'nullable|string',
                'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
                'image' => 'nullable|file|mimes:jpeg,jpg,png,pdf,doc,docx|max:2048',
                'additional_info' => 'nullable|string',
            ]);

            // Cek apakah user sudah pernah melamar
            $existingApplication = JobApplication::where('user_id', $user->id)
                ->where('job_id', $jobId)
                ->first();
            if ($existingApplication) {
                return $this->sendError('Anda sudah pernah melamar untuk lowongan ini', [], 400);
            }

            $applicationData = [
                'job_id' => $jobId,
                'user_id' => $user->id,
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'whatsapp_number' => $request->whatsapp_number,
                'gender' => $request->gender,
                'education_level' => $request->education_level,
                'experience' => $request->experience,
                // Set default values untuk field yang dihapus dari form tapi masih diperlukan database
                'cover_letter' => 'Lamaran melalui formulir aplikasi baru - Data lengkap tersedia di form.',
                'skills' => $request->additional_info ? "Lihat informasi tambahan: " . $request->additional_info : 'Data keterampilan tersedia di dokumen yang diupload',
                'expected_salary' => 'Sesuai standar perusahaan',
                'additional_info' => $request->additional_info,
                'status' => 'Diproses',
            ];

            // Handle file CV upload
            if ($request->hasFile('cv')) {
                $cvFile = $request->file('cv');
                $cvFilename = time() . '_cv_' . \Illuminate\Support\Str::random(6) . '.' . $cvFile->getClientOriginalExtension();
                $cvFile->move(public_path('uploads/cv'), $cvFilename);
                $applicationData['cv'] = 'uploads/cv/' . $cvFilename;
            }

            // Handle file image/keterampilan upload
            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $imageFilename = time() . '_skill_' . \Illuminate\Support\Str::random(6) . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('uploads/skills'), $imageFilename);
                $applicationData['image'] = 'uploads/skills/' . $imageFilename;
            }

            $application = JobApplication::create($applicationData);

            return response()->json([
                'success' => true,
                'message' => 'Lamaran berhasil dikirim! Kami akan menghubungi Anda melalui email atau WhatsApp.',
                'data' => $application
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->sendError('Validasi gagal', $e->errors(), 422);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error applying job: ' . $e->getMessage());
            return $this->sendError('Terjadi kesalahan saat mengirim lamaran', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Menampilkan daftar lamaran user
     */
    public function userApplications()
    {
        try {
            $user = Auth::guard('sanctum')->user();

            if (!$user && Auth::check()) {
                $user = Auth::user();
            }

            if (!$user) {
                return $this->sendError('Silakan login terlebih dahulu', [], 401);
            }

            $applications = JobApplication::where('user_id', $user->id)
                ->with('job:id,title,category,status')
                ->orderBy('created_at', 'DESC')
                ->paginate(10);

            return $this->sendResponse($applications, 'Data lamaran berhasil diambil');
        } catch (\Exception $e) {
            return $this->sendError('Gagal mengambil data lamaran', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update status lamaran (Admin)
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $application = JobApplication::find($id);
            if (!$application) {
                return $this->sendError('Lamaran tidak ditemukan', [], 404);
            }

            $request->validate([
                'status' => 'required|in:Diterima,Ditolak,Diproses',
            ]);

            $application->update(['status' => $request->status]);

            return $this->sendResponse($application, 'Status lamaran berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->sendError('Validasi gagal', $e->errors(), 422);
        } catch (\Exception $e) {
            return $this->sendError('Gagal memperbarui status lamaran', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Menampilkan daftar lamaran untuk job tertentu (API)
     */
    public function getJobApplications($job_id)
    {
        try {
            $applications = JobApplication::with('user')
                ->where('job_id', $job_id)
                ->orderBy('created_at', 'DESC')
                ->get();

            return $this->sendResponse($applications, 'Daftar lamaran berhasil diambil');
        } catch (\Exception $e) {
            return $this->sendError('Gagal mengambil data lamaran', ['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show applications for specific job (alternative method)
     */
    public function showApplications($id)
    {
        try {
            $applications = JobApplication::with(['user', 'job'])
                ->where('job_id', $id)
                ->latest()
                ->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $applications
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data pelamar'
            ], 500);
        }
    }

    /**
     * Delete application
     */
    public function destroy($id)
    {
        try {
            $application = JobApplication::find($id);
            if (!$application) {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
            }

            // Delete CV file if exists
            if ($application->cv && Storage::disk('public')->exists($application->cv)) {
                Storage::disk('public')->delete($application->cv);
            }

            $application->delete();
            return response()->json(['success' => true, 'message' => 'Data pelamar berhasil dihapus']);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error deleting application: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus data pelamar'], 500);
        }
    }

    /**
     * Update application data
     */
    public function update(Request $request, $id)
    {
        try {
            $application = JobApplication::findOrFail($id);

            $validatedData = $request->validate([
                'phone_number' => 'nullable|string',
                'education_level' => 'nullable|string',
                'experience' => 'nullable|string',
                'expected_salary' => 'nullable|string',
                'skills' => 'nullable|string',
                'additional_info' => 'nullable|string',
                'status' => 'nullable|in:Diproses,Diterima,Ditolak'
            ]);

            $application->update($validatedData);

            return response()->json(['success' => true, 'message' => 'Data pelamar berhasil diperbarui']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error updating application: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui data pelamar'], 500);
        }
    }

    /**
     * Export applications to Excel/CSV
     */
    public function exportApplications($jobId)
    {
        try {
            $job = JobList::find($jobId);
            if (!$job) {
                return redirect()->back()->with('error', 'Lowongan tidak ditemukan');
            }

            $applications = JobApplication::with('user')
                ->where('job_id', $jobId)
                ->orderBy('created_at', 'DESC')
                ->get();

            $filename = 'pelamar_' . str_replace(' ', '_', strtolower($job->title)) . '_' . date('Y-m-d_H-i-s') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($applications, $job) {
                $file = fopen('php://output', 'w');

                // Add BOM for UTF-8
                fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

                // CSV Headers
                fputcsv($file, [
                    'ID',
                    'Nama Pelamar',
                    'Email',
                    'No. HP',
                    'Pendidikan',
                    'Pengalaman',
                    'Gaji Diharapkan',
                    'Skills',
                    'Status',
                    'Tanggal Melamar',
                    'Cover Letter',
                    'Info Tambahan'
                ]);

                // Data rows
                foreach ($applications as $app) {
                    fputcsv($file, [
                        $app->id,
                        $app->user->name,
                        $app->user->email,
                        $app->phone_number ?: '-',
                        $app->education_level,
                        $app->experience ?: '-',
                        $app->expected_salary ?: '-',
                        $app->skills ?: '-',
                        $app->status,
                        $app->created_at->format('d/m/Y H:i'),
                        $app->cover_letter,
                        $app->additional_info ?: '-'
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengexport data: ' . $e->getMessage());
        }
    }

    /**
     * Get application statistics for a job
     */
    public function getApplicationStatistics($jobId)
    {
        try {
            $total = JobApplication::where('job_id', $jobId)->count();
            $pending = JobApplication::where('job_id', $jobId)->where('status', 'Diproses')->count();
            $accepted = JobApplication::where('job_id', $jobId)->where('status', 'Diterima')->count();
            $rejected = JobApplication::where('job_id', $jobId)->where('status', 'Ditolak')->count();

            $responseRate = $total > 0 ? round((($accepted + $rejected) / $total) * 100, 2) : 0;

            return response()->json([
                'success' => true,
                'data' => [
                    'total' => $total,
                    'pending' => $pending,
                    'accepted' => $accepted,
                    'rejected' => $rejected,
                    'response_rate' => $responseRate
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk update application status
     */
    public function bulkUpdateStatus(Request $request)
    {
        try {
            $request->validate([
                'application_ids' => 'required|array',
                'application_ids.*' => 'exists:job_applications,id',
                'status' => 'required|in:Diproses,Diterima,Ditolak'
            ]);

            $updated = JobApplication::whereIn('id', $request->application_ids)
                ->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => "Berhasil memperbarui status {$updated} pelamar"
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui status'], 500);
        }
    }
}
