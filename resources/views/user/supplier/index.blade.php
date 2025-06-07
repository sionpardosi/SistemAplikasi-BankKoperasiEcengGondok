@extends('layouts.app')

@section('content')
    <!-- Style for css all halaman -->
    <style>
        :root {
            --primary-color: #000000;
            --accent-color: #956a3b;
            --accent-hover: #7a5130;
            --light-bg: #f8f9fa;
            --card-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        /* Placeholder */

        /* Add this to your existing CSS to style placeholders differently */
        ::placeholder {
            color: #b3b3b3 !important;
            /* Lighter gray color for placeholders */
            font-style: italic;
            /* Makes placeholders appear in italic */
            opacity: 0.7;
            /* Reduces opacity for visual distinction */
        }

        /* For Microsoft Edge */
        ::-ms-input-placeholder {
            color: #b3b3b3 !important;
            font-style: italic;
            opacity: 0.7;
        }

        /* For Firefox */
        ::-moz-placeholder {
            color: #b3b3b3 !important;
            font-style: italic;
            opacity: 0.7;
        }

        /* For Safari and Chrome */
        ::-webkit-input-placeholder {
            color: #b3b3b3 !important;
            font-style: italic;
            opacity: 0.7;
        }

        /* General Button */
        .btn-become {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: #fff;
            transition: var(--transition);
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 6px;
            box-shadow: 0 4px 10px rgba(149, 106, 59, 0.2);
        }

        .btn-become:hover {
            background-color: var(--accent-hover);
            border-color: var(--accent-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(149, 106, 59, 0.3);
        }

        /* Hero Section */
        .hero-section {
            padding: 180px 0 80px;
            background: linear-gradient(rgba(255, 255, 255, 0.92), rgba(255, 255, 255, 0.92)),
                url('{{ asset('assets/images/shop/shop_banner1.jpg') }}') center/cover no-repeat;
            position: relative;
            overflow: hidden;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 60px;
            background: linear-gradient(transparent, rgba(248, 249, 250, 0.8));
        }

        .hero-section h1 {
            font-size: 3.2rem;
            margin-top: -9%;
            color: var(--primary-color);
            font-weight: 800;
            line-height: 1.2;
            transition: var(--transition);
        }

        .hero-section h1 span {
            color: var(--accent-color);
            position: relative;
        }

        .hero-section h1 span::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: var(--accent-color);
            transform: scaleX(0);
            transition: transform 0.5s ease;
            transform-origin: left;
        }

        .hero-section:hover h1 span::after {
            transform: scaleX(1);
        }

        .hero-section .lead {
            font-size: 1.25rem;
            line-height: 1.8;
            margin-bottom: 2rem;
        }

        .hero-section .highlight {
            background-color: rgba(149, 106, 59, 0.1);
            padding: 2px 6px;
            border-radius: 4px;
            color: var(--accent-color);
            font-weight: 600;
        }

        /* Info Section */
        .info-section h2 {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .info-section h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 80px;
            height: 4px;
            background-color: var(--accent-color);
        }

        .info-section .lead {
            font-size: 1.2rem;
            line-height: 1.8;
        }

        .info-list {
            padding-left: 0;
            list-style: none;
            margin-top: 2rem;
        }

        .info-list li {
            padding: 12px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            font-size: 1.1rem;
            transition: var(--transition);
        }

        .info-list li:hover {
            transform: translateX(5px);
        }

        .info-list li i {
            margin-right: 15px;
            font-size: 1.5rem;
            color: var(--accent-color);
            min-width: 30px;
            text-align: center;
        }

        /* Benefits Section */
        .benefits {
            background: var(--light-bg);
            padding: 80px 0;
            position: relative;
        }

        .benefits::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 10px;
            background-image: linear-gradient(45deg, var(--accent-color) 25%, transparent 25%, transparent 50%, var(--accent-color) 50%, var(--accent-color) 75%, transparent 75%, transparent);
            background-size: 20px 20px;
            opacity: 0.3;
        }

        .benefit-card {
            border: none;
            border-radius: 12px;
            transition: var(--transition);
            background-color: #fff;
            box-shadow: var(--card-shadow);
            padding: 30px 25px;
            height: 100%;
        }

        .benefit-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
        }

        .benefit-icon {
            font-size: 3rem;
            color: var(--accent-color);
            margin-bottom: 1.25rem;
            display: inline-block;
            transition: var(--transition);
        }

        .benefit-card:hover .benefit-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .counter {
            font-size: 3rem;
            font-weight: 800;
            color: var(--primary-color);
            line-height: 1;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .counter::after {
            content: '+';
            font-size: 1.5rem;
            margin-left: 5px;
            color: var(--accent-color);
        }

        .counter-label {
            font-size: 1.1rem;
            color: #666;
            font-weight: 500;
        }

        /* Requirements Card */
        .requirements-card {
            background-color: #fff;
            box-shadow: var(--card-shadow);
            border-radius: 12px;
            padding: 30px;
            transition: var(--transition);
            cursor: pointer;
            border-left: 5px solid var(--accent-color);
            margin-top: 60px;
        }

        .requirements-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .requirements-card h3 {
            color: var(--primary-color);
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        /* Modal Style */
        .modal-header {
            background-color: #956a3b;
            /* Warna coklat elegan sebagai contoh accent-color */
            color: #fff;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            padding: 20px 30px;
        }

        .modal-title {
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }

        .modal-body {
            max-height: 70vh;
            overflow-y: auto;
            padding: 30px;
            background-color: #f9f9f9;
            /* Latar belakang lembut */
        }

        .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        /* Form Styling */
        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #956a3b;
            box-shadow: 0 0 0 3px rgba(149, 106, 59, 0.1);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }

        .form-control:focus.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }

        /* Shake animation for invalid input */
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-5px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(5px);
            }
        }

        .input-shake {
            animation: shake 0.6s ease-in-out;
        }

        /* Leading zero tooltip animation */
        .leading-zero-tooltip {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            animation: fadeInOut 2s ease-in-out;
        }

        @keyframes fadeInOut {
            0% {
                opacity: 0;
            }

            15% {
                opacity: 1;
            }

            85% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }

        .input-group-text {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px 0 0 8px;
            color: #956a3b;
        }

        label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #444;
            /* Darker color for labels to contrast with placeholders */
        }

        /* Button Styling */
        .btn-become {
            background-color: #956a3b;
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .btn-become:hover {
            background-color: #7a5530;
        }

        .btn-outline-secondary {
            border-color: #ddd;
            color: #666;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background-color: #f1f1f1;
            color: #444;
        }

        /* Card untuk Insentif */
        .card {
            border-radius: 10px;
            background-color: #fff;
            padding: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        /* Small Text */
        small.text-muted {
            font-size: 0.85rem;
            color: #888;
        }

        /* Alert Styling */
        .alert-info {
            background-color: #e9f4ff;
            border-color: #d1e7ff;
            color: #31708f;
            border-radius: 8px;
        }

        /* Form pilihan keuntungan Additional CSS for the incentive section */
        .incentive-selection {
            border-left: 4px solid #956a3b !important;
        }

        .incentive-option {
            transition: all 0.3s ease;
        }

        .incentive-label {
            display: block;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .incentive-label:hover {
            border-color: #956a3b;
            background-color: #f8f5f0;
        }

        .form-check-input:checked+.incentive-label {
            border-color: #956a3b;
            background-color: #f8f5f0;
            box-shadow: 0 0 0 1px #956a3b;
        }

        .incentive-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bg-success-light {
            background-color: rgba(40, 167, 69, 0.15);
        }

        .bg-primary-light {
            background-color: rgba(0, 123, 255, 0.15);
        }

        /* Divider */
        .fancy-divider {
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--accent-color), transparent);
            margin: 50px 0;
            position: relative;
        }

        .fancy-divider::before {
            content: '●';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: var(--accent-color);
            font-size: 20px;
            background: white;
            padding: 0 20px;
        }
    </style>

    <style>
        .location-detection-card {
            background: linear-gradient(135deg, #956a3b 0%, #b8864a 50%, #daa764 100%);
            position: relative;
            color: white;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(149, 106, 59, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
        }

        .location-detection-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .location-detection-card::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -30%;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.05) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
            }

            33% {
                transform: translate(10px, -10px) rotate(120deg);
            }

            66% {
                transform: translate(-5px, 5px) rotate(240deg);
            }
        }

        .location-detection-card h6 {
            position: relative;
            z-index: 2;
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .location-detection-card h6 i {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px;
            border-radius: 50%;
            font-size: 1rem;
        }

        .location-status {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    position: relative;
    z-index: 2;
    background: rgba(255, 255, 255, 0.1);
    padding: 12px 15px;
    border-radius: 10px;
    backdrop-filter: blur(10px);
}

.location-toggle {
    background: rgba(255, 255, 255, 0.15);
    border: 2px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(15px);
    border-radius: 12px;
    color: white;
    font-weight: 600;
    padding: 12px 20px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    z-index: 2;
    font-size: 0.95rem;
}

.location-toggle:hover {
    background: rgba(255, 255, 255, 0.25);
    border-color: rgba(255, 255, 255, 0.4);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    color: white;
}
    </style>

    <!-- AOS Animations -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <main class="pt-90">
        <div class="mb-4 pb-4"></div>


        <!-- Hero Section -->
        <section class="hero-section text-center" data-aos="fade-down">
            <div class="container">
                <h1 class="fw-bold mb-4">Jadi <span>Pemasok Eceng Gondok</span> dan Dapatkan WOW!</h1>
                <p class="lead mb-4">
                    Dapatkan <span class="highlight">Rp 60.000/kg</span> atau <span class="highlight">Diskon</span> untuk
                    setiap kilogram eceng gondok
                    Anda!<br>
                    Penjemputan GRATIS oleh <em>Bank Koperasi Eceng Gondok</em> - tanpa repot!
                </p>
                <div class="d-flex justify-content-center gap-3">
                    @guest
                        <button class="btn btn-become btn-lg pulse-btn" onclick="promptLogin()">
                            <i class="fas fa-paper-plane me-2"></i> Kirim Permintaan Sekarang
                        </button>
                    @endguest

                    @auth
                        <button class="btn btn-become btn-lg pulse-btn" data-bs-toggle="modal" data-bs-target="#supplierModal">
                            <i class="fas fa-paper-plane me-2"></i> Kirim Permintaan Sekarang
                        </button>
                    @endauth
                </div>
            </div>
        </section>

        <div class="fancy-divider"></div>

        <!-- Enhanced Video Education Section -->
        <section class="video-education py-5">
            <div class="container">
                <!-- Decorative Elements -->
                <div class="decorative-element decoration-left"></div>
                <div class="decorative-element decoration-right"></div>

                <!-- Section Heading with Animation -->
                <div class="row justify-content-center mb-5" data-aos="fade-up">
                    <div class="col-lg-8 text-center">
                        <span class="pre-title">Edukasi Visual</span>
                        <h2 class="section-title mb-3">Eceng Gondok di Perairan Danau Toba</h2>
                        <div class="section-divider">
                            <span class="divider-dot"></span>
                        </div>
                        <p class="section-subtitle">Dampak Eceng Gondok pada Ekosistem Danau Toba dan Upaya Konservasi</p>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="row g-4">
                    <!-- Video Column with Enhanced Player -->
                    <div class="col-lg-7" data-aos="fade-right" data-aos-delay="100">
                        <div class="video-wrapper">
                            <div class="video-container">
                                @if ($supplierInfo && $supplierInfo->video_type == 'local' && $supplierInfo->video_url)
                                    <video id="ecoVideo"
                                        poster="{{ $supplierInfo->video_thumbnail ? asset($supplierInfo->video_thumbnail) : asset('assets/images/about/video-poster.jpg') }}"
                                        preload="metadata">
                                        <source src="{{ asset($supplierInfo->video_url) }}" type="video/mp4">
                                        <p>Maaf, browser Anda tidak mendukung pemutaran video.</p>
                                    </video>
                                @elseif($supplierInfo && $supplierInfo->video_type == 'instagram' && $supplierInfo->video_url)
                                    <div class="instagram-embed-container">
                                        {!! $supplierInfo->video_url !!}
                                    </div>
                                @else
                                    <video id="ecoVideo" poster="{{ asset('assets/images/about/video-poster.jpg') }}"
                                        preload="metadata">
                                        <source
                                            src="{{ asset('assets/images/about/istockphoto-2195143789-640_adpp_is.mp4') }}"
                                            type="video/mp4">
                                        <p>Maaf, browser Anda tidak mendukung pemutaran video.</p>
                                    </video>
                                @endif

                                <!-- Enhanced Video Controls (only show for local videos) -->
                                @if (!$supplierInfo || $supplierInfo->video_type == 'local')
                                    <div class="video-controls-container">
                                        <div class="video-controls">
                                            <button class="control-btn play-pause-btn">
                                                <i class="fas fa-play-fill play-icon"></i>
                                                <i class="fas fa-pause-fill pause-icon"></i>
                                            </button>

                                            <div class="progress-container">
                                                <div class="progress-bar">
                                                    <div class="progress-fill"></div>
                                                </div>
                                                <div class="time-display">
                                                    <span class="current-time">0:00</span>
                                                    <span
                                                        class="duration">{{ $supplierInfo->video_duration ?? '3:45' }}</span>
                                                </div>
                                            </div>

                                            <div class="additional-controls">
                                                <button class="control-btn volume-btn">
                                                    <i class="fas fa-volume-up-fill"></i>
                                                </button>
                                                <button class="control-btn fullscreen-btn">
                                                    <i class="fas fa-fullscreen"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Video Large Play Button -->
                                    <div class="video-play-button">
                                        <svg viewBox="0 0 100 100" class="play-circle">
                                            <circle cx="50" cy="50" r="48" stroke="#ffffff" stroke-width="2"
                                                fill="none" class="play-circle-border"></circle>
                                            <polygon points="40,30 70,50 40,70" fill="#ffffff" class="play-triangle">
                                            </polygon>
                                        </svg>
                                    </div>

                                    <div class="video-duration">
                                        <i class="fas fa-clock"></i> {{ $supplierInfo->video_duration ?? '3:45' }}
                                    </div>

                                    <div class="video-quality-badge">HD</div>
                                @endif

                                <div class="video-caption">
                                    <h5 style="color: #fff;">
                                        {{ $supplierInfo->video_caption ?? 'Dampak Eceng Gondok di Danau Toba' }}</h5>
                                    {{-- <p>{{ $supplierInfo->description ?? 'Tanaman invasif ini menutupi permukaan danau, menghalangi sinar matahari dan mengurangi kadar oksigen di air' }} --}}
                                    </p>
                                    <div class="caption-tags">
                                        <span class="caption-tag">Edukasi</span>
                                        <span class="caption-tag">Danau Toba</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Video Description -->
                            <div class="video-description mt-4">
                                <div class="video-info">
                                    <div class="video-meta">
                                        <span class="publish-date"><i class="fas fa-calendar-alt me-1"></i>
                                            Dipublikasikan:
                                            {{ $supplierInfo ? $supplierInfo->created_at->format('d M Y') : '15 Apr 2025' }}</span>
                                        <span class="views-count"><i class="fas fa-eye"></i> 12.5K tayangan</span>
                                    </div>
                                    <div class="social-share">
                                        <button class="share-btn" data-bs-toggle="tooltip" title="Bagikan Video">
                                            <i class="fas fa-share"></i> Bagikan
                                        </button>
                                        <div class="share-options">
                                            <a href="#" class="share-option"><i class="fas fa-facebook"></i></a>
                                            <a href="#" class="share-option"><i class="fas fa-twitter"></i></a>
                                            <a href="#" class="share-option"><i class="fab fa-whatsapp"></i></a>
                                            <a href="#" class="share-option"><i class="fas fa-telegram"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Facts Column with Elegant Modern Design -->
                    <div class="col-lg-5" data-aos="fade-left" data-aos-delay="200">
                        <div class="eco-facts-card">
                            <div class="facts-header">
                                <h3 class="facts-title">Mengapa Eceng Gondok Perlu Dibersihkan ?</h3>
                                <div class="title-underline"></div>
                            </div>

                            <div class="facts-content">
                                <div class="fact-row">
                                    <div class="fact-badge">
                                        <i class="fas fa-tint-slash"></i>
                                    </div>
                                    <p>Menutupi 60% permukaan air, menghalangi sinar matahari dan mengurangi oksigen yang
                                        penting bagi kehidupan akuatik di Danau Toba.</p>
                                </div>

                                <div class="fact-separator">
                                    <span></span>
                                </div>

                                <div class="fact-row">
                                    <div class="fact-badge">
                                        <i class="fas fa-seedling"></i>
                                    </div>
                                    <p>Pertumbuhan pesat dalam hitungan hari, mengubah keindahan panorama Danau Toba yang
                                        merupakan warisan alam berharga.</p>
                                </div>

                                <div class="fact-separator">
                                    <span></span>
                                </div>

                                <div class="fact-row">
                                    <div class="fact-badge">
                                        <i class="fas fa-hand-holding-water"></i>
                                    </div>
                                    <p>Setiap tanaman eceng gondok dapat menyerap hingga 20 liter air per hari, mengganggu
                                        keseimbangan ekosistem danau.</p>
                                </div>
                            </div>

                            <div class="eco-quote">
                                <i class="fas fa-quote-left"></i>
                                <p>Bersihkan eceng gondok hari ini, selamatkan keindahan Danau Toba untuk masa depan.</p>
                            </div>

                            <div class="fact-action text-center">
                                @guest
                                    <button type="button" class="btn btn-become btn-lg pulse-btn" onclick="promptLogin()">
                                        <i class="fas fa-paper-plane me-2"></i>
                                        Bersihkan Eceng Gondok dan berikan pada kami
                                        <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                @endguest

                                @auth
                                    <button type="button" class="btn btn-become btn-lg pulse-btn" data-bs-toggle="modal"
                                        data-bs-target="#supplierModal">
                                        <i class="fas fa-paper-plane me-2"></i>
                                        Bersihkan Eceng Gondok dan berikan pada kami
                                        <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                @endauth
                            </div>

                        </div>
                    </div>

                </div>

                <!-- Additional Related Videos Section -->
                {{-- <div class="related-videos mt-5" data-aos="fade-up" data-aos-delay="300">
                    <h4 class="related-title">Video Terkait Lainnya</h4>
                    <div class="row g-4 mt-3">
                        @if ($relatedVideos && $relatedVideos->count() > 0)
                            @foreach ($relatedVideos as $relatedVideo)
                                <div class="col-md-4">
                                    <div class="related-video-item">
                                        <div class="related-thumbnail">
                                            @if ($relatedVideo->video_type == 'instagram')
                                                {!! $relatedVideo->video_url !!}
                                            @elseif($relatedVideo->thumbnail)
                                                <img src="{{ asset($relatedVideo->thumbnail) }}"
                                                    alt="{{ $relatedVideo->title }}" class="img-fluid">
                                                <div class="play-indicator"><i class="fas fa-play-fill"></i></div>
                                            @else
                                                <div class="placeholder-thumbnail">
                                                    <i class="fas fa-video"></i>
                                                </div>
                                                <div class="play-indicator"><i class="fas fa-play-fill"></i></div>
                                            @endif
                                        </div>
                                        <div class="related-content">
                                            <h5>{{ $relatedVideo->title }}</h5>
                                            <p>{{ $relatedVideo->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- Default Related Videos -->
                            <!-- Related Video 1 -->
                            <div class="col-md-4">
                                <div class="related-video-item">
                                    <div class="related-thumbnail">
                                        <div class="placeholder-thumbnail">
                                            <i class="fas fa-video"></i>
                                        </div>
                                        <div class="play-indicator"><i class="fas fa-play-fill"></i></div>
                                    </div>
                                    <div class="related-content">
                                        <h5>Proses Pengolahan Eceng Gondok</h5>
                                        <p>Lihat bagaimana eceng gondok diproses menjadi produk kerajinan bernilai tinggi
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Related Video 2 -->
                            <div class="col-md-4">
                                <div class="related-video-item">
                                    <div class="related-thumbnail">
                                        <div class="placeholder-thumbnail">
                                            <i class="fas fa-video"></i>
                                        </div>
                                        <div class="play-indicator"><i class="fas fa-play-fill"></i></div>
                                    </div>
                                    <div class="related-content">
                                        <h5>Pembersihan Danau Toba</h5>
                                        <p>Dokumentasi kegiatan pembersihan eceng gondok oleh komunitas lokal</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Related Video 3 -->
                            <div class="col-md-4">
                                <div class="related-video-item">
                                    <div class="related-thumbnail">
                                        <div class="placeholder-thumbnail">
                                            <i class="fas fa-video"></i>
                                        </div>
                                        <div class="play-indicator"><i class="fas fa-play-fill"></i></div>
                                    </div>
                                    <div class="related-content">
                                        <h5>Kreasi Kerajinan Eceng Gondok</h5>
                                        <p>Tutorial pembuatan aneka produk dari serat eceng gondok</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div> --}}
            </div>
        </section>

        <!-- Informasi Pemasok -->
        <section class="container py-5 info-section" data-aos="fade-up">
            <div class="row align-items-center g-5">
                <div class="col-md-6">
                    <h2>{{ $supplierInfo->title ?? 'Mengapa Memberikan Pasokan?' }}</h2>
                    <p class="lead">
                        {!! $supplierInfo
                            ? $supplierInfo->description
                            : '<strong>Bank Koperasi Eceng Gondok</strong> membantu Anda mendapatkan penghasilan tambahan
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        dengan mudah. Kami membayarkan insentif <em>langsung</em> setelah penjemputan,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        dan setiap pengiriman dipastikan <strong>aman</strong> dan <strong>terjadwal</strong>.' !!}
                    </p>
                    <ul class="info-list">
                        <li data-aos="fade-right" data-aos-delay="100">
                            <i class="fas fa-money-bill-wave"></i>
                            <strong>Pembayaran Langsung: </strong> Rp 60.000 per kilogram eceng gondok
                        </li>
                        <li data-aos="fade-right" data-aos-delay="200">
                            <i class="fas fa-percent"></i>
                            <strong>Diskon Spesial: </strong> Pilihan DISKON untuk pembelian produk kami
                        </li>
                        <li data-aos="fade-right" data-aos-delay="300">
                            <i class="fas fa-truck"></i>
                            <strong>Penjemputan Gratis: </strong> Kami datang ke lokasi Anda
                        </li>
                        <li data-aos="fade-right" data-aos-delay="400">
                            <i class="fab fa-whatsapp"></i>
                            <strong>Kontak Langsung: </strong> Dihubungi melalui WhatsApp setelah pengisian form
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 text-center">
                    <div class="info-image floating">
                        @if ($supplierInfo && $supplierInfo->image)
                            <img src="{{ asset($supplierInfo->image) }}" alt="{{ $supplierInfo->title }}"
                                class="img-fluid rounded shadow" data-aos="zoom-in">
                        @else
                            <img src="{{ asset('assets/images/about/about-1.jpg') }}" alt="Contoh Eceng Gondok"
                                class="img-fluid rounded shadow" data-aos="zoom-in">
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <div class="fancy-divider"></div>

        <!-- Benefits Section -->
        <section class="benefits text-center" data-aos="fade-up">
            <div class="container">
                <h2 class="mb-5" style="color: var(--primary-color);">Statistik Permintaan Pemasok</h2>
                <div class="row gy-4">
                    <div class="col-md-4" data-aos="flip-left">
                        <div class="benefit-card p-4 h-100">
                            <i class="fas fa-money-bill-wave benefit-icon"></i>
                            <div class="counter" data-target="{{ $totalRupiahDisalurkan ?? 0 }}">0</div>
                            <p class="counter-label">Rupiah Disalurkan</p>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="flip-up">
                        <div class="benefit-card p-4 h-100">
                            <i class="fas fa-users benefit-icon"></i>
                            <div class="counter" data-target="{{ $totalPermintaanPemasok ?? 0 }}">0</div>
                            <p class="counter-label">Total Permintaan Pemasok</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="benefit-card p-4 h-100">
                            <i class="fas fa-truck benefit-icon"></i>
                            <div class="counter" data-target="{{ $totalPenjemputan ?? 0 }}">0</div>
                            <p class="counter-label">Penjemputan/Minggu</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="fancy-divider"></div>

        <!-- Persyaratan Card -->
        <section class="container mb-5" data-aos="fade-up">
            <div class="requirements-card p-4 rounded">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h3 class="mb-3">Syarat &amp; Ketentuan Pemasok</h3>
                        <p class="mb-0">Minimal 1 kg untuk kami terima. Penjemputan dilakukan setiap hari Sabtu,
                            pukul 08.00–17.00 WIB. Area layanan: Samosir &amp; sekitarnya.</p>
                    </div>
                    <div class="col-md-4 text-end">
                        @guest
                            <button class="btn btn-become btn-lg pulse-btn" onclick="promptLogin()">
                                <i class="fas fa-paper-plane me-2"></i> Kirim Permintaan Sekarang
                            </button>
                        @endguest

                        @auth
                            <button class="btn btn-become btn-lg pulse-btn" data-bs-toggle="modal"
                                data-bs-target="#supplierModal">
                                <i class="fas fa-paper-plane me-2"></i> Kirim Permintaan Sekarang
                            </button>
                        @endauth
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal Form -->
        <div class="modal fade" id="supplierModal" tabindex="-1" aria-labelledby="supplierModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="supplierModalLabel">
                            <i class="fas fa-send me-2"></i> Formulir Permintaan Pemasok
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="supplierForm" action="{{ route('supplier.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <!-- Data Pribadi -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama">Nama Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-person"></i></span>
                                        <input type="text" id="nama" name="nama" class="form-control"
                                            value="{{ old('nama', Auth::check() ? Auth::user()->name : '') }}"
                                            placeholder="Masukkan nama lengkap Anda" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" id="email" name="email" class="form-control"
                                            value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}"
                                            placeholder="Masukkan email Anda" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Kontak & Estimasi -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kontak">Nomor HP / WhatsApp</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                                        <input type="tel" id="kontak" name="kontak" class="form-control"
                                            value="{{ old('nama', Auth::check() ? Auth::user()->mobile : '') }}"
                                            placeholder="08123456789" pattern="\d+" inputmode="numeric" required>
                                    </div>
                                    <small class="text-muted">Kami akan menghubungi Anda melalui WhatsApp</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="estimasi_kg">Estimasi Jumlah Eceng Gondok (kg)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-box-open"></i></span>
                                        <input type="number" id="estimasi_kg" name="estimasi_kg" class="form-control"
                                            value="{{ old('estimasi_kg') }}" min="1" step="1"
                                            placeholder="Masukkan Jumlah (kg) yang Ingin Anda Berikan" required>
                                        <span class="input-group-text">kg</span>
                                    </div>
                                    <small class="text-muted">Minimal 1 kg untuk permintaan pertama</small>
                                </div>
                            </div>

                            <!-- Insentif & Foto -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Keuntungan yang Anda Dapatkan</label>
                                    <div class="card p-3 border-0 shadow-sm incentive-selection">
                                        <p class="text-muted mb-3"><i class="fas fa-info-circle me-2"></i>Pilih jenis
                                            keuntungan yang Anda inginkan:</p>

                                        <div class="incentive-option mb-3">
                                            <input class="form-check-input visually-hidden" type="radio" id="insDiskon"
                                                name="insentif" value="diskon"
                                                {{ old('insentif') == 'diskon' ? 'checked' : '' }} required>
                                            <label class="incentive-label" for="insDiskon">
                                                <div class="d-flex align-items-center">
                                                    <div class="incentive-icon bg-success-light rounded-circle p-2 me-3">
                                                        <i class="fas fa-gift" style="color: #000;"></i>
                                                    </div>
                                                    <div>
                                                        <span class="d-block fw-bold">Diskon Produk</span>
                                                        <span class="text-muted small">Potongan harga untuk produk ramah
                                                            lingkungan</span>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="incentive-option">
                                            <input class="form-check-input visually-hidden" type="radio" id="insTunai"
                                                name="insentif" value="uang_tunai"
                                                {{ old('insentif') == 'uang_tunai' ? 'checked' : '' }}>
                                            <label class="incentive-label" for="insTunai">
                                                <div class="d-flex align-items-center">
                                                    <div class="incentive-icon bg-primary-light rounded-circle p-2 me-3">
                                                        <i class="fas fa-money-bill-wave text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <span class="d-block fw-bold">Uang Tunai</span>
                                                        <span class="text-muted small">Rp 60.000 per kilogram eceng
                                                            gondok</span>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="foto">Upload Foto Eceng Gondok</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-camera"></i></span>
                                        <input type="file" id="foto" name="foto" class="form-control"
                                            accept="image/*" required>
                                    </div>
                                    <small class="text-muted">Upload foto eceng gondok yang akan Anda pasok</small>
                                </div>
                            </div>

                            <!-- Kecamatan & Desa -->
                            <!-- Fitur Deteksi Lokasi Otomatis -->
                            <div class="mb-4">
                                <div class="location-detection-card">
                                    <h6 class="mb-3">
                                        <i class="fas fa-location-crosshairs"></i>
                                        Deteksi Lokasi Otomatis
                                    </h6>

                                    <div class="location-status">
                                        <div class="location-indicator" id="locationIndicator"></div>
                                        <span id="locationStatus">Siap mendeteksi lokasi...</span>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-12">
                                            <button type="button" class="btn location-toggle w-100" id="detectLocationBtn">
                                                <i class="fas fa-crosshairs me-2"></i>
                                                Deteksi Lokasi Saya Sekarang
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mt-3" id="locationInfo" style="display: none;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small>
                                                <i class="fas fa-info-circle me-1"></i>
                                                <span id="coordinateInfo"></span>
                                            </small>
                                            <small id="distanceInfo"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kecamatan & Desa (akan disable/enable otomatis) -->
                            <div class="row mb-3" id="manualLocationSection">
                                <div class="col-md-6">
                                    <label for="kecamatan">Kecamatan</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        <select id="kecamatan" name="kecamatan" class="form-control" required>
                                            <option value="">-- Pilih Kecamatan --</option>
                                            <option value="Harian">Harian</option>
                                            <option value="Nainggolan">Nainggolan</option>
                                            <option value="Onan Runggu">Onan Runggu</option>
                                            <option value="Palipi">Palipi</option>
                                            <option value="Pangururan">Pangururan</option>
                                            <option value="Ronggur Nihuta">Ronggur Nihuta</option>
                                            <option value="Sianjur Mulamula">Sianjur Mulamula</option>
                                            <option value="Simanindo">Simanindo</option>
                                            <option value="Sitio-tio">Sitio-tio</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="desa">Desa</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        <select id="desa" name="desa" class="form-control" required disabled>
                                            <option value="">-- Pilih Desa --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Lokasi & Catatan -->
                            <div class="mb-3">
                                <label for="detail_lokasi">Detail Lokasi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-thumbtack"></i></span>
                                    <input type="text" id="detail_lokasi" name="detail_lokasi" class="form-control"
                                        value="{{ old('detail_lokasi') }}" placeholder="Contoh: Dekat Pasar, RT/RW, dll"
                                        required>
                                </div>
                                <small class="text-muted">Detail alamat untuk memudahkan penjemputan</small>
                            </div>

                            <div class="mb-3">
                                <label for="catatan">Catatan Tambahan (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-pencil"></i></span>
                                    <textarea id="catatan" name="catatan" rows="3" class="form-control"
                                        placeholder="Tambahkan informasi spesifik jika ada">{{ old('catatan') }}</textarea>
                                </div>
                            </div>

                            <div class="alert alert-info" role="alert">
                                <i class="fas fa-info-circle me-2"></i> Setelah mengirim permintaan, pihak Bank Eceng
                                Gondok
                                akan menghubungi Anda melalui WhatsApp untuk konfirmasi dan penjadwalan.
                            </div>

                            <div class="text-end">
                                <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">
                                    <i class="fas fa-x"></i> Batal
                                </button>
                                <button type="submit" class="btn btn-become btn-lg">
                                    <i class="fas fa-send me-2"></i> Kirim Permintaan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>

        <!-- Enhanced Styling for Video Section -->
        <style>
            /* Modern & Elegant Video Section Styling */
            .video-education {
                position: relative;
                background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
                padding: 120px 0;
                overflow: hidden;
            }

            /* Decorative Elements */
            .decorative-element {
                position: absolute;
                opacity: 0.05;
                z-index: 0;
            }

            .decoration-left {
                left: -100px;
                top: 0;
                width: 300px;
                height: 300px;
                background: radial-gradient(circle, #956a3b 0%, transparent 70%);
                border-radius: 50%;
            }

            .decoration-right {
                right: -80px;
                bottom: -80px;
                width: 400px;
                height: 400px;
                background: radial-gradient(circle, #4eb19e 0%, transparent 70%);
                border-radius: 50%;
            }

            /* Pre-title Styling */
            .pre-title {
                display: inline-block;
                margin-bottom: 15px;
                color: #956a3b;
                font-size: 0.9rem;
                text-transform: uppercase;
                letter-spacing: 3px;
                padding: 5px 15px;
                background-color: rgba(149, 106, 59, 0.08);
                border-radius: 50px;
                font-weight: 600;
            }

            /* Section Title Styling */
            .section-title {
                color: #956a3b;
                font-weight: 700;
                letter-spacing: -0.5px;
                position: relative;
                margin-bottom: 20px;
                font-size: 2.5rem;
            }

            .section-divider {
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 25px auto;
                position: relative;
            }

            .section-divider:before,
            .section-divider:after {
                content: '';
                height: 2px;
                width: 40px;
                background: linear-gradient(90deg, transparent, #956a3b);
                display: block;
            }

            .section-divider:after {
                background: linear-gradient(90deg, #956a3b, transparent);
            }

            .divider-dot {
                width: 10px;
                height: 10px;
                background-color: #956a3b;
                border-radius: 50%;
                margin: 0 10px;
                display: block;
            }

            .section-subtitle {
                font-size: 1.1rem;
                max-width: 700px;
                margin: 0 auto;
                line-height: 1.6;
            }

            /* Enhanced Video Container Styling */
            .video-wrapper {
                position: relative;
                margin-bottom: 20px;
            }

            .video-container {
                position: relative;
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
                aspect-ratio: 16/9;
                background-color: #000;
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            }

            .video-container:hover {
                transform: translateY(-8px);
                box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            }

            .video-container video {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
            }

            /* Enhanced Video Player Controls */
            .video-controls-container {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                padding: 15px 20px;
                background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0) 100%);
                opacity: 0;
                transform: translateY(10px);
                transition: all 0.3s ease;
            }

            .video-container:hover .video-controls-container {
                opacity: 1;
                transform: translateY(0);
            }

            .video-controls {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .control-btn {
                background: transparent;
                border: none;
                color: white;
                cursor: pointer;
                width: 36px;
                height: 36px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.2rem;
                border-radius: 50%;
                transition: all 0.2s ease;
            }

            .control-btn:hover {
                background-color: rgba(255, 255, 255, 0.2);
            }

            .play-pause-btn .pause-icon {
                display: none;
            }

            .progress-container {
                flex: 1;
                display: flex;
                flex-direction: column;
            }

            .progress-bar {
                height: 4px;
                background-color: rgba(255, 255, 255, 0.3);
                border-radius: 4px;
                overflow: hidden;
                cursor: pointer;
                margin-bottom: 5px;
            }

            .progress-fill {
                height: 100%;
                width: 0%;
                background-color: #956a3b;
                border-radius: 4px;
                position: relative;
                transition: width 0.1s ease;
            }

            .time-display {
                display: flex;
                justify-content: space-between;
                font-size: 0.75rem;
                color: rgba(255, 255, 255, 0.85);
            }

            .additional-controls {
                display: flex;
                gap: 5px;
            }

            /* Enhanced Video Play Button */
            .video-play-button {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) scale(1);
                z-index: 2;
                width: 90px;
                height: 90px;
                cursor: pointer;
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                opacity: 0.9;
            }

            .play-circle {
                width: 100%;
                height: 100%;
            }

            .play-circle-border {
                stroke-dasharray: 300;
                stroke-dashoffset: 0;
                animation: pulse 2s infinite;
                transform-origin: center;
            }

            .play-triangle {
                transform-origin: center;
                transition: transform 0.3s ease;
            }

            .video-play-button:hover {
                transform: translate(-50%, -50%) scale(1.1);
                opacity: 1;
            }

            .video-play-button:hover .play-triangle {
                transform: scale(1.2);
            }

            @keyframes pulse {
                0% {
                    stroke-dashoffset: 0;
                    stroke-width: 2;
                    opacity: 0.9;
                }

                50% {
                    stroke-dashoffset: 300;
                    stroke-width: 3;
                    opacity: 0.5;
                }

                100% {
                    stroke-dashoffset: 600;
                    stroke-width: 2;
                    opacity: 0.9;
                }
            }

            /* Video Metadata Elements */
            .video-duration {
                position: absolute;
                top: 15px;
                right: 15px;
                background-color: rgba(0, 0, 0, 0.6);
                color: #fff;
                padding: 5px 12px;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 500;
                backdrop-filter: blur(4px);
                display: flex;
                align-items: center;
                gap: 5px;
            }

            .video-quality-badge {
                position: absolute;
                top: 15px;
                left: 15px;
                background-color: rgba(149, 106, 59, 0.8);
                color: #fff;
                padding: 3px 8px;
                border-radius: 4px;
                font-size: 0.7rem;
                font-weight: 600;
                letter-spacing: 1px;
                backdrop-filter: blur(4px);
            }

            /* Video Caption */
            .video-caption {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.6) 50%, rgba(0, 0, 0, 0) 100%);
                padding: 50px 20px 20px;
                color: #fff;
                transition: transform 0.3s ease;
            }

            .video-container:hover .video-caption {
                transform: translateY(-5px);
            }

            .video-caption h5 {
                font-weight: 600;
                margin-bottom: 8px;
                font-size: 1.2rem;
            }

            .video-caption p {
                font-size: 0.9rem;
                opacity: 0.9;
                margin-bottom: 10px;
                max-width: 90%;
                line-height: 1.5;
            }

            .caption-tags {
                display: flex;
                gap: 8px;
            }

            .caption-tag {
                font-size: 0.7rem;
                background-color: rgba(255, 255, 255, 0.2);
                padding: 3px 10px;
                border-radius: 20px;
                backdrop-filter: blur(5px);
            }

            /* Video Description Area */
            .video-description {
                background-color: #fff;
                border-radius: 12px;
                padding: 15px 20px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            }

            .video-info {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .video-meta {
                display: flex;
                gap: 15px;
                color: #637381;
                font-size: 0.9rem;
            }

            .video-meta span {
                display: flex;
                align-items: center;
                gap: 5px;
            }

            .social-share {
                position: relative;
            }

            .share-btn {
                background-color: #f0f3f5;
                border: none;
                padding: 6px 15px;
                border-radius: 20px;
                display: flex;
                align-items: center;
                gap: 5px;
                font-size: 0.9rem;
                color: #637381;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .share-btn:hover {
                background-color: #e2e6ea;
            }

            .share-options {
                position: absolute;
                top: 100%;
                right: 0;
                background-color: #fff;
                border-radius: 12px;
                padding: 10px;
                margin-top: 10px;
                box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
                display: none;
                z-index: 10;
            }

            .social-share:hover .share-options {
                display: flex;
                gap: 10px;
            }

            .share-option {
                width: 32px;
                height: 32px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                color: #fff;
                font-size: 0.9rem;
                transition: transform 0.3s ease;
            }

            .share-option:nth-child(1) {
                background-color: #3b5998;
            }

            .share-option:nth-child(2) {
                background-color: #1da1f2;
            }

            .share-option:nth-child(3) {
                background-color: #25d366;
            }

            .share-option:nth-child(4) {
                background-color: #0088cc;
            }

            .share-option:hover {
                transform: scale(1.1);
            }

            /* Modern & Elegant Facts Card Styling */
            < !-- Facts Column with Elegant Modern Design --><div class="col-lg-5" data-aos="fade-left" data-aos-delay="200"><div class="eco-facts-card"><div class="facts-header"><h3 class="facts-title">Mengapa Eceng Gondok Perlu Dibersihkan</h3><div class="title-underline"></div></div><div class="facts-content"><div class="fact-row"><div class="fact-badge"><i class="fas fa-tint-slash"></i></div><p>Menutupi 60% permukaan air,
            menghalangi sinar matahari dan mengurangi oksigen yang penting bagi kehidupan akuatik di Danau Toba.</p></div><div class="fact-separator"><span></span></div><div class="fact-row"><div class="fact-badge"><i class="fas fa-seedling"></i></div><p>Pertumbuhan pesat dalam hitungan hari,
            mengubah keindahan panorama Danau Toba yang merupakan warisan alam berharga.</p></div><div class="fact-separator"><span></span></div><div class="fact-row"><div class="fact-badge"><i class="fas fa-hand-holding-water"></i></div><p>Setiap tanaman eceng gondok dapat menyerap hingga 20 liter air per hari,
            mengganggu keseimbangan ekosistem danau.</p></div></div><div class="eco-quote"><i class="fas fa-quote-left"></i><p>Bersihkan eceng gondok hari ini,
            selamatkan keindahan Danau Toba untuk masa depan.</p></div><div class="fact-action"><a href="#join-cleanup" class="btn-eco-action">Bergabung Aksi Pembersihan <i class="fas fa-arrow-right"></i></a></div></div></div>< !-- Enhanced Styling for Facts Section --><style>

            /* Modern & Elegant Facts Card Styling */
            .eco-facts-card {
                background-color: #fcfaf7;
                border-radius: 16px;
                padding: 35px 30px;
                height: 100%;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06);
                display: flex;
                flex-direction: column;
                position: relative;
                overflow: hidden;
                border: 1px solid rgba(150, 106, 59, 0.1);
            }

            .eco-facts-card:before {
                content: '';
                position: absolute;
                top: -50px;
                right: -50px;
                width: 180px;
                height: 180px;
                background: radial-gradient(circle, rgba(150, 106, 59, 0.04) 0%, transparent 70%);
                border-radius: 50%;
                z-index: 0;
            }

            .eco-facts-card:after {
                content: '';
                position: absolute;
                bottom: -60px;
                left: -60px;
                width: 200px;
                height: 200px;
                background: radial-gradient(circle, rgba(150, 106, 59, 0.03) 0%, transparent 70%);
                border-radius: 50%;
                z-index: 0;
            }

            .facts-header {
                text-align: center;
                margin-bottom: 30px;
                position: relative;
            }

            .facts-title {
                font-size: 1.5rem;
                font-weight: 600;
                margin-bottom: 15px;
                letter-spacing: 0.5px;
            }

            .title-underline {
                height: 2px;
                width: 70px;
                background: linear-gradient(90deg, transparent, #8b5a2b, transparent);
                margin: 0 auto;
            }

            .facts-content {
                flex: 1;
                display: flex;
                flex-direction: column;
                gap: 15px;
            }

            .fact-row {
                display: flex;
                align-items: center;
                gap: 15px;
                padding: 10px 0;
                position: relative;
                z-index: 1;
                transition: transform 0.3s ease;
            }

            .fact-row:hover {
                transform: translateX(5px);
            }

            .fact-badge {
                flex-shrink: 0;
                width: 50px;
                height: 50px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #f3ece1;
                color: #8b5a2b;
                font-size: 1.3rem;
                transition: all 0.3s ease;
                box-shadow: 0 3px 8px rgba(139, 90, 43, 0.1);
            }

            .fact-row:hover .fact-badge {
                transform: scale(1.1) rotate(10deg);
                background-color: #8b5a2b;
                color: #fff;
            }

            .fact-row p {
                color: #6b563e;
                font-size: 0.95rem;
                margin-bottom: 0;
                line-height: 1.65;
                font-weight: 400;
            }

            .fact-separator {
                position: relative;
                height: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .fact-separator span {
                width: 50%;
                height: 1px;
                background: linear-gradient(90deg, transparent, rgba(139, 90, 43, 0.2), transparent);
            }

            .eco-quote {
                background-color: rgba(139, 90, 43, 0.05);
                border-left: 3px solid #8b5a2b;
                padding: 15px 20px;
                margin: 25px 0;
                position: relative;
                border-radius: 0 8px 8px 0;
            }

            .eco-quote i {
                position: absolute;
                top: 15px;
                left: 15px;
                color: rgba(139, 90, 43, 0.2);
                font-size: 1.5rem;
            }

            .eco-quote p {
                color: #8b5a2b;
                font-size: 1rem;
                font-style: italic;
                margin: 0;
                padding-left: 25px;
                line-height: 1.5;
            }

            /* Enhanced Action Button */
            .fact-action {
                display: flex;
                justify-content: center;
                margin-top: 10px;
            }

            .btn-eco-action {
                background-color: #8b5a2b;
                color: #fff;
                border-radius: 30px;
                padding: 12px 28px;
                font-weight: 500;
                transition: all 0.3s ease;
                box-shadow: 0 5px 15px rgba(139, 90, 43, 0.2);
                display: flex;
                align-items: center;
                gap: 10px;
                text-decoration: none;
            }

            .btn-eco-action i {
                transition: transform 0.3s ease;
            }

            .btn-eco-action:hover {
                background-color: #74491f;
                transform: translateY(-3px);
                box-shadow: 0 8px 20px rgba(139, 90, 43, 0.3);
                color: #fff;
            }

            .btn-eco-action:hover i {
                transform: translateX(5px);
            }

            /* Responsive Adjustments */
            @media (max-width: 991.98px) {
                .eco-facts-card {
                    margin-top: 20px;
                }
            }

            @media (max-width: 767.98px) {
                .facts-content {
                    gap: 10px;
                }

                .fact-badge {
                    width: 40px;
                    height: 40px;
                    font-size: 1rem;
                }

                .eco-quote p {
                    font-size: 0.9rem;
                }
            }

            /* Responsive Adjustments */
            @media (max-width: 991.98px) {
                .eco-facts-card {
                    margin-top: 20px;
                }

                .fact-item {
                    margin-bottom: 20px;
                    padding-bottom: 20px;
                }
            }

            @media (max-width: 767.98px) {
                .fact-action {
                    flex-direction: column;
                }
            }

            /* Related Videos Section */
            .related-videos {
                padding-top: 30px;
                border-top: 1px solid rgba(0, 0, 0, 0.06);
            }

            .related-title {
                color: #7a5130;
                font-size: 1.5rem;
                font-weight: 600;
                margin-bottom: 20px;
                position: relative;
                padding-left: 15px;
            }

            .related-title:before {
                content: '';
                position: absolute;
                left: 0;
                top: 50%;
                transform: translateY(-50%);
                width: 5px;
                height: 25px;
                background-color: #956a3b;
                border-radius: 10px;
            }

            .related-video-item {
                background-color: #fff;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
                transition: all 0.3s ease;
                height: 100%;
            }

            .related-video-item:hover {
                transform: translateY(-5px);
                box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
            }

            .related-thumbnail {
                position: relative;
                overflow: hidden;
                border-radius: 12px 12px 0 0;
            }

            .related-thumbnail img {
                transition: transform 0.5s ease;
                width: 100%;
                height: auto;
            }

            .related-video-item:hover .related-thumbnail img {
                transform: scale(1.05);
            }

            .related-thumbnail .duration {
                position: absolute;
                bottom: 10px;
                right: 10px;
                background-color: rgba(0, 0, 0, 0.7);
                color: #fff;
                font-size: 0.7rem;
                padding: 3px 8px;
                border-radius: 10px;
            }

            .play-indicator {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 50px;
                height: 50px;
                background-color: rgba(255, 255, 255, 0.2);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: all 0.3s ease;
                backdrop-filter: blur(2px);
            }

            .play-indicator i {
                font-size: 1.8rem;
                color: #fff;
            }

            .related-video-item:hover .play-indicator {
                opacity: 1;
            }

            .related-content {
                padding: 15px;
            }

            .related-content h5 {
                font-size: 1rem;
                font-weight: 600;
                margin-bottom: 8px;
                color: #343a40;
                transition: color 0.3s ease;
            }

            .related-content p {
                font-size: 0.85rem;
                color: #637381;
                margin-bottom: 0;
                line-height: 1.5;
            }

            .related-video-item:hover .related-content h5 {
                color: #956a3b;
            }

            /* Responsive Adjustments */
            @media (max-width: 1199.98px) {
                .video-education {
                    padding: 90px 0;
                }

                .section-title {
                    font-size: 2.2rem;
                }
            }

            @media (max-width: 991.98px) {
                .video-education {
                    padding: 70px 0;
                }

                .eco-facts-card {
                    margin-top: 20px;
                }

                .video-play-button {
                    width: 70px;
                    height: 70px;
                }

                .section-title {
                    font-size: 2rem;
                }

                .fact-item {
                    margin-bottom: 20px;
                    padding-bottom: 20px;
                }
            }

            @media (max-width: 767.98px) {
                .section-title {
                    font-size: 1.8rem;
                }

                .video-caption h5 {
                    font-size: 1rem;
                }

                .video-caption p {
                    font-size: 0.8rem;
                }

                .pre-title {
                    font-size: 0.8rem;
                }

                .fact-action {
                    flex-direction: column;
                }

                .video-play-button {
                    width: 60px;
                    height: 60px;
                }

                .video-controls-container {
                    padding: 10px 15px;
                }

                .additional-controls {
                    display: none;
                }
            }

            @media (max-width: 575.98px) {
                .video-caption p {
                    display: none;
                }

                .caption-tags {
                    display: none;
                }

                .video-education {
                    padding: 50px 0;
                }

                .video-play-button {
                    width: 50px;
                    height: 50px;
                }
            }
        </style>

        <!-- Enhanced JavaScript for Video Section -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Elements
                const video = document.getElementById('ecoVideo');
                const playButton = document.querySelector('.video-play-button');
                const playPauseBtn = document.querySelector('.play-pause-btn');
                const playIcon = document.querySelector('.play-icon');
                const pauseIcon = document.querySelector('.pause-icon');
                const progressFill = document.querySelector('.progress-fill');
                const progressBar = document.querySelector('.progress-bar');
                const currentTimeDisplay = document.querySelector('.current-time');
                const fullscreenBtn = document.querySelector('.fullscreen-btn');
                const volumeBtn = document.querySelector('.volume-btn');

                // Initialize tooltips
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });

                // Progress bar animation for facts
                const animateProgressBars = () => {
                    const progressBars = document.querySelectorAll('.fact-progress .progress-bar');
                    progressBars.forEach(bar => {
                        const width = bar.getAttribute('aria-valuenow') + '%';
                        setTimeout(() => {
                            bar.style.width = width;
                        }, 500);
                    });
                };

                // Run animation when element is in viewport
                const observerOptions = {
                    threshold: 0.5
                };

                const observerCallback = (entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            animateProgressBars();
                            observer.unobserve(entry.target);
                        }
                    });
                };

                const observer = new IntersectionObserver(observerCallback, observerOptions);
                const factCard = document.querySelector('.eco-facts-card');
                if (factCard) {
                    observer.observe(factCard);
                }

                // Video Player Functionality
                if (video && playButton) {
                    // Format time function
                    const formatTime = (seconds) => {
                        const minutes = Math.floor(seconds / 60);
                        seconds = Math.floor(seconds % 60);
                        return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                    };

                    // Update progress bar as video plays
                    video.addEventListener('timeupdate', () => {
                        const progress = (video.currentTime / video.duration) * 100;
                        if (progressFill) progressFill.style.width = `${progress}%`;
                        if (currentTimeDisplay) currentTimeDisplay.textContent = formatTime(video.currentTime);
                    });

                    // Click on progress bar to seek
                    if (progressBar) {
                        progressBar.addEventListener('click', (e) => {
                            const rect = progressBar.getBoundingClientRect();
                            const pos = (e.clientX - rect.left) / progressBar.offsetWidth;
                            video.currentTime = pos * video.duration;
                        });
                    }

                    // Handle large play button click
                    playButton.addEventListener('click', function() {
                        if (video.paused) {
                            video.play();
                            playButton.style.opacity = '0';
                            setTimeout(() => {
                                playButton.style.display = 'none';
                            }, 300);

                            // Update controls
                            if (playIcon) playIcon.style.display = 'none';
                            if (pauseIcon) pauseIcon.style.display = 'block';
                        } else {
                            video.pause();
                            playButton.style.display = 'flex';
                            setTimeout(() => {
                                playButton.style.opacity = '0.9';
                            }, 10);

                            // Update controls
                            if (playIcon) playIcon.style.display = 'block';
                            if (pauseIcon) pauseIcon.style.display = 'none';
                        }
                    });

                    // Handle play/pause button in controls
                    if (playPauseBtn) {
                        playPauseBtn.addEventListener('click', () => {
                            if (video.paused) {
                                video.play();
                                playIcon.style.display = 'none';
                                pauseIcon.style.display = 'block';
                                playButton.style.opacity = '0';
                                setTimeout(() => {
                                    playButton.style.display = 'none';
                                }, 300);
                            } else {
                                video.pause();
                                playIcon.style.display = 'block';
                                pauseIcon.style.display = 'none';
                                playButton.style.display = 'flex';
                                setTimeout(() => {
                                    playButton.style.opacity = '0.9';
                                }, 10);
                            }
                        });
                    }

                    // Fullscreen button
                    if (fullscreenBtn) {
                        fullscreenBtn.addEventListener('click', () => {
                            if (video.requestFullscreen) {
                                video.requestFullscreen();
                            } else if (video.webkitRequestFullscreen) {
                                video.webkitRequestFullscreen();
                            } else if (video.msRequestFullscreen) {
                                video.msRequestFullscreen();
                            }
                        });
                    }

                    // Volume button
                    let isMuted = false;
                    if (volumeBtn) {
                        volumeBtn.addEventListener('click', () => {
                            if (isMuted) {
                                video.muted = false;
                                volumeBtn.innerHTML = '<i class="fas fa-volume-up-fill"></i>';
                                isMuted = false;
                            } else {
                                video.muted = true;
                                volumeBtn.innerHTML = '<i class="fas fa-volume-mute-fill"></i>';
                                isMuted = true;
                            }
                        });
                    }

                    // Show controls when video is playing
                    video.addEventListener('play', function() {
                        playButton.style.opacity = '0';
                        setTimeout(() => {
                            playButton.style.display = 'none';
                        }, 300);

                        if (playIcon) playIcon.style.display = 'none';
                        if (pauseIcon) pauseIcon.style.display = 'block';

                        // Set initial volume
                        video.volume = 0.7;
                    });

                    // Show play button when video is paused
                    video.addEventListener('pause', function() {
                        playButton.style.display = 'flex';
                        setTimeout(() => {
                            playButton.style.opacity = '0.9';
                        }, 10);

                        if (playIcon) playIcon.style.display = 'block';
                        if (pauseIcon) pauseIcon.style.display = 'none';
                    });

                    // If autoplay fails, show the play button
                    video.play().catch(error => {
                        console.log("Video autoplay failed:", error);
                        playButton.style.display = 'flex';
                        playButton.style.opacity = '0.9';

                        if (playIcon) playIcon.style.display = 'block';
                        if (pauseIcon) pauseIcon.style.display = 'none';
                    });

                    // Handle video ended
                    video.addEventListener('ended', function() {
                        playButton.style.display = 'flex';
                        setTimeout(() => {
                            playButton.style.opacity = '0.9';
                        }, 10);

                        if (playIcon) playIcon.style.display = 'block';
                        if (pauseIcon) pauseIcon.style.display = 'none';

                        // Reset progress
                        if (progressFill) progressFill.style.width = '0%';
                    });

                    // Handle video errors
                    video.addEventListener('error', function() {
                        console.error('Video error occurred');
                        video.parentElement.innerHTML = `
                    <div class="p-5 text-center bg-light rounded">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">Video Tidak Dapat Diputar</h4>
                        <p class="text-muted">Maaf, terjadi kesalahan dalam memuat video. Pastikan file video tersedia di server atau periksa koneksi internet Anda.</p>
                        <button class="btn btn-outline-primary mt-3">Coba Lagi</button>
                    </div>
                `;
                    });
                }

                // Related Videos Interaction
                const relatedVideos = document.querySelectorAll('.related-video-item');
                relatedVideos.forEach(item => {
                    item.addEventListener('click', function() {
                        // Here you would typically handle the click to play the related video
                        // For this example, we'll just add a highlighted effect
                        relatedVideos.forEach(v => v.classList.remove('active'));
                        this.classList.add('active');

                        // Demo: Show a message for demo purposes
                        const videoTitle = this.querySelector('h5').textContent;
                        alert(`Video "${videoTitle}" akan diputar.`);
                    });
                });

                // Share button functionality
                const shareBtn = document.querySelector('.share-btn');
                if (shareBtn) {
                    shareBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const shareOptions = document.querySelector('.share-options');
                        if (shareOptions.style.display === 'flex') {
                            shareOptions.style.display = 'none';
                        } else {
                            shareOptions.style.display = 'flex';
                        }
                    });

                    // Close share options when clicking outside
                    document.addEventListener('click', function(e) {
                        const shareOptions = document.querySelector('.share-options');
                        const shareBtn = document.querySelector('.share-btn');

                        if (shareOptions && shareBtn) {
                            if (!shareOptions.contains(e.target) && !shareBtn.contains(e.target)) {
                                shareOptions.style.display = 'none';
                            }
                        }
                    });
                }
            });
        </script>

        <!-- Scripts for form pemasok-->
        <script>
            AOS.init({
                duration: 800,
                once: false,
                mirror: true
            });

            // Counter Animation with Improved Implementation
            document.addEventListener('DOMContentLoaded', () => {
                const counters = document.querySelectorAll('.counter');

                const animateCounter = (el) => {
                    const target = +el.getAttribute('data-target');
                    const duration = 2000; // Animation duration in ms
                    const stepTime = 50; // Update every 50ms
                    const totalSteps = duration / stepTime;
                    const increment = target / totalSteps;
                    let currentCount = 0;

                    const updateCounter = () => {
                        currentCount += increment;
                        if (currentCount < target) {
                            // Format number with commas
                            el.innerText = Math.ceil(currentCount).toLocaleString();
                            setTimeout(updateCounter, stepTime);
                        } else {
                            el.innerText = target.toLocaleString();
                        }
                    };

                    updateCounter();
                };

                // Use Intersection Observer for better performance
                const counterObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            animateCounter(entry.target);
                            counterObserver.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.5
                });

                counters.forEach(counter => counterObserver.observe(counter));
            });
        </script>

        <!-- Scripts for form pemasok angka pasokan-->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Get the weight input field
                const weightInput = document.getElementById('estimasi_kg');

                if (weightInput) {
                    // Create error message element
                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'invalid-feedback';
                    errorMessage.style.display = 'none';
                    errorMessage.textContent = 'Jumlah eceng gondok tidak boleh kosong';

                    // Insert error message after the input group
                    weightInput.closest('.input-group').after(errorMessage);

                    // Function to validate weight
                    const validateWeight = () => {
                        const value = parseInt(weightInput.value) || 0;

                        if (value <= 0) {
                            weightInput.classList.add('is-invalid');
                            errorMessage.style.display = 'block';
                            return false;
                        } else {
                            weightInput.classList.remove('is-invalid');
                            errorMessage.style.display = 'none';
                            return true;
                        }
                    };

                    // Function to remove leading zeros
                    const removeLeadingZeros = () => {
                        // Skip if field is empty or just "0"
                        if (!weightInput.value || weightInput.value === '0') return;

                        // Convert to number and back to string to remove leading zeros
                        const numericValue = parseInt(weightInput.value, 10);
                        weightInput.value = numericValue.toString();
                    };

                    // Prevent non-numeric input
                    weightInput.addEventListener('keypress', (e) => {
                        // Allow only digits (0-9) and special keys like backspace, delete, arrows, etc.
                        if (!/^\d*$/.test(e.key) && e.key !== 'Backspace' && e.key !== 'Delete' &&
                            e.key !== 'ArrowLeft' && e.key !== 'ArrowRight' && e.key !== 'Tab') {
                            e.preventDefault();

                            // Add a slight shake effect to indicate invalid input
                            weightInput.classList.add('input-shake');
                            setTimeout(() => {
                                weightInput.classList.remove('input-shake');
                            }, 600);
                        }

                        // Prevent leading zero if the field is empty and user tries to type '0'
                        if (e.key === '0' && !weightInput.value.length) {
                            e.preventDefault();

                            // Add a slight shake effect to indicate invalid input
                            weightInput.classList.add('input-shake');
                            setTimeout(() => {
                                weightInput.classList.remove('input-shake');
                            }, 600);

                            // Show temporary tooltip or highlight
                            const tooltip = document.createElement('div');
                            tooltip.className = 'leading-zero-tooltip';
                            tooltip.textContent = 'Angka tidak boleh dimulai dengan 0';
                            tooltip.style.position = 'absolute';
                            tooltip.style.backgroundColor = '#dc3545';
                            tooltip.style.color = 'white';
                            tooltip.style.padding = '5px 10px';
                            tooltip.style.borderRadius = '4px';
                            tooltip.style.fontSize = '12px';
                            tooltip.style.zIndex = '1000';
                            tooltip.style.opacity = '0';
                            tooltip.style.transition = 'opacity 0.3s';

                            const inputRect = weightInput.getBoundingClientRect();
                            tooltip.style.top = (inputRect.bottom + 5) + 'px';
                            tooltip.style.left = inputRect.left + 'px';

                            document.body.appendChild(tooltip);

                            // Fade in
                            setTimeout(() => {
                                tooltip.style.opacity = '1';
                            }, 10);

                            // Remove after 2 seconds
                            setTimeout(() => {
                                tooltip.style.opacity = '0';
                                setTimeout(() => {
                                    document.body.removeChild(tooltip);
                                }, 300);
                            }, 2000);
                        }
                    });

                    // Clean up any non-numeric characters that might be pasted
                    weightInput.addEventListener('paste', (e) => {
                        // Get pasted data
                        let pastedData = (e.clipboardData || window.clipboardData).getData('text');

                        // If pasted content contains non-numeric chars
                        if (!/^\d*$/.test(pastedData)) {
                            e.preventDefault();

                            // Extract only numbers and set as value
                            const numericValue = pastedData.replace(/[^\d]/g, '');

                            // Remove leading zeros if present
                            const cleanValue = numericValue ? parseInt(numericValue, 10).toString() : '';

                            setTimeout(() => {
                                weightInput.value = cleanValue;
                                validateWeight();
                            }, 10);

                            // Add a slight shake effect
                            weightInput.classList.add('input-shake');
                            setTimeout(() => {
                                weightInput.classList.remove('input-shake');
                            }, 600);
                        } else if (pastedData.startsWith('0')) {
                            // If paste starts with zero but is otherwise valid
                            e.preventDefault();

                            // Remove leading zeros
                            const cleanValue = pastedData ? parseInt(pastedData, 10).toString() : '';

                            setTimeout(() => {
                                weightInput.value = cleanValue;
                                validateWeight();
                            }, 10);
                        }
                    });

                    // Add event listeners for validation
                    weightInput.addEventListener('input', validateWeight);
                    weightInput.addEventListener('blur', () => {
                        removeLeadingZeros();
                        validateWeight();
                    });

                    // Check on page load (in case of prefilled value)
                    removeLeadingZeros();
                    validateWeight();

                    // Update form submission to validate first
                    const supplierForm = document.getElementById('supplierForm');
                    if (supplierForm) {
                        const originalSubmitHandler = supplierForm.onsubmit;

                        supplierForm.addEventListener('submit', function(e) {
                            removeLeadingZeros();
                            if (!validateWeight()) {
                                e.preventDefault();
                                e.stopImmediatePropagation();

                                // Scroll to the error
                                weightInput.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });
                                weightInput.focus();

                                // Show error message with SweetAlert
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Jumlah eceng gondok harus lebih dari 0 kg',
                                    icon: 'error',
                                    confirmButtonColor: '#956a3b'
                                });

                                return false;
                            }

                            // Continue with original handler if it exists
                            if (typeof originalSubmitHandler === 'function') {
                                return originalSubmitHandler.call(this, e);
                            }
                        }, true); // Use capturing to run before other handlers
                    }
                }
            });
        </script>

        <!-- Scripts for form pemasok angka hp-->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Get the phone number input field
                const phoneInput = document.getElementById('kontak');

                if (phoneInput) {
                    // Create error message element
                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'invalid-feedback';
                    errorMessage.id = 'kontak-error';

                    // Insert error message after the input group
                    phoneInput.closest('.input-group').after(errorMessage);

                    // Indonesia phone number validation regex
                    // Valid formats:
                    // - Starts with 08 followed by 8-12 digits
                    // - Or starts with +62 followed by 9-13 digits (first digit after +62 should be 8)
                    // - Or starts with 62 followed by 9-13 digits (first digit after 62 should be 8)
                    const indoPhoneRegex = /^(?:(?:\+62|62)|0)[8][0-9]{8,12}$/;

                    // Function to validate phone number
                    const validatePhone = () => {
                        const value = phoneInput.value.trim();

                        // Empty validation
                        if (!value) {
                            showError('Nomor HP tidak boleh kosong');
                            return false;
                        }

                        // Check if input contains non-numeric characters (except for + at the beginning)
                        if (!/^\+?\d+$/.test(value)) {
                            showError('Nomor HP hanya boleh berisi angka');
                            return false;
                        }

                        // Validate against Indonesian phone number pattern
                        if (!indoPhoneRegex.test(value)) {
                            // More specific error messages based on the issue
                            if (value.startsWith('0') && value.length < 10) {
                                showError('Nomor HP terlalu pendek (min. 10 digit termasuk 0 di awal)');
                            } else if (value.startsWith('0') && value.length > 13) {
                                showError('Nomor HP terlalu panjang (maks. 13 digit termasuk 0 di awal)');
                            } else if ((value.startsWith('62') || value.startsWith('+62')) && value.replace(
                                    /^\+?62/, '').length < 9) {
                                showError('Nomor HP terlalu pendek setelah kode negara +62');
                            } else if ((value.startsWith('62') || value.startsWith('+62')) && value.replace(
                                    /^\+?62/, '').length > 13) {
                                showError('Nomor HP terlalu panjang setelah kode negara +62');
                            } else if (!(value.startsWith('0') || value.startsWith('62') || value.startsWith(
                                    '+62'))) {
                                showError('Nomor HP harus dimulai dengan 08, 62, atau +62');
                            } else if (value.startsWith('0') && !value.startsWith('08')) {
                                showError('Nomor HP Indonesia harus dimulai dengan 08');
                            } else if ((value.startsWith('62') || value.startsWith('+62')) && value.charAt(value
                                    .startsWith('+') ? 3 : 2) !== '8') {
                                showError('Nomor setelah kode negara +62 harus dimulai dengan 8');
                            } else {
                                showError('Format nomor HP tidak valid (gunakan format 08xx atau +62/62)');
                            }
                            return false;
                        }

                        // Valid phone number
                        phoneInput.classList.remove('is-invalid');
                        errorMessage.style.display = 'none';
                        return true;
                    };

                    // Helper function to show error
                    const showError = (message) => {
                        phoneInput.classList.add('is-invalid');
                        errorMessage.textContent = message;
                        errorMessage.style.display = 'block';

                        // Add shake animation
                        phoneInput.classList.add('input-shake');
                        setTimeout(() => {
                            phoneInput.classList.remove('input-shake');
                        }, 600);
                    };

                    // Format phone number (optional enhancement)
                    const formatPhoneNumber = () => {
                        let value = phoneInput.value.trim();

                        // Skip if empty
                        if (!value) return;

                        // Remove all non-digit characters except leading +
                        value = value.replace(/(?!^\+)\D/g, '');

                        // Ensure proper Indonesian format
                        if (value.startsWith('+62')) {
                            // Already in international format, do nothing
                        } else if (value.startsWith('62')) {
                            // Convert to international format
                            value = '+' + value;
                        } else if (value.startsWith('0')) {
                            // Convert local format to international
                            value = '+62' + value.substring(1);
                        }

                        phoneInput.value = value;
                    };

                    // Add event listeners for validation
                    phoneInput.addEventListener('input', validatePhone);
                    phoneInput.addEventListener('blur', () => {
                        // Optional: Format on blur
                        // formatPhoneNumber();
                        validatePhone();
                    });

                    // Add to form validation
                    const supplierForm = document.getElementById('supplierForm');
                    if (supplierForm) {
                        const originalSubmitHandler = supplierForm.onsubmit;

                        supplierForm.addEventListener('submit', function(e) {
                            if (!validatePhone()) {
                                e.preventDefault();
                                e.stopImmediatePropagation();

                                // Scroll to the error
                                phoneInput.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });
                                phoneInput.focus();

                                // Show error with SweetAlert
                                Swal.fire({
                                    title: 'Error',
                                    text: document.getElementById('kontak-error').textContent,
                                    icon: 'error',
                                    confirmButtonColor: '#956a3b'
                                });

                                return false;
                            }

                            // Continue with original handler if it exists
                            if (typeof originalSubmitHandler === 'function') {
                                return originalSubmitHandler.call(this, e);
                            }
                        }, true); // Use capturing to run before other handlers
                    }
                }
            });
        </script>

        <!-- Scripts for notifikasi kirim permintaan-->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const form = document.getElementById('supplierForm');
                if (!form) return;

                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Kirim Permintaan?',
                        text: 'Apakah Data yang Anda Kirim Sudah Benar?',
                        icon: 'question',
                        iconColor: '#b9a16b',
                        showCancelButton: true,
                        reverseButtons: true,
                        focusCancel: true,
                        confirmButtonText: 'Ya, Kirim',
                        confirmButtonColor: '#28a745',
                        cancelButtonText: 'Batal',
                        cancelButtonColor: '#e3342f'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Permintaan berhasil dikirim. Anda akan dihubungi lewat WhatsApp dan jadwal penjemputan akan muncul di akun Anda.',
                                icon: 'success',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                // Submit form normal, server akan redirect
                                form.submit();
                            });
                        }
                    });
                });
            });
        </script>

        <!-- Scripts for notifikasi silahkan login dahulu-->
        <script>
            function promptLogin() {
                Swal.fire({
                    title: 'Silakan Login Terlebih Dahulu',
                    text: 'Anda harus login sebelum mengajukan permintaan Pemasok.',
                    icon: 'warning',
                    iconColor: '#b9a16b',
                    showCancelButton: true,
                    reverseButtons: true,
                    focusCancel: true,
                    confirmButtonText: 'Login Sekarang',
                    confirmButtonColor: '#28a745',
                    cancelButtonText: 'Batal',
                    cancelButtonColor: '#e3342f'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // pakai url.current supaya selalu kembali ke halaman supplier
                        const returnUrl = encodeURIComponent("{{ url()->current() }}");
                        window.location.href = `{{ route('login') }}?redirect=${returnUrl}`;
                    }
                });
            }
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const counters = document.querySelectorAll('.counter');
                counters.forEach(counter => {
                    const target = +counter.getAttribute('data-target');
                    let currentCount = 0;
                    const increment = target / 100;

                    const updateCounter = () => {
                        currentCount += increment;
                        if (currentCount < target) {
                            counter.innerText = Math.ceil(currentCount);
                            setTimeout(updateCounter, 20);
                        } else {
                            counter.innerText = target;
                        }
                    };

                    updateCounter();
                });
            });
        </script>

        <!-- Script untuk deteksi lokasi otomatis -->
        <script>
            // Koordinat batas wilayah Samosir
            const SAMOSIR_BOUNDS = {
                minLat: 2.55,
                maxLat: 2.88,
                minLng: 98.78,
                maxLng: 98.95
            };

            // Mapping koordinat ke kecamatan
            const KECAMATAN_COORDINATES = {
                "Pangururan": {
                    lat: 2.69,
                    lng: 98.94
                },
                "Simanindo": {
                    lat: 2.68,
                    lng: 98.86
                },
                "Harian": {
                    lat: 2.84,
                    lng: 98.93
                },
                "Nainggolan": {
                    lat: 2.61,
                    lng: 98.89
                },
                "Onan Runggu": {
                    lat: 2.58,
                    lng: 98.83
                },
                "Palipi": {
                    lat: 2.75,
                    lng: 98.89
                },
                "Ronggur Nihuta": {
                    lat: 2.64,
                    lng: 98.94
                },
                "Sianjur Mulamula": {
                    lat: 2.72,
                    lng: 98.82
                },
                "Sitio-tio": {
                    lat: 2.81,
                    lng: 98.87
                }
            };

            class LocationDetector {
                constructor() {
                    this.isDetecting = false;
                    this.isAutoMode = false;
                    this.currentPosition = null;
                    this.init();
                }

                init() {
                    this.bindEvents();
                    this.checkGeolocationSupport();
                }

                bindEvents() {
                    const detectBtn = document.getElementById('detectLocationBtn');

                    if (detectBtn) {
                        detectBtn.addEventListener('click', () => this.detectLocation());
                    }
                }

                checkGeolocationSupport() {
                    if (!navigator.geolocation) {
                        this.updateStatus('Geolocation tidak didukung browser ini', 'invalid');
                        document.getElementById('detectLocationBtn').disabled = true;
                    }
                }

                detectLocation() {
                    if (this.isDetecting) return;

                    this.isDetecting = true;
                    this.updateStatus('Mendeteksi lokasi...', 'detecting');

                    const detectBtn = document.getElementById('detectLocationBtn');
                    detectBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mendeteksi...';
                    detectBtn.disabled = true;

                    navigator.geolocation.getCurrentPosition(
                        (position) => this.onLocationSuccess(position),
                        (error) => this.onLocationError(error), {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 300000
                        }
                    );
                }

                onLocationSuccess(position) {
                    this.isDetecting = false;
                    this.currentPosition = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    document.getElementById('coordinateInfo').textContent =
                        `${this.currentPosition.lat.toFixed(6)}, ${this.currentPosition.lng.toFixed(6)}`;

                    const isInSamosir = this.isWithinSamosir(this.currentPosition);

                    if (isInSamosir) {
                        this.handleValidLocation();
                    } else {
                        this.handleInvalidLocation();
                    }

                    const detectBtn = document.getElementById('detectLocationBtn');
                    detectBtn.innerHTML = '<i class="fas fa-crosshairs me-2"></i>Deteksi Ulang';
                    detectBtn.disabled = false;

                    document.getElementById('locationInfo').style.display = 'block';
                }

                onLocationError(error) {
                    this.isDetecting = false;
                    let errorMessage = 'Gagal mendeteksi lokasi: ';

                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage += 'Akses lokasi ditolak.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage += 'Informasi lokasi tidak tersedia.';
                            break;
                        case error.TIMEOUT:
                            errorMessage += 'Timeout. Coba lagi.';
                            break;
                        default:
                            errorMessage += 'Error tidak dikenal.';
                            break;
                    }

                    this.updateStatus(errorMessage, 'invalid');

                    const detectBtn = document.getElementById('detectLocationBtn');
                    detectBtn.innerHTML = '<i class="fas fa-crosshairs me-2"></i>Coba Lagi';
                    detectBtn.disabled = false;
                }

                isWithinSamosir(position) {
                    return position.lat >= SAMOSIR_BOUNDS.minLat &&
                        position.lat <= SAMOSIR_BOUNDS.maxLat &&
                        position.lng >= SAMOSIR_BOUNDS.minLng &&
                        position.lng <= SAMOSIR_BOUNDS.maxLng;
                }

                handleValidLocation() {
                    this.isAutoMode = true;
                    this.updateStatus('✅ Lokasi valid - Anda berada di wilayah Samosir!', 'valid');

                    const nearestKecamatan = this.findNearestKecamatan();
                    if (nearestKecamatan) {
                        this.autoFillLocation(nearestKecamatan);
                    }

                    this.toggleManualSelection(false);
                    this.enableFormSubmission(true);
                }

                handleInvalidLocation() {
                    this.updateStatus('❌ Lokasi tidak valid - Anda berada di luar wilayah Samosir', 'invalid');

                    const distance = this.calculateDistanceToSamosir();
                    document.getElementById('distanceInfo').textContent =
                        `Jarak ke Samosir: ~${distance.toFixed(1)} km`;

                    this.enableFormSubmission(false);
                    this.showLocationWarning();
                }

                findNearestKecamatan() {
                    let nearest = null;
                    let minDistance = Infinity;

                    Object.entries(KECAMATAN_COORDINATES).forEach(([kecamatan, coords]) => {
                        const distance = this.calculateDistance(
                            this.currentPosition.lat, this.currentPosition.lng,
                            coords.lat, coords.lng
                        );

                        if (distance < minDistance) {
                            minDistance = distance;
                            nearest = kecamatan;
                        }
                    });

                    return nearest;
                }

                calculateDistance(lat1, lng1, lat2, lng2) {
                    const R = 6371;
                    const dLat = (lat2 - lat1) * Math.PI / 180;
                    const dLng = (lng2 - lng1) * Math.PI / 180;
                    const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                        Math.sin(dLng / 2) * Math.sin(dLng / 2);
                    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                    return R * c;
                }

                calculateDistanceToSamosir() {
                    const samosirCenter = {
                        lat: 2.715,
                        lng: 98.865
                    };
                    return this.calculateDistance(
                        this.currentPosition.lat, this.currentPosition.lng,
                        samosirCenter.lat, samosirCenter.lng
                    );
                }

                autoFillLocation(kecamatan) {
                    const kecamatanSelect = document.getElementById('kecamatan');
                    const desaSelect = document.getElementById('desa');

                    kecamatanSelect.value = kecamatan;
                    kecamatanSelect.dispatchEvent(new Event('change'));

                    setTimeout(() => {
                        if (desaSelect.options.length > 1) {
                            desaSelect.selectedIndex = 1;
                        }
                    }, 100);
                }

                enableManualMode() {
                    this.isAutoMode = false;
                    this.updateStatus('Mode manual diaktifkan', 'detecting');
                    this.toggleManualSelection(true);
                    this.enableFormSubmission(true);
                    document.getElementById('locationInfo').style.display = 'none';
                }

                toggleManualSelection(enabled) {
                    const manualSection = document.getElementById('manualLocationSection');

                    if (enabled) {
                        manualSection.classList.remove('manual-selection-disabled');
                    } else {
                        manualSection.classList.add('manual-selection-disabled');
                    }

                    const kecamatanSelect = document.getElementById('kecamatan');
                    const desaSelect = document.getElementById('desa');

                    kecamatanSelect.disabled = !enabled;
                    if (enabled) {
                        desaSelect.disabled = kecamatanSelect.value === '';
                    } else {
                        desaSelect.disabled = false;
                    }
                }

                enableFormSubmission(enabled) {
                    const formButtons = document.querySelectorAll('#supplierForm button[type="submit"]');
                    formButtons.forEach(button => {
                        button.disabled = !enabled;

                        if (!enabled) {
                            button.innerHTML = '<i class="fas fa-lock me-2"></i>Lokasi Tidak Valid';
                            button.classList.add('btn-secondary');
                            button.classList.remove('btn-become');
                        } else {
                            button.innerHTML = '<i class="fas fa-send me-2"></i>Kirim Permintaan';
                            button.classList.remove('btn-secondary');
                            button.classList.add('btn-become');
                        }
                    });
                }

                showLocationWarning() {
                    Swal.fire({
                        title: 'Lokasi Di Luar Jangkauan',
                        text: 'Maaf, layanan penjemputan kami hanya tersedia untuk wilayah Samosir dan sekitarnya. Anda dapat menggunakan mode manual jika yakin berada di wilayah yang tepat.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Gunakan Manual',
                        cancelButtonText: 'Mengerti',
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.enableManualMode();
                        }
                    });
                }

                updateStatus(message, type) {
                    const statusElement = document.getElementById('locationStatus');
                    const indicatorElement = document.getElementById('locationIndicator');

                    if (statusElement) {
                        statusElement.textContent = message;
                    }

                    if (indicatorElement) {
                        indicatorElement.className = `location-indicator ${type}`;
                    }
                }
            }

            // Initialize location detector
            document.addEventListener('DOMContentLoaded', function() {
                window.locationDetector = new LocationDetector();
            });
        </script>
    </main>
@endsection
