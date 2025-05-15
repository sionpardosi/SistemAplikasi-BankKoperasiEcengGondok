<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\JobApplication;
use App\Models\JobList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class JobApplicationController extends BaseController
{
    // Melamar pekerjaan
    public function apply(Request $request, $job_id)
    {
        try {
            $job = JobList::find($job_id);
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

            $validated = $request->validate([
                'cv' => 'required|mimes:pdf,doc,docx|max:2048',
                'cover_letter' => 'required|string|min:50',
                'phone_number' => 'required|string|min:10',
                'education_level' => 'required|string',
                'experience' => 'nullable|string',
                'expected_salary' => 'nullable|string',
                'skills' => 'required|string',
                'additional_info' => 'nullable|string',
            ]);

            $existingApplication = JobApplication::where('user_id', $user->id)
                ->where('job_id', $job_id)
                ->first();
            if ($existingApplication) {
                return $this->sendError('Anda sudah pernah melamar untuk lowongan ini', [], 400);
            }

            $destinationPath = 'uploads/cv_uploads/' . date('Y/m');
            $cvFile = $request->file('cv');
            $cvFileName = time() . '_' . $user->id . '_' . $cvFile->getClientOriginalName();
            $cvPath = $cvFile->storeAs($destinationPath, $cvFileName, 'public');

            $application = JobApplication::create([
                'job_id' => $job_id,
                'user_id' => $user->id,
                'cv' => $cvPath,
                'cover_letter' => $request->cover_letter,
                'phone_number' => $request->phone_number,
                'education_level' => $request->education_level,
                'experience' => $request->experience,
                'expected_salary' => $request->expected_salary,
                'skills' => $request->skills,
                'additional_info' => $request->additional_info,
                'status' => 'Diproses',
            ]);

            return $this->sendResponse($application, 'Lamaran Anda berhasil dikirim! Kami akan meninjau lamaran Anda segera.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->sendError('Validasi gagal', $e->errors(), 422);
        } catch (\Exception $e) {
            return $this->sendError('Terjadi kesalahan saat mengirim lamaran', ['error' => $e->getMessage()], 500);
        }
    }

    // Menampilkan daftar lamaran user
    public function userApplications()
    {
        try {
            $user = Auth::guard('sanctum')->user();

            // If no authenticated user found, use alternative authentication
            if (!$user && Auth::check()) {
                $user = Auth::user();
            }

            // If still no user found, return error
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

    // Update status lamaran
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
        } catch (\Exception $e) {
            return $this->sendError('Gagal memperbarui status lamaran', ['error' => $e->getMessage()], 500);
        }
    }

    public function getJobApplications($job_id)
    {
        try {
            $job = JobList::find($job_id);

            if (!$job) {
                return $this->sendError('Lowongan pekerjaan tidak ditemukan', [], 404);
            }

            // Ambil semua pelamar untuk lowongan ini
            $applications = JobApplication::where('job_id', $job_id)
                ->with('user:id,name,email,created_at') // Hanya ambil ID, Nama, dan Email user
                ->orderBy('created_at', 'DESC')
                ->paginate(10);

            return $this->sendResponse($applications, 'Data pelamar berhasil diambil');
        } catch (\Exception $e) {
            return $this->sendError('Gagal mengambil data pelamar', ['error' => $e->getMessage()], 500);
        }
    }
}
