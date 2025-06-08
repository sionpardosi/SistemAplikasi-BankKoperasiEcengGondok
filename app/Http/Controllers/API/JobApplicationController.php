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

            $request->validate([
                'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
                'cover_letter' => 'required|string',
                'phone_number' => 'required|string',
                'education_level' => 'required|string',
                'experience' => 'nullable|string',
                'expected_salary' => 'nullable|string',
                'skills' => 'required|string',
                'additional_info' => 'nullable|string',
            ]);

            $existingApplication = JobApplication::where('user_id', $user->id)
                ->where('job_id', $jobId)
                ->first();
            if ($existingApplication) {
                return $this->sendError('Anda sudah pernah melamar untuk lowongan ini', [], 400);
            }

            // Simpan file CV
            $cvPath = $request->file('cv')->store('cv', 'public');

            JobApplication::create([
                'job_id' => $jobId,
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

            return response()->json(['success' => true, 'message' => 'Lamaran berhasil dikirim!']);
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

    // Menampilkan daftar lamaran untuk job tertentu (ADMIN)
    public function getJobApplications($job_id)
    {
        try {
            $applications = \App\Models\JobApplication::with('user')
                ->where('job_id', $job_id)
                ->orderBy('created_at', 'DESC')
                ->get();

            return $this->sendResponse($applications, 'Daftar lamaran berhasil diambil');
        } catch (\Exception $e) {
            return $this->sendError('Gagal mengambil data lamaran', ['error' => $e->getMessage()], 500);
        }
    }

    public function showApplications($id)
    {
        $applications = JobApplication::with(['user', 'job'])
            ->where('job_id', $id)
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $applications
        ]);
    }

    public function index($id)
    {
          $applications = JobApplication::with('user')->where('job_id', $id)->get();

    $token = auth()->user()->createToken('auth_token')->plainTextToken;

    return view('admin.job_applications', [
        'applications' => $applications,
        'jobId' => $id,
        'token' => $token,
    ]);
    }

    public function destroy($id)
    {
        try {
            $application = \App\Models\JobApplication::find($id);
            if (!$application) {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
            }
            $application->delete();
            return response()->json(['success' => true, 'message' => 'Data pelamar dihapus']);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus data pelamar'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $app = \App\Models\JobApplication::findOrFail($id);
        $app->update($request->only([
            'phone_number', 'education_level', 'experience', 'expected_salary', 'skills', 'additional_info'
        ]));
        return response()->json(['success' => true, 'message' => 'Data pelamar diperbarui']);
    }
}
