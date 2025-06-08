@extends('layouts.admin')

@section('content')
    <style>
        .table-striped th:nth-child(1),
        .table-striped td:nth-child(1) {
            width: 80px;
        }

        .table-striped th:nth-child(2),
        .table-striped td:nth-child(2) {
            width: 200px;
        }

        .table-striped th:nth-child(3),
        .table-striped td:nth-child(3) {
            width: 300px;
        }

        .status-select {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Daftar Pelamar - <span id="job-title"></span></h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Pelamar</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pelamar</th>
                                    <th>Email</th>
                                    <th>CV</th>
                                    <th>Surat Lamaran</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="applications-table">
                                @foreach($applications as $index => $app)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $app->user->name ?? '-' }}</td>
                                        <td>{{ $app->user->email ?? '-' }}</td>
                                        <td>
                                            @if($app->cv)
                                                <a href="{{ asset('storage/' . $app->cv) }}" target="_blank" class="btn btn-sm btn-info mb-1">Lihat CV</a>
                                            @endif
                                            @if($app->image)
                                                <br>
                                                <a href="{{ asset('storage/' . $app->image) }}" target="_blank" class="btn btn-sm btn-warning mb-1">Lihat Gambar</a>
                                                <br>
                                                <img src="{{ asset('storage/' . $app->image) }}" alt="Image" style="max-width:80px;max-height:80px;border-radius:6px;margin-top:5px;">
                                            @endif
                                            @if(!$app->cv && !$app->image)
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $app->cover_letter ?? '-' }}</td>
                                        <td>{{ $app->status ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination" id="pagination">
                        {{-- Pagination --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // const jobId = "{{ request()->route('id') }}";
            const jobId = "{{ $jobId }}";
            const apiUrl = `http://127.0.0.1:8000/api/admin/jobs/${jobId}/applications`;
            const tableBody = document.getElementById("applications-table");
            const jobTitle = document.getElementById("job-title");
            console.log("Debug Job ID:", jobId); // Pastikan ini cetak 3 atau 4

            function fetchApplications() {
                fetch(apiUrl, {
                        method: "GET",
                        headers: {
                            "Content-Type": "application/json",
                            "Authorization": "Bearer {{ $token }}"
                            // "Authorization": "Bearer {{ auth()->user()->createToken('auth_token')->plainTextToken }}"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            tableBody.innerHTML = "";
                            jobTitle.innerText = data.data.[0]?.job?.title ?? "Nama Pekerjaan";

                            data.data.forEach((app, index) => {
                                const row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${app.user.name}</td>
                                    <td>${app.user.email}</td>
                                    <td>
                                        ${
                                            app.cv
                                                ? `<a href="/storage/${app.cv}" target="_blank" class="btn btn-sm btn-info mb-1">Lihat CV</a><br>`
                                                : ''
                                        }
                                        ${
                                            app.image
                                                ? `<a href="/storage/${app.image}" target="_blank" class="btn btn-sm btn-warning mb-1">Lihat Gambar</a>
                                                   <br>
                                                   <img src="/storage/${app.image}" alt="Image" style="max-width:80px;max-height:80px;border-radius:6px;margin-top:5px;">`
                                                : ''
                                        }
                                        ${
                                            !app.cv && !app.image
                                                ? '-'
                                                : ''
                                        }
                                    </td>
                                    <td>${app.cover_letter}</td>
                                    <td>
                                        <select class="status-select" data-id="${app.id}">
                                            <option value="Diproses" ${app.status === 'Diproses' ? 'selected' : ''}>Diproses</option>
                                            <option value="Diterima" ${app.status === 'Diterima' ? 'selected' : ''}>Diterima</option>
                                            <option value="Ditolak" ${app.status === 'Ditolak' ? 'selected' : ''}>Ditolak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm update-status" data-id="${app.id}">Simpan</button>
                                    </td>
                                </tr>
                            `;
                                tableBody.innerHTML += row;
                            });

                            attachEventListeners();
                        } else {
                            tableBody.innerHTML =
                                "<tr><td colspan='7' class='text-center text-danger'>Gagal memuat data pelamar.</td></tr>";
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching job applications:", error);
                        tableBody.innerHTML =
                            "<tr><td colspan='7' class='text-center text-danger'>Terjadi kesalahan.</td></tr>";
                    });
            }

            function attachEventListeners() {
                document.querySelectorAll(".update-status").forEach(button => {
                    button.addEventListener("click", function() {
                        const applicationId = this.getAttribute("data-id");
                        const status = document.querySelector(
                            `.status-select[data-id='${applicationId}']`).value;
                        updateApplicationStatus(applicationId, status);
                    });
                });
            }

            function updateApplicationStatus(applicationId, status) {
                fetch(`http://127.0.0.1:8000/api/admin/applications/${applicationId}/update`, {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                            "Authorization": "Bearer {{ auth()->user()->createToken('auth_token')->plainTextToken }}"
                        },
                        body: JSON.stringify({
                            status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Status pelamar diperbarui",
                                icon: "success",
                                confirmButtonText: "OK"
                            });
                        } else {
                            Swal.fire({
                                title: "Gagal!",
                                text: "Gagal memperbarui status",
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        }
                    })
                    .catch(error => {
                        console.error("Error updating application status:", error);
                    });
            }

            fetchApplications();
        });
    </script>
@endpush
