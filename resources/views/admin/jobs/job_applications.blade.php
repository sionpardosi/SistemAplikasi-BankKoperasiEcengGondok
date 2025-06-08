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

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
        }

        .modal-header,
        .modal-body {
            margin-bottom: 15px;
        }

        .modal-close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
        }

        .modal-close:hover,
        .modal-close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

    <h1>Debug ID: {{ $jobId }}</h1>
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
                                <tr>
                                    <td colspan="7" class="text-center">Memuat data...</td>
                                </tr>
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

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <h2>Edit Lamaran</h2>
            <form id="editForm">
                <div class="form-group">
                    <label for="phone">No HP:</label>
                    <input type="text" id="phone" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="education">Pendidikan:</label>
                    <input type="text" id="education" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="experience">Pengalaman:</label>
                    <input type="text" id="experience" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="salary">Gaji:</label>
                    <input type="number" id="salary" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="skills">Skills:</label>
                    <input type="text" id="skills" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="additional-info">Info Tambahan:</label>
                    <input type="text" id="additional-info" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-danger" id="cancelEditBtn">Batal</button>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const jobId = "{{ request()->route('id') }}";
            const apiUrl = `http://127.0.0.1:8000/api/admin/jobs/${jobId}/applications`;
            const tableBody = document.getElementById("applications-table");
            const jobTitle = document.getElementById("job-title");

            function fetchApplications() {
                fetch(apiUrl, {
                        method: "GET",
                        headers: {
                            "Content-Type": "application/json",
                            "Authorization": "Bearer {{ auth()->user()->createToken('auth_token')->plainTextToken }}"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            tableBody.innerHTML = "";
                            jobTitle.innerText = data.data.data[0]?.job?.title ?? "Nama Pekerjaan";

                            data.data.data.forEach((app, index) => {
                                const row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${app.user.name}</td>
                                    <td>${app.user.email}</td>
                                    <td>
                                        <a href="/storage/${app.cv}" target="_blank" class="btn btn-sm btn-info">Lihat CV</a>
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
                                        <button class="btn btn-warning btn-sm edit-app" data-id="${app.id}">Edit</button>
                                        <button class="btn btn-danger btn-sm delete-app" data-id="${app.id}">Hapus</button>
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
                // Event listener untuk tombol edit
                document.querySelectorAll(".edit-app").forEach(button => {
                    button.addEventListener("click", function() {
                        const applicationId = this.getAttribute("data-id");
                        openEditModal(applicationId);
                    });
                });

                // Event listener untuk tombol hapus
                document.querySelectorAll(".delete-app").forEach(button => {
                    button.addEventListener("click", function() {
                        const applicationId = this.getAttribute("data-id");
                        deleteApplication(applicationId);
                    });
                });
            }

            // Fungsi untuk membuka modal edit
            function openEditModal(applicationId) {
                const modal = document.getElementById("editModal");
                const closeModalBtn = document.querySelector(".modal-close");
                const cancelEditBtn = document.getElementById("cancelEditBtn");

                // Ambil data aplikasi
                fetch(`http://127.0.0.1:8000/api/admin/applications/${applicationId}`, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": "Bearer {{ auth()->user()->createToken('auth_token')->plainTextToken }}"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const app = data.data;
                    document.getElementById("phone").value = app.phone_number ?? '';
                    document.getElementById("education").value = app.education_level ?? '';
                    document.getElementById("experience").value = app.experience ?? '';
                    document.getElementById("salary").value = app.expected_salary ?? '';
                    document.getElementById("skills").value = app.skills ?? '';
                    document.getElementById("additional-info").value = app.additional_info ?? '';
                });

                modal.style.display = "block";

                closeModalBtn.addEventListener("click", () => {
                    modal.style.display = "none";
                });

                cancelEditBtn.addEventListener("click", () => {
                    modal.style.display = "none";
                });

                // Submit form untuk update data
                const editForm = document.getElementById("editForm");
                editForm.addEventListener("submit", function(event) {
                    event.preventDefault();
                    const updatedData = {
                        phone_number: document.getElementById("phone").value,
                        education_level: document.getElementById("education").value,
                        experience: document.getElementById("experience").value,
                        expected_salary: document.getElementById("salary").value,
                        skills: document.getElementById("skills").value,
                        additional_info: document.getElementById("additional-info").value,
                    };
                    updateApplication(applicationId, updatedData);
                });
            }

            // Fungsi untuk mengupdate aplikasi
            function updateApplication(applicationId, updatedData) {
                fetch(`http://127.0.0.1:8000/api/admin/applications/${applicationId}/update`, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": "Bearer {{ auth()->user()->createToken('auth_token')->plainTextToken }}"
                    },
                    body: JSON.stringify(updatedData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire("Berhasil!", "Data pelamar diperbarui.", "success");
                        fetchApplications();
                        document.getElementById("editModal").style.display = "none";
                    } else {
                        Swal.fire("Gagal!", "Gagal memperbarui data.", "error");
                    }
                });
            }

            // Fungsi hapus data pelamar
            function deleteApplication(applicationId) {
                Swal.fire({
                    title: 'Hapus Lamaran?',
                    text: "Data pelamar akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`http://127.0.0.1:8000/api/admin/applications/${applicationId}/delete`, {
                            method: "DELETE",
                            headers: {
                                "Content-Type": "application/json",
                                "Authorization": "Bearer {{ auth()->user()->createToken('auth_token')->plainTextToken }}"
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire("Berhasil!", "Data pelamar dihapus.", "success");
                                fetchApplications();
                            } else {
                                Swal.fire("Gagal!", "Gagal menghapus data pelamar.", "error");
                            }
                        });
                    }
                });
            }

            fetchApplications();
        });
    </script>
@endpush
