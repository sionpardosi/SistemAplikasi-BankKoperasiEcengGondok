<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Models\JobList;
use Illuminate\Support\Facades\Storage;

class JobController extends BaseController
{
    // Menampilkan daftar lowongan kerja
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
                $query->where(function($q) use ($searchTerm) {
                    $q->where('title', 'like', '%' . $searchTerm . '%')
                      ->orWhere('description', 'like', '%' . $searchTerm . '%')
                      ->orWhere('location', 'like', '%' . $searchTerm . '%');
                });
            }

            // Order by latest by default
            $query->orderBy('created_at', 'DESC');

            $jobs = $query->paginate(10);
            return $this->sendResponse($jobs, 'Daftar lowongan kerja berhasil diambil');
        } catch (\Exception $e) {
            return $this->sendError('Gagal mengambil data lowongan kerja', ['error' => $e->getMessage()], 500);
        }
    }

    // Menambahkan lowongan kerja
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
            ]);

            $data = $request->all();

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('job_images', 'public');
                $data['image'] = $imagePath;
            } else {
                // Set default image based on job category
                $category = $request->category;
                switch ($category) {
                    case 'Full-time':
                        $data['image'] = 'job_images/default/full-time.jpg';
                        break;
                    case 'Part-time':
                        $data['image'] = 'job_images/default/part-time.jpg';
                        break;
                    case 'Freelance':
                        $data['image'] = 'job_images/default/freelance.jpg';
                        break;
                    default:
                        $data['image'] = 'job_images/default/job.jpg';
                }
            }

            $job = JobList::create($data);
            return $this->sendResponse($job, 'Lowongan kerja berhasil dibuat');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->sendError('Validasi gagal', $e->errors(), 422);
        } catch (\Exception $e) {
            return $this->sendError('Gagal membuat lowongan kerja', ['error' => $e->getMessage()], 500);
        }
    }

    // Menampilkan detail lowongan
    public function show($id)
    {
        try {
            $job = JobList::find($id);
            if (!$job) {
                return $this->sendError('Lowongan kerja tidak ditemukan', [], 404);
            }
            return $this->sendResponse($job, 'Detail lowongan kerja berhasil diambil');
        } catch (\Exception $e) {
            return $this->sendError('Gagal mengambil detail lowongan kerja', ['error' => $e->getMessage()], 500);
        }
    }

    // Mengupdate lowongan
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
                    Storage::disk('public')->delete($job->image);
                }

                $imagePath = $request->file('image')->store('job_images', 'public');
                $data['image'] = $imagePath;
            }

            $job->update($data);
            return $this->sendResponse($job, 'Lowongan kerja berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->sendError('Validasi gagal', $e->errors(), 422);
        } catch (\Exception $e) {
            return $this->sendError('Gagal memperbarui lowongan kerja', ['error' => $e->getMessage()], 500);
        }
    }

    // Menghapus lowongan kerja
    public function destroy($id)
    {
        try {
            $job = JobList::find($id);
            if (!$job) {
                return $this->sendError('Lowongan kerja tidak ditemukan', [], 404);
            }

            // Delete job image if it's not a default image
            if ($job->image && !str_contains($job->image, 'default/')) {
                Storage::disk('public')->delete($job->image);
            }

            $job->delete();
            return $this->sendResponse([], 'Lowongan kerja berhasil dihapus');
        } catch (\Exception $e) {
            return $this->sendError('Gagal menghapus lowongan kerja', ['error' => $e->getMessage()], 500);
        }
    }
}
