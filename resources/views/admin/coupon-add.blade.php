@extends('layouts.admin')

@section('content')
<style>
    /* Base Styling */
    .main-content-inner {
        padding: 1.5rem;
    }

    /* Form Container */
    .form-container {
        background: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 15px;
        padding: 0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 25px;
        overflow: hidden;
    }

    .form-header {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }

    .form-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
        animation: shimmer 4s infinite;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
    }

    .form-title {
        font-size: 28px;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 15px;
        z-index: 2;
        position: relative;
    }

    .form-subtitle {
        font-size: 16px;
        opacity: 0.9;
        margin: 8px 0 0 0;
        z-index: 2;
        position: relative;
    }

    .form-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        z-index: 2;
        position: relative;
    }

    .form-body {
        padding: 40px;
    }

    /* Wizard Steps */
    .wizard-container {
        margin-bottom: 40px;
    }

    .wizard-steps {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
        position: relative;
    }

    .wizard-steps::before {
        content: '';
        position: absolute;
        top: 25px;
        left: 25px;
        right: 25px;
        height: 2px;
        background: #e9ecef;
        z-index: 1;
    }

    .wizard-progress {
        position: absolute;
        top: 25px;
        left: 25px;
        height: 2px;
        background: linear-gradient(90deg, #28a745, #20c997);
        z-index: 2;
        transition: width 0.3s ease;
        width: 0%;
    }

    .wizard-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 3;
        flex: 1;
        max-width: 150px;
    }

    .wizard-step-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
        transition: all 0.3s ease;
        border: 3px solid #e9ecef;
    }

    .wizard-step.active .wizard-step-circle {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        border-color: #28a745;
        transform: scale(1.1);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }

    .wizard-step.completed .wizard-step-circle {
        background: #28a745;
        color: white;
        border-color: #28a745;
    }

    .wizard-step-label {
        margin-top: 10px;
        font-size: 13px;
        font-weight: 600;
        color: #6c757d;
        text-align: center;
        transition: color 0.3s ease;
    }

    .wizard-step.active .wizard-step-label {
        color: #28a745;
    }

    /* Form Sections */
    .form-section {
        display: none;
        animation: slideIn 0.4s ease;
    }

    .form-section.active {
        display: block;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .section-title {
        font-size: 22px;
        font-weight: 700;
        color: #495057;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f1f3f4;
    }

    .section-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #28a745, #20c997);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
    }

    /* Form Controls */
    .form-group {
        margin-bottom: 30px;
    }

    .form-label {
        font-size: 16px;
        font-weight: 600;
        color: #495057;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .required {
        color: #dc3545;
        font-weight: 700;
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 18px 20px;
        font-size: 16px;
        transition: all 0.3s ease;
        background: #ffffff;
        width: 100%;
    }

    .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.15);
        background: #ffffff;
        transform: translateY(-1px);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
    }

    .form-text {
        font-size: 14px;
        color: #6c757d;
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
        line-height: 1.4;
    }

    .input-group {
        position: relative;
    }

    .input-group-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        font-size: 18px;
        z-index: 3;
    }

    .input-group .form-control {
        padding-left: 55px;
    }

    /* Alert Styling */
    .alert {
        border-radius: 12px;
        padding: 18px 25px;
        margin-bottom: 25px;
        border: none;
        font-size: 15px;
        font-weight: 600;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    /* Coupon Generator */
    .coupon-generator {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 2px dashed #28a745;
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        margin-bottom: 25px;
    }

    .generator-title {
        font-size: 18px;
        font-weight: 700;
        color: #495057;
        margin-bottom: 15px;
    }

    .generator-buttons {
        display: flex;
        gap: 10px;
        justify-content: center;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .btn-generator {
        background: #28a745;
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-generator:hover {
        background: #218838;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    /* Live Preview */
    .live-preview {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }

    .live-preview::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
        animation: shimmer 3s infinite;
    }

    .preview-coupon {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 20px 30px;
        border-radius: 12px;
        display: inline-block;
        font-family: 'Courier New', monospace;
        font-weight: 700;
        font-size: 28px;
        letter-spacing: 3px;
        border: 2px dashed rgba(255, 255, 255, 0.5);
        min-width: 200px;
        position: relative;
        z-index: 2;
    }

    .preview-details {
        margin-top: 20px;
        color: rgba(255, 255, 255, 0.9);
        font-size: 16px;
        position: relative;
        z-index: 2;
    }

    /* Quick Templates */
    .template-section {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
    }

    .template-title {
        font-size: 18px;
        font-weight: 700;
        color: #495057;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .template-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
    }

    .template-card {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .template-card:hover {
        border-color: #28a745;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .template-name {
        font-weight: 700;
        color: #495057;
        margin-bottom: 8px;
    }

    .template-desc {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 12px;
    }

    .template-preview {
        background: #f8f9fa;
        padding: 10px;
        border-radius: 6px;
        font-family: 'Courier New', monospace;
        font-size: 12px;
        color: #007bff;
        font-weight: 600;
    }

    /* Navigation Buttons */
    .form-navigation {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 40px;
        padding-top: 25px;
        border-top: 1px solid #e9ecef;
    }

    .btn {
        padding: 15px 30px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        color: white;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #545b62;
        color: white;
        transform: translateY(-1px);
    }

    .btn-outline {
        background: transparent;
        border: 2px solid #28a745;
        color: #28a745;
    }

    .btn-outline:hover {
        background: #28a745;
        color: white;
        transform: translateY(-1px);
    }

    /* Smart Suggestions */
    .smart-suggestions {
        background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
        border: 1px solid #bbdefb;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .suggestion-title {
        font-size: 16px;
        font-weight: 700;
        color: #1565c0;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .suggestion-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .suggestion-item {
        padding: 8px 0;
        font-size: 14px;
        color: #1565c0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Loading States */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.95);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .loading-content {
        text-align: center;
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }

    .loading-spinner {
        width: 60px;
        height: 60px;
        border: 5px solid #f3f4f6;
        border-top: 5px solid #28a745;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 20px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .loading-text {
        font-size: 18px;
        color: #495057;
        font-weight: 600;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-content-inner {
            padding: 1rem;
        }

        .form-body {
            padding: 25px;
        }

        .form-header {
            padding: 25px;
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }

        .wizard-steps {
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .wizard-steps::before,
        .wizard-progress {
            display: none;
        }

        .form-navigation {
            flex-direction: column;
            gap: 15px;
        }

        .form-navigation .btn {
            width: 100%;
            justify-content: center;
        }

        .template-grid {
            grid-template-columns: 1fr;
        }

        .generator-buttons {
            flex-direction: column;
            align-items: center;
        }

        .btn-generator {
            width: 100%;
            max-width: 200px;
        }
    }

    /* Animation Classes */
    .fade-in {
        animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .bounce-in {
        animation: bounceIn 0.8s ease;
    }

    @keyframes bounceIn {
        0% { opacity: 0; transform: scale(0.3); }
        50% { opacity: 1; transform: scale(1.05); }
        70% { transform: scale(0.9); }
        100% { transform: scale(1); }
    }
</style>

<div class="main-content-inner">
    <div class="main-content-wrap">
        <!-- Page Header -->
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Buat Kupon Diskon Baru</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <a href="{{ route('admin.coupons') }}">
                        <div class="text-tiny">Kupon Diskon</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <div class="text-tiny">Buat Kupon</div>
                </li>
            </ul>
        </div>

        <!-- Main Form Container -->
        <div class="form-container fade-in">
            <!-- Form Header -->
            <div class="form-header">
                <div>
                    <h1 class="form-title">
                        <div class="form-icon">
                            <i class="icon-credit-card"></i>
                        </div>
                        Buat Kupon Diskon Baru
                    </h1>
                    <p class="form-subtitle">Buat kupon diskon menarik untuk meningkatkan penjualan dan loyalitas pelanggan</p>
                </div>
            </div>

            <div class="form-body">
                <!-- Wizard Steps -->
                <div class="wizard-container">
                    <div class="wizard-steps">
                        <div class="wizard-progress" id="wizardProgress"></div>
                        <div class="wizard-step active" data-step="1">
                            <div class="wizard-step-circle">1</div>
                            <div class="wizard-step-label">Kode Kupon</div>
                        </div>
                        <div class="wizard-step" data-step="2">
                            <div class="wizard-step-circle">2</div>
                            <div class="wizard-step-label">Nilai Diskon</div>
                        </div>
                        <div class="wizard-step" data-step="3">
                            <div class="wizard-step-circle">3</div>
                            <div class="wizard-step-label">Pengaturan</div>
                        </div>
                        <div class="wizard-step" data-step="4">
                            <div class="wizard-step-circle">4</div>
                            <div class="wizard-step-label">Review</div>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <form class="form-new-product form-style-1" method="POST" action="{{ route('admin.coupon.store') }}" id="couponForm">
                    @csrf

                    <!-- Step 1: Kode Kupon -->
                    <div class="form-section active" id="step1">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="icon-tag"></i>
                            </div>
                            Langkah 1: Buat Kode Kupon
                        </h3>

                        <!-- Quick Templates -->
                        <div class="template-section">
                            <h4 class="template-title">
                                <i class="icon-zap"></i> Template Cepat
                            </h4>
                            <div class="template-grid">
                                <div class="template-card" data-template="discount">
                                    <div class="template-name">Diskon Persentase</div>
                                    <div class="template-desc">Untuk diskon berdasarkan persentase</div>
                                    <div class="template-preview">DISKON{X}PERSEN</div>
                                </div>
                                <div class="template-card" data-template="nominal">
                                    <div class="template-name">Diskon Nominal</div>
                                    <div class="template-desc">Untuk diskon dengan nilai tetap</div>
                                    <div class="template-preview">HEMAT{X}K</div>
                                </div>
                                <div class="template-card" data-template="special">
                                    <div class="template-name">Event Khusus</div>
                                    <div class="template-desc">Untuk event atau hari khusus</div>
                                    <div class="template-preview">RAMADAN2024</div>
                                </div>
                                <div class="template-card" data-template="newbie">
                                    <div class="template-name">Pelanggan Baru</div>
                                    <div class="template-desc">Untuk menarik pelanggan baru</div>
                                    <div class="template-preview">WELCOME{X}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Coupon Generator -->
                        <div class="coupon-generator bounce-in">
                            <h4 class="generator-title">
                                <i class="icon-shuffle"></i> Generator Kode Otomatis
                            </h4>
                            <div class="generator-buttons">
                                <button type="button" class="btn-generator" onclick="generateCoupon('random')">
                                    <i class="icon-refresh"></i> Acak
                                </button>
                                <button type="button" class="btn-generator" onclick="generateCoupon('discount')">
                                    <i class="icon-percent"></i> Diskon
                                </button>
                                <button type="button" class="btn-generator" onclick="generateCoupon('save')">
                                    <i class="icon-dollar-sign"></i> Hemat
                                </button>
                                <button type="button" class="btn-generator" onclick="generateCoupon('special')">
                                    <i class="icon-star"></i> Spesial
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="icon-tag"></i> Kode Kupon <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <i class="icon-tag input-group-icon"></i>
                                <input class="form-control" type="text" placeholder="Contoh: DISKON50K" name="code"
                                       value="{{ old('code') }}" aria-required="true" style="text-transform: uppercase;" id="couponCode">
                            </div>
                            <div class="form-text">
                                <i class="icon-info"></i> Gunakan kombinasi huruf dan angka, maksimal 50 karakter. Hindari karakter khusus.
                            </div>
                            @error("code")
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Smart Suggestions -->
                        <div class="smart-suggestions">
                            <h5 class="suggestion-title">
                                <i class="icon-lightbulb"></i> Saran Cerdas
                            </h5>
                            <ul class="suggestion-list" id="smartSuggestions">
                                <li class="suggestion-item">
                                    <i class="icon-check"></i> Gunakan kata yang mudah diingat dan relevan
                                </li>
                                <li class="suggestion-item">
                                    <i class="icon-check"></i> Tambahkan nilai diskon dalam kode (contoh: HEMAT50K)
                                </li>
                                <li class="suggestion-item">
                                    <i class="icon-check"></i> Pertimbangkan target audience Anda
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Step 2: Nilai Diskon -->
                    <div class="form-section" id="step2">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="icon-dollar-sign"></i>
                            </div>
                            Langkah 2: Tentukan Nilai Diskon
                        </h3>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="icon-dollar-sign"></i> Nilai Diskon <span class="required">*</span>
                                    </label>
                                    <div class="input-group">
                                        <i class="icon-dollar-sign input-group-icon"></i>
                                        <input class="form-control format-rupiah" type="text" placeholder="Rp 50.000" name="discount_amount"
                                               value="{{ old('discount_amount') }}" aria-required="true" id="discountAmount">
                                    </div>
                                    <div class="form-text">
                                        <i class="icon-info"></i> Minimal Rp 1.000 - semakin besar nilai, semakin menarik untuk pelanggan
                                    </div>
                                    @error("discount_amount")
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="icon-shopping-cart"></i> Minimum Pembelian <span class="required">*</span>
                                    </label>
                                    <div class="input-group">
                                        <i class="icon-shopping-cart input-group-icon"></i>
                                        <input class="form-control format-rupiah" type="text" placeholder="Rp 100.000" name="minimum_order"
                                               value="{{ old('minimum_order') }}" aria-required="true" id="minimumOrder">
                                    </div>
                                    <div class="form-text">
                                        <i class="icon-info"></i> Masukkan 0 jika tidak ada minimum pembelian
                                    </div>
                                    @error("minimum_order")
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Quick Amount Buttons -->
                        <div class="template-section">
                            <h4 class="template-title">
                                <i class="icon-zap"></i> Nilai Populer
                            </h4>
                            <div class="template-grid">
                                <div class="template-card" onclick="setAmount('10000', '50000')">
                                    <div class="template-name">Starter</div>
                                    <div class="template-desc">Diskon Rp 10.000 | Min. Rp 50.000</div>
                                </div>
                                <div class="template-card" onclick="setAmount('25000', '100000')">
                                    <div class="template-name">Popular</div>
                                    <div class="template-desc">Diskon Rp 25.000 | Min. Rp 100.000</div>
                                </div>
                                <div class="template-card" onclick="setAmount('50000', '200000')">
                                    <div class="template-name">Premium</div>
                                    <div class="template-desc">Diskon Rp 50.000 | Min. Rp 200.000</div>
                                </div>
                                <div class="template-card" onclick="setAmount('100000', '500000')">
                                    <div class="template-name">VIP</div>
                                    <div class="template-desc">Diskon Rp 100.000 | Min. Rp 500.000</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Pengaturan -->
                    <div class="form-section" id="step3">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="icon-settings"></i>
                            </div>
                            Langkah 3: Pengaturan Kupon
                        </h3>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="icon-calendar"></i> Tanggal Berakhir <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <i class="icon-calendar input-group-icon"></i>
                                <input class="form-control" type="date" name="expiry_date"
                                       value="{{ old('expiry_date') }}"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}" aria-required="true" id="expiryDate">
                            </div>
                            <div class="form-text">
                                <i class="icon-clock"></i> Kupon akan otomatis tidak aktif setelah tanggal ini
                            </div>
                            @error("expiry_date")
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Quick Date Buttons -->
                        <div class="template-section">
                            <h4 class="template-title">
                                <i class="icon-calendar"></i> Durasi Populer
                            </h4>
                            <div class="template-grid">
                                <div class="template-card" onclick="setExpiryDate(7)">
                                    <div class="template-name">1 Minggu</div>
                                    <div class="template-desc">Promosi singkat dan mendesak</div>
                                </div>
                                <div class="template-card" onclick="setExpiryDate(30)">
                                    <div class="template-name">1 Bulan</div>
                                    <div class="template-desc">Promosi reguler</div>
                                </div>
                                <div class="template-card" onclick="setExpiryDate(60)">
                                    <div class="template-name">2 Bulan</div>
                                    <div class="template-desc">Promosi jangka menengah</div>
                                </div>
                                <div class="template-card" onclick="setExpiryDate(90)">
                                    <div class="template-name">3 Bulan</div>
                                    <div class="template-desc">Promosi jangka panjang</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Review -->
                    <div class="form-section" id="step4">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="icon-eye"></i>
                            </div>
                            Langkah 4: Review & Konfirmasi
                        </h3>

                        <!-- Live Preview -->
                        <div class="live-preview">
                            <div class="preview-coupon" id="finalPreview">
                                KODE KUPON
                            </div>
                            <div class="preview-details" id="finalDetails">
                                <strong>Diskon:</strong> <span id="finalDiscount">Rp 0</span> |
                                <strong>Min. Pembelian:</strong> <span id="finalMinimum">Rp 0</span> |
                                <strong>Berakhir:</strong> <span id="finalExpiry">-</span>
                            </div>
                        </div>

                        <!-- Summary -->
                        <div class="template-section">
                            <h4 class="template-title">
                                <i class="icon-check-square"></i> Ringkasan Kupon
                            </h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Kode Kupon</label>
                                        <div class="form-control" style="background: #f8f9fa;" id="summaryCode">-</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Nilai Diskon</label>
                                        <div class="form-control" style="background: #f8f9fa;" id="summaryDiscount">-</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Minimum Pembelian</label>
                                        <div class="form-control" style="background: #f8f9fa;" id="summaryMinimum">-</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Berakhir</label>
                                        <div class="form-control" style="background: #f8f9fa;" id="summaryExpiry">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="form-navigation">
                        <button type="button" class="btn btn-secondary" id="prevBtn" style="display: none;">
                            <i class="icon-arrow-left"></i> Sebelumnya
                        </button>

                        <div style="flex: 1;"></div>

                        <a href="{{ route('admin.coupons') }}" class="btn btn-outline">
                            <i class="icon-x"></i> Batal
                        </a>

                        <button type="button" class="btn btn-primary" id="nextBtn">
                            Selanjutnya <i class="icon-arrow-right"></i>
                        </button>

                        <button type="submit" class="btn btn-primary" id="submitBtn" style="display: none;">
                            <i class="icon-check"></i> Buat Kupon
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-content">
        <div class="loading-spinner"></div>
        <div class="loading-text">Membuat kupon baru...</div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Global variables
    let currentStep = 1;
    const totalSteps = 4;

    // Utility functions
    function formatRupiah(value) {
        if (!value) return '';
        let number = value.toString().replace(/[^0-9]/g, '');
        if (number === '') return '';
        return 'Rp ' + parseInt(number).toLocaleString('id-ID');
    }

    function cleanRupiah(value) {
        return value.replace(/[^0-9]/g, '');
    }

    // Coupon generators
    function generateCoupon(type) {
        const patterns = {
            random: () => 'KUPON' + Math.random().toString(36).substr(2, 6).toUpperCase(),
            discount: () => 'DISKON' + (Math.floor(Math.random() * 9) + 1) + '0K',
            save: () => 'HEMAT' + (Math.floor(Math.random() * 9) + 1) + '0K',
            special: () => 'SPESIAL' + Math.random().toString(36).substr(2, 4).toUpperCase()
        };

        const code = patterns[type]();
        document.getElementById('couponCode').value = code;
        updatePreview();

        // Sweet animation
        const input = document.getElementById('couponCode');
        input.style.transform = 'scale(1.05)';
        input.style.background = '#e8f5e8';
        setTimeout(() => {
            input.style.transform = 'scale(1)';
            input.style.background = '#ffffff';
        }, 300);
    }

    // Set amount templates
    function setAmount(discount, minimum) {
        document.getElementById('discountAmount').value = formatRupiah(discount);
        document.getElementById('minimumOrder').value = formatRupiah(minimum);
        updatePreview();
    }

    // Set expiry date
    function setExpiryDate(days) {
        const date = new Date();
        date.setDate(date.getDate() + days);
        const formattedDate = date.toISOString().split('T')[0];
        document.getElementById('expiryDate').value = formattedDate;
        updatePreview();
    }

    // Update preview
    function updatePreview() {
        const code = document.getElementById('couponCode').value || 'KODE KUPON';
        const discount = document.getElementById('discountAmount').value || 'Rp 0';
        const minimum = document.getElementById('minimumOrder').value || 'Rp 0';
        const expiry = document.getElementById('expiryDate').value || '-';

        // Update final preview
        document.getElementById('finalPreview').textContent = code;
        document.getElementById('finalDiscount').textContent = discount;
        document.getElementById('finalMinimum').textContent = minimum;
        document.getElementById('finalExpiry').textContent = expiry ? new Date(expiry).toLocaleDateString('id-ID') : '-';

        // Update summary
        document.getElementById('summaryCode').textContent = code;
        document.getElementById('summaryDiscount').textContent = discount;
        document.getElementById('summaryMinimum').textContent = minimum;
        document.getElementById('summaryExpiry').textContent = expiry ? new Date(expiry).toLocaleDateString('id-ID') : '-';
    }

    // Step navigation
    function showStep(step) {
        // Hide all steps
        document.querySelectorAll('.form-section').forEach(section => {
            section.classList.remove('active');
        });

        // Show current step
        document.getElementById(`step${step}`).classList.add('active');

        // Update wizard steps
        document.querySelectorAll('.wizard-step').forEach((stepEl, index) => {
            stepEl.classList.remove('active', 'completed');
            if (index + 1 < step) {
                stepEl.classList.add('completed');
            } else if (index + 1 === step) {
                stepEl.classList.add('active');
            }
        });

        // Update progress bar
        const progress = ((step - 1) / (totalSteps - 1)) * 100;
        document.getElementById('wizardProgress').style.width = progress + '%';

        // Update navigation buttons
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');

        prevBtn.style.display = step > 1 ? 'flex' : 'none';
        nextBtn.style.display = step < totalSteps ? 'flex' : 'none';
        submitBtn.style.display = step === totalSteps ? 'flex' : 'none';

        currentStep = step;
    }

    // Validation
    function validateStep(step) {
        let isValid = true;

        switch(step) {
            case 1:
                const code = document.getElementById('couponCode').value.trim();
                if (!code) {
                    Swal.fire({
                        title: 'Kode Kupon Diperlukan',
                        text: 'Silakan masukkan kode kupon terlebih dahulu.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    isValid = false;
                }
                break;

            case 2:
                const discount = cleanRupiah(document.getElementById('discountAmount').value);
                const minimum = cleanRupiah(document.getElementById('minimumOrder').value);

                if (!discount || parseInt(discount) < 1000) {
                    Swal.fire({
                        title: 'Nilai Diskon Tidak Valid',
                        text: 'Nilai diskon minimal Rp 1.000.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    isValid = false;
                } else if (minimum && parseInt(discount) > parseInt(minimum)) {
                    Swal.fire({
                        title: 'Nilai Tidak Logis',
                        text: 'Nilai diskon tidak boleh lebih besar dari minimum pembelian.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    isValid = false;
                }
                break;

            case 3:
                const expiry = document.getElementById('expiryDate').value;
                if (!expiry) {
                    Swal.fire({
                        title: 'Tanggal Berakhir Diperlukan',
                        text: 'Silakan pilih tanggal berakhir kupon.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    isValid = false;
                } else if (new Date(expiry) <= new Date()) {
                    Swal.fire({
                        title: 'Tanggal Tidak Valid',
                        text: 'Tanggal berakhir harus minimal besok.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    isValid = false;
                }
                break;
        }

        return isValid;
    }

    // Document ready
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize
        showStep(1);
        updatePreview();

        // Rupiah formatting
        const rupiahInputs = document.querySelectorAll('.format-rupiah');
        rupiahInputs.forEach(input => {
            input.addEventListener('input', function(){
                let value = cleanRupiah(this.value);
                if (value !== '') {
                    this.value = formatRupiah(value);
                }
                updatePreview();
            });

            input.addEventListener('paste', function(e) {
                setTimeout(() => {
                    let value = cleanRupiah(this.value);
                    if (value !== '') {
                        this.value = formatRupiah(value);
                    }
                    updatePreview();
                }, 1);
            });
        });

        // Real-time preview updates
        document.getElementById('couponCode').addEventListener('input', function() {
            this.value = this.value.toUpperCase();
            updatePreview();
        });

        document.getElementById('expiryDate').addEventListener('change', updatePreview);

        // Template selection
        document.querySelectorAll('.template-card').forEach(card => {
            card.addEventListener('click', function() {
                const template = this.getAttribute('data-template');
                if (template) {
                    const templates = {
                        discount: 'DISKON{X}PERSEN',
                        nominal: 'HEMAT{X}K',
                        special: 'RAMADAN2024',
                        newbie: 'WELCOME{X}'
                    };

                    if (templates[template]) {
                        const code = templates[template].replace('{X}', Math.floor(Math.random() * 9) + 1);
                        document.getElementById('couponCode').value = code;
                        updatePreview();
                    }
                }
            });
        });

        // Navigation buttons
        document.getElementById('nextBtn').addEventListener('click', function() {
            if (validateStep(currentStep)) {
                if (currentStep < totalSteps) {
                    showStep(currentStep + 1);
                }
            }
        });

        document.getElementById('prevBtn').addEventListener('click', function() {
            if (currentStep > 1) {
                showStep(currentStep - 1);
            }
        });

        // Form submission
        document.getElementById('couponForm').addEventListener('submit', function(e) {
            if (!validateStep(currentStep)) {
                e.preventDefault();
                return;
            }

            // Show loading
            document.getElementById('loadingOverlay').style.display = 'flex';

            // Clean rupiah format before submit
            rupiahInputs.forEach(input => {
                let cleanValue = cleanRupiah(input.value);
                input.value = cleanValue;
            });
        });

        // Success/Error messages
        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                iconColor: '#28a745',
                confirmButtonText: 'OK',
                confirmButtonColor: '#28a745'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: '{{ session('error') }}',
                icon: 'error',
                iconColor: '#e74c3c',
                confirmButtonText: 'OK',
                confirmButtonColor: '#e74c3c'
            });
        @endif

        // Hide loading on page load
        window.addEventListener('load', function() {
            document.getElementById('loadingOverlay').style.display = 'none';
        });

        // Auto-focus first input
        setTimeout(() => {
            document.getElementById('couponCode').focus();
        }, 500);
    });
</script>
@endsection
