@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <section id="account-dashboard" class="my-account container">
            <div class="d-flex justify-content-start mt-4 mb-5">
                <h2 class="page-title">Daftar Permintaan Pasokan</h2>
            </div>

            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    @include('layouts.account-nav')
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <div class="dashboard-content">
                        <!-- Header Section -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="content-title">Riwayat Permintaan</h3>
                            @if (!$requests->isEmpty())
                                <div class="search-container">
                                    <i class="fas fa-search"></i>
                                    <input type="text" id="requestFilter" placeholder="Cari permintaan...">
                                </div>
                            @endif
                        </div>

                        @if ($requests->isEmpty())
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <p>Belum ada permintaan yang dikirim</p>
                            </div>
                        @else
                            <!-- Request Cards -->
                            <div class="row g-4">
                                @foreach ($requests as $req)
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <div class="request-card">
                                            <!-- Card Header -->
                                            <div class="card-header">
                                                <div class="user-info">
                                                    <div class="user-meta">
                                                        <h5 class="text-truncate">{{ $req->nama }}</h5>
                                                        <span class="text-muted text-truncate">{{ $req->email }}</span>
                                                    </div>
                                                    <span
                                                        class="request-date">{{ $req->created_at->format('d M Y') }}</span>
                                                </div>
                                                <button class="btn-proof" data-bs-toggle="modal"
                                                    data-bs-target="#imageModal-{{ $req->id }}">
                                                    <i class="fas fa-image"></i>
                                                    <span>Lihat Bukti</span>
                                                </button>
                                            </div>

                                            <!-- Card Body -->
                                            <div class="card-body">
                                                <!-- Status Indicator -->
                                                <div class="status-indicator {{ $req->status }}">
                                                    @switch($req->status)
                                                        @case('pending')
                                                            <i class="fas fa-clock"></i>
                                                            <span>Dalam Proses</span>
                                                        @break

                                                        @case('disetujui')
                                                            <i class="fas fa-check-circle"></i>
                                                            <span>Disetujui</span>
                                                        @break

                                                        @case('ditolak')
                                                            <i class="fas fa-times-circle"></i>
                                                            <span>Ditolak</span>
                                                        @break
                                                    @endswitch
                                                </div>

                                                <!-- Request Details -->
                                                <div class="request-details">
                                                    <div class="detail-item">
                                                        <div class="detail-icon">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                        </div>
                                                        <div class="detail-content">
                                                            <span>Lokasi</span>
                                                            <strong class="text-truncate">{{ $req->kecamatan }},
                                                                {{ $req->desa }}</strong>
                                                        </div>
                                                    </div>

                                                    <div class="detail-item">
                                                        <div class="detail-icon">
                                                            <i class="fas fa-box"></i>
                                                        </div>
                                                        <div class="detail-content">
                                                            <span>Estimasi</span>
                                                            <strong>{{ $req->estimasi_kg }} kg</strong>
                                                        </div>
                                                    </div>

                                                    <div class="detail-item">
                                                        <div class="detail-icon">
                                                            <i class="fas fa-coins"></i>
                                                        </div>
                                                        <div class="detail-content">
                                                            <span>Insentif</span>
                                                            <strong>{{ $req->insentif === 'diskon' ? 'Diskon Produk' : 'Uang Tunai' }}</strong>
                                                        </div>
                                                    </div>

                                                    @if ($req->insentif != 'diskon')
                                                        <div class="detail-item highlight-item">
                                                            <div class="detail-icon">
                                                                <i class="fas fa-calculator"></i>
                                                            </div>
                                                            <div class="detail-content">
                                                                <span>Perkiraan Insentif</span>
                                                                <strong>Rp
                                                                    {{ number_format($req->estimasi_kg * 60000, 0, ',', '.') }}</strong>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Admin Notes -->
                                                <div class="admin-notes">
                                                    <div class="notes-header">
                                                        <i class="fas fa-comment-dots"></i>
                                                        <h6>Catatan Admin</h6>
                                                    </div>
                                                    <p class="notes-content">
                                                        {{ $req->catatan_admin ?? 'Belum ada catatan dari admin' }}
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Schedule Accordion -->
                                            <div class="schedule-accordion">
                                                <button class="accordion-header" data-bs-toggle="collapse"
                                                    data-bs-target="#sched-{{ $req->id }}">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-calendar-day me-2"></i>
                                                        <span>Lihat Jadwal Penjemputan</span>
                                                    </div>
                                                    <i class="fas fa-chevron-down toggle-icon"></i>
                                                </button>
                                                <div id="sched-{{ $req->id }}" class="accordion-body collapse">
                                                    @forelse ($req->penjadwalan->sortBy('tanggal_jemput') as $jadwal)
                                                        <div class="schedule-item">
                                                            <div class="schedule-date">
                                                                <i class="fas fa-calendar-date me-2"></i>
                                                                {{ \Carbon\Carbon::parse($jadwal->tanggal_jemput)->format('d M Y') }}
                                                            </div>
                                                            <div class="schedule-info">
                                                                <span
                                                                    class="location text-truncate">{{ $jadwal->kecamatan }},
                                                                    {{ $jadwal->desa }}</span>
                                                                <span class="status {{ $jadwal->status_jemput }}">
                                                                    {{ ucfirst($jadwal->status_jemput) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="no-schedule">
                                                            <i class="fas fa-calendar-times me-2"></i>
                                                            <span>Belum ada jadwal penjemputan</span>
                                                        </div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            <div class="pagination-container mt-4">
                                {{ $requests->withQueryString()->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Image Modal -->
    @foreach ($requests as $req)
        <div class="modal fade" id="imageModal-{{ $req->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Bukti Eceng Gondok</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <img src="{{ asset($req->foto) }}" class="modal-image" alt="Bukti Pengiriman">
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('styles')
    <style>
        :root {
            --primary: #2563eb;
            --primary-light: #dbeafe;
            --primary-dark: #1d4ed8;
            --success: #16a34a;
            --success-light: #dcfce7;
            --warning: #eab308;
            --warning-light: #fef9c3;
            --danger: #dc2626;
            --danger-light: #fee2e2;
            --light: #f8fafc;
            --light-hover: #f1f5f9;
            --dark: #0f172a;
            --gray: #64748b;
            --border: #e2e8f0;
            --orange: #ea580c;
            --orange-light: #fff7ed;
            --border-radius: 0.75rem;
        }

        /* Gaya Dasar dan Variabel */
        :root {
            --accent-color: #b9a16b;
        }

        :root {
            --primary-brown: #8B4513;
            --accent-brown: #D2B48C;
            --dark-brown: #654321;
            --light-brown: #F5E6D3;
            --cream: #FFF8DC;
            --gold: #DAA520;
            --success-green: #228B22;
            --danger-red: #DC143C;
            --warning-orange: #FF8C00;
            --info-blue: #4682B4;
            --text-dark: #2F1B14;
            --text-muted: #8B7355;
            --border-light: #E6DDD4;
            --shadow-subtle: 0 2px 8px rgba(139, 69, 19, 0.08);
            --shadow-elegant: 0 4px 20px rgba(139, 69, 19, 0.12);
            --shadow-prominent: 0 8px 32px rgba(139, 69, 19, 0.16);
            --border-radius-sm: 8px;
            --border-radius: 12px;
            --border-radius-lg: 16px;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* General */
        /* Typography */
        .page-title {
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-top: 60px !important;
            margin-bottom: 2.5rem !important;
            position: relative;
            letter-spacing: -0.025em;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, var(--primary-brown), var(--gold));
            border-radius: 2px;
        }

        .pagination {
            justify-content: center;
            margin-top: 1.5rem;
        }

        .content-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
        }

        /* Request Card */
        .request-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .request-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.08);
        }

        /* Card Header */
        .card-header {
            padding: 1.25rem;
            background: var(--light);
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .user-info {
            flex: 1;
            min-width: 0;
            margin-right: 0.75rem;
        }

        .user-meta h5 {
            font-size: 1rem;
            margin-bottom: 0.25rem;
            color: var(--dark);
            font-weight: 600;
        }

        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }

        .request-date {
            font-size: 0.8rem;
            color: var(--gray);
            display: block;
        }

        .btn-proof {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.4rem 0.75rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.35rem;
            transition: background .2s;
            font-size: 0.85rem;
            white-space: nowrap;
        }

        .btn-proof:hover {
            background: var(--primary-dark);
        }

        /* Card Body */
        .card-body {
            padding: 0;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .status-indicator {
            margin: 1rem 1rem 0;
            padding: 0.75rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .status-indicator.pending {
            background: var(--warning-light);
            color: var(--warning);
        }

        .status-indicator.disetujui {
            background: var(--success-light);
            color: var(--success);
        }

        .status-indicator.ditolak {
            background: var(--danger-light);
            color: var(--danger);
        }

        /* Request Details */
        - .request-details {
            - padding: 1rem;
            - display: grid;
            - grid-template-columns: repeat(3, 1fr);
            - gap: 0.75rem;
            -
        }

        /* Update the Request Details Grid to be more responsive */
        .request-details {
            padding: 1rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 0.75rem;
        }

        /* Add highlight for incentive calculation */
        .highlight-item {
            background: rgba(37, 99, 235, 0.05);
            border: 1px solid rgba(37, 99, 235, 0.1);
            transition: background .2s, transform .1s;
        }

        .highlight-item:hover {
            background: rgba(37, 99, 235, 0.1);
            transform: translateY(-2px);
        }

        .highlight-item .detail-icon {
            background: rgba(37, 99, 235, 0.2);
        }

        /* Animation for newly added incentive display */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .highlight-item {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .detail-item {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            padding: 0.75rem;
            background: var(--light);
            border-radius: 0.5rem;
            transition: background .2s;
        }

        .detail-item:hover {
            background: var(--light-hover);
        }

        .detail-icon {
            color: var(--primary);
            font-size: 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 2rem;
            height: 2rem;
            background: var(--primary-light);
            border-radius: 50%;
        }

        .detail-content {
            flex: 1;
            min-width: 0;
        }

        .detail-content span {
            display: block;
            font-size: 0.7rem;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-content strong {
            font-size: 0.9rem;
            color: var(--dark);
            font-weight: 600;
        }

        /* Admin Notes */
        .admin-notes {
            margin: 0 1rem 1rem;
            padding: 1rem;
            background: var(--orange-light);
            border-radius: 0.5rem;
            border-left: 3px solid #fdba74;
        }

        .notes-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .notes-header i {
            color: var(--orange);
        }

        .notes-header h6 {
            margin: 0;
            color: var(--orange);
            font-size: 0.9rem;
            font-weight: 600;
        }

        .notes-content {
            color: #57534e;
            margin: 0;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        /* Schedule Accordion */
        .schedule-accordion {
            border-top: 1px solid var(--border);
            margin-top: auto;
        }

        .accordion-header {
            width: 100%;
            padding: 1rem;
            background: var(--light);
            border: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--dark);
            font-weight: 500;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background .2s;
        }

        .accordion-header:hover {
            background: var(--light-hover);
        }

        .toggle-icon {
            transition: transform .3s;
        }

        .accordion-header[aria-expanded="true"] .toggle-icon {
            transform: rotate(180deg);
        }

        .accordion-body {
            padding: 0.75rem 1rem;
            max-height: 250px;
            overflow-y: auto;
        }

        .schedule-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border);
        }

        .schedule-item:last-child {
            border-bottom: none;
        }

        .schedule-date {
            font-weight: 500;
            color: var(--dark);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }

        .schedule-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .location {
            color: var(--gray);
            font-size: 0.85rem;
            max-width: 120px;
        }

        .status {
            padding: 0.2rem 0.6rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
            white-space: nowrap;
        }

        .status.terjadwal {
            background: var(--primary-light);
            color: var(--primary);
        }

        .status.dijemput {
            background: var(--success-light);
            color: var(--success);
        }

        .status.dibatalkan {
            background: var(--danger-light);
            color: var(--danger);
        }

        .no-schedule {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 1rem;
            color: var(--gray);
            font-size: 0.9rem;
        }

        /* Modal */
        .modal-image {
            width: 100%;
            height: 60vh;
            object-fit: contain;
            border-radius: 0.5rem;
        }

        /* Empty State */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            background: var(--light);
            border-radius: var(--border-radius);
            color: var(--gray);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
    </style>
@endpush
