@extends('layouts.admin')

@section('content')
    <style>
        .form-group label {
            font-size: 16px;
            /* Ukuran font label */
            font-weight: bold;
            margin-bottom: 6px;
            margin-top: 16px;
        }

        .form-control {
            font-size: 14px !important;
            /* Ukuran teks input */
            padding: 10px;
            margin-bottom: 10px;
            /* Ruang padding agar lebih luas */
        }

        .btn-primary {
            font-size: 14px !important;
            /* Ukuran teks tombol */
            padding: 10px 15px;
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Lowongan Kerja</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li><a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Lowongan Kerja</div>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Edit</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <form id="editJobForm">
                    @csrf
                    <input type="hidden" id="job_id" value="{{ $id }}">
                    <div class="form-group">
                        <label>Judul Pekerjaan</label>
                        <input type="text" id="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Pekerjaan</label>
                        <textarea id="description" class="form-control" required></textarea>
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
                        <label>Status</label>
                        <select id="status" class="form-control" required>
                            <option value="Dibuka">Dibuka</option>
                            <option value="Ditutup">Ditutup</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="updateJob()" style="margin-top:20px;">Simpan
                        Perubahan</button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                let jobId = $("#job_id").val();

                $.ajax({
                    url: "{{ url('/api/admin/jobs') }}/" + jobId,
                    type: "GET",
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    },
                    success: function(response) {
                        let job = response.data;
                        $("#title").val(job.title);
                        $("#description").val(job.description);
                        $("#category").val(job.category);
                        $("#salary").val(job.salary);
                        $("#salary_type").val(job.salary_type);
                        $("#duration").val(job.duration);
                        $("#target").val(job.target);
                        $("#location").val(job.location);
                        $("#status").val(job.status);
                    }
                });
            });

            function updateJob() {
                let jobId = $("#job_id").val();
                let formData = {
                    title: $("#title").val(),
                    description: $("#description").val(),
                    category: $("#category").val(),
                    salary: $("#salary").val(),
                    salary_type: $("#salary_type").val(),
                    duration: $("#duration").val(),
                    target: $("#target").val(),
                    location: $("#location").val(),
                    status: $("#status").val()
                };

                $.ajax({
                    url: "{{ url('/api/admin/jobs') }}/" + jobId,
                    type: "PUT",
                    data: formData,
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    },
                    success: function() {
                        alert("Lowongan berhasil diperbarui!");
                        window.location.href = "{{ route('admin.jobs') }}";
                    }
                });
            }
        </script>
    @endpush
@endsection
