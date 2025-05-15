@extends('layouts.admin')

@section('content')
    <style>
        .form-group label {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 6px;
            margin-top: 16px;
        }

        .form-control {
            font-size: 14px !important;
            padding: 10px;
            margin-bottom: 10px;
        }

        .btn-primary {
            font-size: 14px !important;
            padding: 10px 15px;
        }
    </style>
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Tambah Lowongan Kerja</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Lowongan Kerja</div>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Tambah</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <form id="createJobForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Judul Pekerjaan</label>
                        <input type="text" id="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Pekerjaan</label>
                        <textarea id="description" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select id="category" class="form-control" required>
                            <option value="Full-time">Full-time</option>
                            <option value="Part-time">Part-time</option>
                            <option value="Freelance">Freelance</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Gaji</label>
                        <input type="number" id="salary" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tipe Gaji</label>
                        <select id="salary_type" class="form-control" required>
                            <option value="Per Jam">Per Jam</option>
                            <option value="Per Hari">Per Hari</option>
                            <option value="Per Bulan">Per Bulan</option>
                            <option value="Proyek">Proyek</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Durasi</label>
                        <input type="text" id="duration" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Target</label>
                        <input type="text" id="target" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Lokasi</label>
                        <input type="text" id="location" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Persyaratan</label>
                        <textarea id="requirements" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Benefit</label>
                        <textarea id="benefits" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Deadline Lamaran</label>
                        <input type="date" id="deadline" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Gambar (Opsional)</label>
                        <input type="file" id="image" class="form-control"
                            accept="image/jpeg,image/png,image/jpg,image/gif">
                        <small class="text-muted">Format yang didukung: JPEG, PNG, JPG, GIF (maks. 2MB)</small>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select id="status" class="form-control" required>
                            <option value="Dibuka">Dibuka</option>
                            <option value="Ditutup">Ditutup</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="submitJob()">Tambah Lowongan</button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function submitJob() {
                // Create FormData object to handle file uploads
                let formData = new FormData();

                // Add all form fields to FormData
                formData.append('title', $("#title").val());
                formData.append('description', $("#description").val());
                formData.append('category', $("#category").val());
                formData.append('salary', $("#salary").val());
                formData.append('salary_type', $("#salary_type").val());
                formData.append('duration', $("#duration").val());
                formData.append('target', $("#target").val());
                formData.append('location', $("#location").val());
                formData.append('requirements', $("#requirements").val());
                formData.append('benefits', $("#benefits").val());
                formData.append('deadline', $("#deadline").val());
                formData.append('status', $("#status").val());

                // Add image file if uploaded
                if ($("#image")[0].files[0]) {
                    formData.append('image', $("#image")[0].files[0]);
                }

                $.ajax({
                    url: "{{ url('/api/admin/jobs') }}",
                    type: "POST",
                    data: formData,
                    contentType: false, // Required for FormData
                    processData: false, // Required for FormData
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token'),
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Lowongan kerja berhasil ditambahkan',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            window.location.href = "{{ route('admin.jobs') }}";
                        });
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = 'Terjadi kesalahan, coba lagi!';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            title: 'Error!',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        </script>
    @endpush
@endsection
