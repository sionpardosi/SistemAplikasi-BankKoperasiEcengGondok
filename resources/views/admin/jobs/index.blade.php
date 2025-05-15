@extends('layouts.admin')

@section('content')
    <style>
        .table-striped th:nth-child(1),
        .table-striped td:nth-child(1) {
            width: 100px;
        }

        .table-striped th:nth-child(2),
        .table-striped td:nth-child(2) {
            width: 250px;
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Lowongan Kerja</h3>
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
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <input type="text" id="search" class="form-control" placeholder="Cari lowongan..."
                            style="height: 50px; font-size: 16px;">
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.jobs.add') }}">
                        <i class="icon-plus"></i> Tambah Lowongan
                    </a>
                </div>

                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Gaji</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="job-table">
                                <tr>
                                    <td colspan="7" class="text-center">Memuat data...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                        <ul id="pagination" class="pagination"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            loadJobs();

            function loadJobs(page = 1) {
                $.ajax({
                    url: `/api/jobs?page=${page}`,
                    type: 'GET',
                    success: function(response) {
                        let jobs = response.data.data;
                        let html = '';
                        if (jobs.length > 0) {
                            jobs.forEach(job => {
                                html += `
                                    <tr>
                                        <td>${job.id}</td>
                                        <td><a href="/admin/jobs/${job.id}/applications">${job.title}</a></td>
                                        <td>${job.category}</td>
                                        <td>Rp${parseFloat(job.salary).toLocaleString()} / ${job.salary_type}</td>
                                        <td>${job.location}</td>
                                        <td>
                                            <span class="badge
                                                ${job.status == 'Dibuka' ? 'bg-success' : (job.status == 'Ditutup' ? 'bg-danger' : 'bg-secondary')}">
                                                ${job.status}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="list-icon-function">
                                                <a href="{{ url('admin/jobs/edit') }}/${job.id}">
                                                    <div class="item edit">
                                                        <i class="icon-edit-3"></i>
                                                    </div>
                                                </a>
                                                <button class="delete" data-id="${job.id}">
                                                    <div class="item text-danger">
                                                        <i class="icon-trash-2"></i>
                                                    </div>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                `;
                            });
                        } else {
                            html = '<tr><td colspan="7" class="text-center">Tidak ada data</td></tr>';
                        }
                        $('#job-table').html(html);
                        setupPagination(response.data);
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }

            function setupPagination(data) {
                let paginationHTML = '';
                if (data.prev_page_url) {
                    paginationHTML +=
                        `<li class="page-item"><a class="page-link" href="#" data-page="${data.current_page - 1}">&laquo;</a></li>`;
                }
                for (let i = 1; i <= data.last_page; i++) {
                    paginationHTML += `<li class="page-item ${data.current_page == i ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>`;
                }
                if (data.next_page_url) {
                    paginationHTML +=
                        `<li class="page-item"><a class="page-link" href="#" data-page="${data.current_page + 1}">&raquo;</a></li>`;
                }
                $('#pagination').html(paginationHTML);
            }

            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                let page = $(this).data('page');
                loadJobs(page);
            });

            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                let jobId = $(this).data('id');
                swal({
                    title: "Apakah Anda yakin?",
                    text: "Lowongan ini akan dihapus secara permanen!",
                    type: "warning",
                    buttons: ["Batal", "Ya, hapus!"],
                    confirmButtonColor: '#dc3545'
                }).then(function(result) {
                    if (result) {
                        $.ajax({
                            url: `/api/admin/jobs/${jobId}`,
                            type: 'DELETE',
                            success: function(response) {
                                loadJobs();
                            },
                            error: function(err) {
                                console.log(err);
                            }
                        });
                    }
                });
            });

            $('#search').on('keyup', function() {
                let keyword = $(this).val().toLowerCase();
                $('#job-table tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(keyword) > -1);
                });
            });
        });
    </script>
@endpush

