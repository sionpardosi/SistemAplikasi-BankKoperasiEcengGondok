@extends('layouts.admin')

@section('content')
    <style>
        /* Base Styling */
        .main-content-inner {
            padding: 1.5rem;
        }

        /* Page Header */
        .page-header {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: #495057;
            margin: 0;
        }

        /* Form Sections */
        .form-section {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
            margin-right: 15px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: #495057;
            margin: 0;
        }

        .section-subtitle {
            font-size: 14px;
            color: #6c757d;
            margin: 5px 0 0 0;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-size: 15px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            display: block;
        }

        .required {
            color: #dc3545;
            margin-left: 3px;
        }

        .form-control,
        .form-select {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #ffffff;
            width: 100%;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            outline: none;
        }

        .form-text {
            font-size: 13px;
            color: #6c757d;
            margin-top: 5px;
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 16px;
            z-index: 2;
        }

        .input-icon+.form-control {
            padding-left: 45px;
        }

        /* Checkbox Styling */
        .custom-checkbox {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .custom-checkbox input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            cursor: pointer;
        }

        .custom-checkbox label {
            font-size: 15px;
            font-weight: 600;
            color: #495057;
            cursor: pointer;
            margin: 0;
        }

        /* Price Display */
        .price-preview {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-top: 15px;
        }

        .price-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .price-item:last-child {
            margin-bottom: 0;
            padding-top: 10px;
            border-top: 1px solid #dee2e6;
            font-weight: 700;
        }

        .price-label {
            font-size: 14px;
            color: #6c757d;
        }

        .price-value {
            font-size: 16px;
            font-weight: 600;
            color: #495057;
        }

        .discount-value {
            color: #28a745;
            font-weight: 700;
        }

        /* Image Upload */
        .upload-section {
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .upload-section:hover {
            border-color: #007bff;
            background: #f0f7ff;
        }

        .upload-section.dragover {
            border-color: #007bff;
            background: #e3f2fd;
        }

        .upload-icon {
            font-size: 48px;
            color: #6c757d;
            margin-bottom: 15px;
        }

        .upload-text {
            font-size: 16px;
            color: #495057;
            margin-bottom: 10px;
        }

        .upload-subtext {
            font-size: 14px;
            color: #6c757d;
        }

        .file-input {
            display: none;
        }

        /* Image Preview */
        .image-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }

        .preview-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .preview-item img {
            width: 120px;
            height: 120px;
            object-fit: cover;
        }

        .preview-remove {
            position: absolute;
            top: 5px;
            right: 5px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Size Management */
        .size-container {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-top: 15px;
        }

        .size-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .size-item {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 15px;
        }

        .size-item.selected {
            border-color: #007bff;
            background: #f0f7ff;
        }

        .size-checkbox {
            margin-right: 10px;
        }

        .size-name {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .size-stock {
            width: 100%;
            padding: 8px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            font-size: 14px;
        }

        .new-size-section {
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
            margin-top: 20px;
        }

        .new-size-row {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 10px;
        }

        .new-size-input {
            flex: 1;
            max-width: 150px;
        }

        .new-stock-input {
            flex: 1;
            max-width: 100px;
        }

        /* Buttons */
        .btn {
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4);
            color: white;
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
            color: white;
        }

        .btn-outline {
            background: transparent;
            border: 2px solid #007bff;
            color: #007bff;
        }

        .btn-outline:hover {
            background: #007bff;
            color: white;
        }

        .btn-sm {
            padding: 8px 15px;
            font-size: 14px;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
            color: white;
        }

        /* Alert Messages */
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: none;
            font-size: 14px;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .alert-success {
            background: #d1f2eb;
            color: #0c5460;
            border-left: 4px solid #28a745;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }

        /* Stock Summary */
        .stock-summary {
            background: #e8f5e8;
            border: 1px solid #c3e6c3;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
        }

        .stock-total {
            font-size: 18px;
            font-weight: 700;
            color: #2e7d32;
            text-align: center;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content-inner {
                padding: 1rem;
            }

            .form-section {
                padding: 20px;
            }

            .row>.col-md-6 {
                margin-bottom: 20px;
            }

            .size-grid {
                grid-template-columns: 1fr;
            }

            .new-size-row {
                flex-direction: column;
                gap: 10px;
            }

            .new-size-input,
            .new-stock-input {
                max-width: 100%;
            }
        }

        /* Loading States */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Validation */
        .is-invalid {
            border-color: #dc3545;
        }

        .is-valid {
            border-color: #28a745;
        }

        .validation-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
        }

        /* Progress Indicator */
        .progress-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            padding: 0 20px;
        }

        .progress-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            position: relative;
        }

        .progress-step::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 50%;
            right: -50%;
            height: 2px;
            background: #dee2e6;
            z-index: 1;
        }

        .progress-step:last-child::before {
            display: none;
        }

        .progress-step.active::before {
            background: #007bff;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #dee2e6;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            z-index: 2;
            position: relative;
        }

        .progress-step.active .step-circle {
            background: #007bff;
            color: white;
        }

        .step-label {
            margin-top: 10px;
            font-size: 12px;
            color: #6c757d;
            text-align: center;
        }

        .progress-step.active .step-label {
            color: #007bff;
            font-weight: 600;
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Page Header -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Manajemen Tambah Produk</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.products') }}">
                            <div class="text-tiny">Produk</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Tambah Produk</div>
                    </li>
                </ul>
            </div>

            <!-- Progress Indicator -->
            <div class="progress-indicator">
                <div class="progress-step active" data-step="1">
                    <div class="step-circle">1</div>
                    <div class="step-label">Informasi Dasar</div>
                </div>
                <div class="progress-step" data-step="2">
                    <div class="step-circle">2</div>
                    <div class="step-label">Gambar Produk</div>
                </div>
                <div class="progress-step" data-step="3">
                    <div class="step-circle">3</div>
                    <div class="step-label">Harga & Stok</div>
                </div>
                <div class="progress-step" data-step="4">
                    <div class="step-circle">4</div>
                    <div class="step-label">Pengaturan</div>
                </div>
            </div>

            <form class="product-form" method="POST" enctype="multipart/form-data"
                action="{{ route('admin.product.store') }}">
                @csrf

                <!-- Section 1: Informasi Dasar -->
                <div class="form-section" data-section="1">
                    <div class="section-header">
                        <div class="section-icon bg-primary">
                            <i class="icon-info"></i>
                        </div>
                        <div>
                            <h4 class="section-title">Informasi Dasar Produk</h4>
                            <p class="section-subtitle">Masukkan nama, deskripsi, dan kategori produk</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nama Produk <span class="required">*</span></label>
                                <div class="input-group">
                                    <i class="icon-tag input-icon"></i>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Masukkan nama produk yang menarik" value="{{ old('name') }}"
                                        required>
                                </div>
                                <div class="form-text">Maksimal 100 karakter. Gunakan nama yang deskriptif dan mudah dicari.
                                </div>
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Slug Produk <span class="required">*</span></label>
                                <div class="input-group">
                                    <i class="icon-link input-icon"></i>
                                    <input type="text" name="slug" class="form-control"
                                        placeholder="slug-akan-dibuat-otomatis" value="{{ old('slug') }}" required>
                                </div>
                                <div class="form-text">URL-friendly identifier. Akan dibuat otomatis dari nama produk.</div>
                                @error('slug')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Kategori <span class="required">*</span></label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Pilih Kategori Produk</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Merek <span class="required">*</span></label>
                                <select name="brand_id" class="form-select" required>
                                    <option value="">Pilih Merek Produk</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi Singkat <span class="required">*</span></label>
                        <textarea name="short_description" class="form-control" rows="3"
                            placeholder="Ringkasan singkat produk untuk ditampilkan di halaman daftar produk" required>{{ old('short_description') }}</textarea>
                        <div class="form-text">Maksimal 200 karakter. Deskripsi singkat yang menarik untuk menarik perhatian
                            pelanggan.</div>
                        @error('short_description')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi Lengkap <span class="required">*</span></label>
                        <textarea name="description" class="form-control" rows="6"
                            placeholder="Deskripsi detail produk, fitur, spesifikasi, dan informasi penting lainnya" required>{{ old('description') }}</textarea>
                        <div class="form-text">Berikan informasi lengkap tentang produk, termasuk fitur, spesifikasi, dan
                            keunggulan.</div>
                        @error('description')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Section 2: Gambar Produk -->
                <div class="form-section" data-section="2">
                    <div class="section-header">
                        <div class="section-icon bg-success">
                            <i class="icon-picture"></i>
                        </div>
                        <div>
                            <h4 class="section-title">Gambar Produk</h4>
                            <p class="section-subtitle">Upload gambar utama dan gambar galeri produk</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Gambar Utama <span class="required">*</span></label>
                                <div class="upload-section" id="main-upload">
                                    <div class="upload-icon">
                                        <i class="icon-camera"></i>
                                    </div>
                                    <div class="upload-text">Drag & drop gambar atau klik untuk browse</div>
                                    <div class="upload-subtext">Format: JPG, PNG, JPEG | Maksimal: 2MB</div>
                                    <input type="file" name="image" class="file-input" id="mainImageInput"
                                        accept="image/*" required>
                                </div>
                                <div class="image-preview" id="mainImagePreview"></div>
                                @error('image')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Gambar Galeri</label>
                                <div class="upload-section" id="gallery-upload">
                                    <div class="upload-icon">
                                        <i class="icon-layers"></i>
                                    </div>
                                    <div class="upload-text">Upload beberapa gambar sekaligus</div>
                                    <div class="upload-subtext">Format: JPG, PNG, JPEG | Maksimal: 2MB per file</div>
                                    <input type="file" name="images[]" class="file-input" id="galleryInput"
                                        accept="image/*" multiple>
                                </div>
                                <div class="image-preview" id="galleryPreview"></div>
                                @error('images')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Harga & Stok -->
                <div class="form-section" data-section="3">
                    <div class="section-header">
                        <div class="section-icon bg-warning">
                            <i class="icon-credit-card"></i>
                        </div>
                        <div>
                            <h4 class="section-title">Harga & Manajemen Stok</h4>
                            <p class="section-subtitle">Atur harga, diskon, dan manajemen stok produk</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Harga Normal <span class="required">*</span></label>
                                <div class="input-group">
                                    <i class="icon-credit-card input-icon"></i>
                                    <input type="text" name="regular_price" class="form-control price-input"
                                        placeholder="0"
                                        value="{{ old('regular_price') ? formatRupiah(old('regular_price')) : '' }}"
                                        required>
                                </div>
                                <div class="form-text">Harga jual normal produk sebelum diskon.</div>
                                @error('regular_price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Harga Diskon</label>
                                <div class="input-group">
                                    <i class="icon-credit-card input-icon"></i>
                                    <input type="text" name="sale_price" class="form-control price-input"
                                        placeholder="0 (Opsional - kosongkan jika tidak ada diskon)"
                                        value="{{ old('sale_price') ? formatRupiah(old('sale_price')) : '' }}">
                                </div>
                                <div class="form-text">Harga setelah diskon. Kosongkan jika tidak ada diskon.</div>
                                @error('sale_price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Price Preview -->
                    <div class="price-preview" id="pricePreview" style="display: none;">
                        <div class="price-item">
                            <span class="price-label">Harga Normal:</span>
                            <span class="price-value" id="normalPriceDisplay">Rp 0</span>
                        </div>
                        <div class="price-item">
                            <span class="price-label">Harga Diskon:</span>
                            <span class="price-value" id="discountPriceDisplay">Rp 0</span>
                        </div>
                        <div class="price-item">
                            <span class="price-label">Hemat:</span>
                            <span class="price-value discount-value" id="savingsDisplay">Rp 0 (0%)</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">SKU <span class="required">*</span></label>
                                <div class="input-group">
                                    <i class="icon-layers input-icon"></i>
                                    <input type="text" name="SKU" class="form-control" placeholder="PRD-001"
                                        value="{{ old('SKU') }}" required>
                                </div>
                                <div class="form-text">Kode unik produk untuk tracking inventory.</div>
                                @error('SKU')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6" id="quantity-field">
                            <div class="form-group">
                                <label class="form-label">Kuantitas Stok <span class="required">*</span></label>
                                <div class="input-group">
                                    <i class="icon-layers input-icon"></i>
                                    <input type="number" name="quantity" class="form-control" placeholder="0"
                                        value="{{ old('quantity', 1) }}" min="0">
                                </div>
                                <div class="form-text">Jumlah stok produk yang tersedia.</div>
                                @error('quantity')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Size Management -->
                    <div class="custom-checkbox">
                        <input type="checkbox" name="has_sizes" id="hasSizes" {{ old('has_sizes') ? 'checked' : '' }}>
                        <label for="hasSizes">Produk ini memiliki variasi ukuran</label>
                    </div>

                    <div class="size-container" id="sizeContainer"
                        style="{{ old('has_sizes') ? '' : 'display: none;' }}">
                        <h5><i class="icon-layers"></i> Manajemen Ukuran & Stok</h5>
                        <p class="form-text">Pilih ukuran yang tersedia dan atur stok masing-masing ukuran.</p>

                        <div class="size-grid" id="existingSizes">
                            @foreach ($sizes as $size)
                                <div class="size-item">
                                    <div class="size-name">
                                        <input type="checkbox" name="sizes[]" value="{{ $size->id }}"
                                            id="size_{{ $size->id }}" class="size-checkbox"
                                            {{ is_array(old('sizes')) && in_array($size->id, old('sizes')) ? 'checked' : '' }}>
                                        <label for="size_{{ $size->id }}">{{ $size->name }}</label>
                                    </div>
                                    <input type="number" name="stocks[{{ $size->id }}]" class="size-stock"
                                        placeholder="Stok" min="0" value="{{ old('stocks.' . $size->id, 0) }}"
                                        {{ is_array(old('sizes')) && in_array($size->id, old('sizes')) ? '' : 'disabled' }}>
                                </div>
                            @endforeach
                        </div>

                        <div class="new-size-section">
                            <h6><i class="icon-plus"></i> Tambah Ukuran Baru</h6>
                            <div id="newSizesContainer">
                                @if (old('new_sizes'))
                                    @foreach (old('new_sizes') as $key => $newSize)
                                        @if (!empty($newSize))
                                            <div class="new-size-row">
                                                <input type="text" name="new_sizes[]"
                                                    class="form-control new-size-input" placeholder="Ukuran baru"
                                                    value="{{ $newSize }}">
                                                <input type="number" name="new_stocks[]"
                                                    class="form-control new-stock-input" placeholder="Stok"
                                                    min="0" value="{{ old('new_stocks.' . $key, 0) }}">
                                                <button type="button" class="btn btn-danger btn-sm remove-new-size">
                                                    <i class="icon-trash"></i>
                                                </button>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="new-size-row">
                                        <input type="text" name="new_sizes[]" class="form-control new-size-input"
                                            placeholder="Ukuran baru (contoh: 38, S, M, L)">
                                        <input type="number" name="new_stocks[]" class="form-control new-stock-input"
                                            placeholder="Stok" min="0" value="0">
                                        <button type="button" class="btn btn-danger btn-sm remove-new-size"
                                            style="display:none;">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" id="addNewSize" class="btn btn-outline btn-sm">
                                <i class="icon-plus"></i> Tambah Ukuran Baru
                            </button>
                        </div>

                        <div class="stock-summary" id="stockSummary" style="display: none;">
                            <div class="stock-total">
                                Total Stok: <span id="totalStockValue">0</span> unit
                            </div>
                        </div>

                        @error('sizes')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        @error('new_sizes')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Section 4: Pengaturan -->
                <div class="form-section" data-section="4">
                    <div class="section-header">
                        <div class="section-icon bg-info">
                            <i class="icon-settings"></i>
                        </div>
                        <div>
                            <h4 class="section-title">Pengaturan Produk</h4>
                            <p class="section-subtitle">Atur status stok dan pengaturan lainnya</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Status Stok</label>
                                <select name="stock_status" class="form-select">
                                    <option value="instock" {{ old('stock_status') == 'instock' ? 'selected' : '' }}>
                                        Tersedia</option>
                                    <option value="outofstock"
                                        {{ old('stock_status') == 'outofstock' ? 'selected' : '' }}>Habis</option>
                                </select>
                                @error('stock_status')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Produk Unggulan</label>
                                <select name="featured" class="form-select">
                                    <option value="0" {{ old('featured') == '0' ? 'selected' : '' }}>Tidak</option>
                                    <option value="1" {{ old('featured') == '1' ? 'selected' : '' }}>Ya</option>
                                </select>
                                <div class="form-text">Produk unggulan akan ditampilkan di bagian khusus website.</div>
                                @error('featured')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group">
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route('admin.products') }}" class="btn btn-outline">
                                <i class="icon-arrow-left"></i> Kembali
                            </a>
                            <button type="button" class="btn btn-outline" id="previewBtn">
                                <i class="icon-eye"></i> Preview
                            </button>
                            <button type="submit" class="btn btn-success" id="submitBtn">
                                <i class="icon-check"></i> Simpan Produk
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="icon-eye"></i> Preview Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="previewContent">
                    <!-- Preview content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-success" onclick="$('#submitBtn').click()"
                        data-bs-dismiss="modal">Simpan Produk</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Initialize form
            initializeForm();

            // Auto-generate slug from product name
            $('input[name="name"]').on('input', function() {
                const name = $(this).val();
                if (name.length >= 2) {
                    const slug = generateSlug(name);
                    $('input[name="slug"]').val(slug);
                }
            });

            // Auto-generate SKU when category and brand selected
            $('select[name="category_id"], select[name="brand_id"]').on('change', function() {
                const categoryId = $('select[name="category_id"]').val();
                const brandId = $('select[name="brand_id"]').val();

                if (categoryId && brandId) {
                    generateSKU(categoryId, brandId);
                }
            });

            // Price formatting and discount calculation
            $('.price-input').on('input', function() {
                let value = $(this).val().replace(/[^0-9]/g, '');
                if (value) {
                    $(this).val(formatRupiah(value));
                }
                calculateDiscount();
            });

            // Image upload handling
            $('#mainImageInput').on('change', function() {
                handleImageUpload(this, '#mainImagePreview', false);
            });

            $('#galleryInput').on('change', function() {
                handleImageUpload(this, '#galleryPreview', true);
            });

            // Setup drag and drop
            setupDragAndDrop();

            // Size management
            setupSizeManagement();

            // Preview functionality
            $('#previewBtn').on('click', function() {
                generatePreview();
            });

            // Form submission - SIMPLIFIED to allow normal submit
            $('.product-form').on('submit', function() {
                // Show loading state
                $('#submitBtn').prop('disabled', true).html('<span class="spinner"></span> Menyimpan...');

                // Allow normal form submission
                return true;
            });

            // Initialize calculations
            calculateDiscount();
        });

        // Utility Functions
        function generateSlug(text) {
            return text.toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
        }

        function formatRupiah(angka) {
            const number_string = angka.toString().replace(/[^,\d]/g, '');
            const split = number_string.split(',');
            const sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                const separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return 'Rp ' + rupiah;
        }

        function parseRupiah(rupiah) {
            return parseInt(rupiah.replace(/[^0-9]/g, '')) || 0;
        }

        // Auto-generate SKU
        function generateSKU(categoryId, brandId) {
            // Simple SKU generation - you can customize this
            const categoryCode = $('select[name="category_id"] option:selected').text().substring(0, 3).toUpperCase();
            const brandCode = $('select[name="brand_id"] option:selected').text().substring(0, 3).toUpperCase();
            const timestamp = Date.now().toString().slice(-4);

            const sku = `${categoryCode}${brandCode}${timestamp}`;

            if (!$('input[name="SKU"]').val()) {
                $('input[name="SKU"]').val(sku);

                // Show notification
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: 'SKU otomatis dibuat: ' + sku,
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        }

        // Image Handling
        function handleImageUpload(input, containerSelector, multiple = false) {
            const container = $(containerSelector);
            const files = input.files;

            if (!multiple) {
                container.empty();
            }

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (file.type.startsWith('image/')) {
                    createImagePreview(file, container);
                }
            }
        }

        function createImagePreview(file, container) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = $(`
                    <div class="preview-item">
                        <img src="${e.target.result}" alt="Preview">
                        <button type="button" class="preview-remove" onclick="removePreview(this)">
                            <i class="icon-trash"></i>
                        </button>
                    </div>
                `);
                container.append(preview);
            };
            reader.readAsDataURL(file);
        }

        function removePreview(button) {
            $(button).closest('.preview-item').remove();
        }

        // Drag and Drop Setup
        function setupDragAndDrop() {
            $('.upload-section').on('dragover dragenter', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('dragover');
            });

            $('.upload-section').on('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');
            });

            $('.upload-section').on('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');

                const files = e.originalEvent.dataTransfer.files;
                const input = $(this).find('input[type="file"]')[0];
                input.files = files;
                $(input).trigger('change');
            });

            $('.upload-section').on('click', function(e) {
                if (!$(e.target).is('input[type="file"]')) {
                    $(this).find('input[type="file"]').click();
                }
            });
        }

        // Size Management
        function setupSizeManagement() {
            $('#hasSizes').on('change', function() {
                const isChecked = $(this).is(':checked');

                if (isChecked) {
                    $('#sizeContainer').slideDown(400);
                    $('#quantity-field').slideUp(400);
                    $('input[name="quantity"]').removeAttr('required');
                    setTimeout(calculateTotalStock, 450);
                } else {
                    $('#sizeContainer').slideUp(400);
                    $('#quantity-field').slideDown(400);
                    $('input[name="quantity"]').attr('required', 'required');
                    $('#stockSummary').hide();
                }
            });

            $(document).on('change', '.size-checkbox', function() {
                const stockInput = $(this).closest('.size-item').find('.size-stock');
                const isChecked = $(this).is(':checked');

                if (isChecked) {
                    stockInput.prop('disabled', false).focus().closest('.size-item').addClass('selected');
                } else {
                    stockInput.prop('disabled', true).val(0).closest('.size-item').removeClass('selected');
                }

                calculateTotalStock();
            });

            $(document).on('input change', '.size-stock, .new-stock-input', function() {
                calculateTotalStock();
            });

            $('#addNewSize').on('click', function() {
                addNewSizeRow();
            });

            $(document).on('click', '.remove-new-size', function() {
                $(this).closest('.new-size-row').slideUp(300, function() {
                    $(this).remove();
                    calculateTotalStock();
                });
            });
        }

        function addNewSizeRow() {
            const container = $('#newSizesContainer');
            const newRow = $(`
                <div class="new-size-row" style="display: none;">
                    <input type="text" name="new_sizes[]" class="form-control new-size-input"
                           placeholder="Ukuran baru (contoh: 38, S, M, L)">
                    <input type="number" name="new_stocks[]" class="form-control new-stock-input"
                           placeholder="Stok" min="0" value="0">
                    <button type="button" class="btn btn-danger btn-sm remove-new-size">
                        <i class="icon-trash"></i>
                    </button>
                </div>
            `);

            container.append(newRow);
            newRow.slideDown(300, function() {
                newRow.find('.new-size-input').focus();
            });
        }

        function calculateTotalStock() {
            if (!$('#hasSizes').is(':checked')) {
                $('#stockSummary').hide();
                return;
            }

            let totalStock = 0;

            // Calculate from existing sizes
            $('.size-checkbox:checked').each(function() {
                const stock = parseInt($(this).closest('.size-item').find('.size-stock').val()) || 0;
                totalStock += stock;
            });

            // Calculate from new sizes
            $('.new-size-row').each(function() {
                const sizeName = $(this).find('input[name="new_sizes[]"]').val().trim();
                const stock = parseInt($(this).find('input[name="new_stocks[]"]').val()) || 0;
                if (sizeName) {
                    totalStock += stock;
                }
            });

            $('#totalStockValue').text(totalStock);

            if (totalStock > 0) {
                $('#stockSummary').slideDown(300);
            } else {
                $('#stockSummary').slideUp(300);
            }

            // Update stock status automatically
            const stockStatusSelect = $('select[name="stock_status"]');
            if (totalStock > 0) {
                stockStatusSelect.val('instock');
            } else {
                stockStatusSelect.val('outofstock');
            }
        }

        function calculateDiscount() {
            const regularPrice = parseRupiah($('input[name="regular_price"]').val());
            const salePrice = parseRupiah($('input[name="sale_price"]').val());

            if (regularPrice > 0) {
                $('#normalPriceDisplay').text(formatRupiah(regularPrice));

                if (salePrice > 0 && salePrice < regularPrice) {
                    const savings = regularPrice - salePrice;
                    const percentage = Math.round((savings / regularPrice) * 100);

                    $('#discountPriceDisplay').text(formatRupiah(salePrice));
                    $('#savingsDisplay').text(formatRupiah(savings) + ' (' + percentage + '%)');
                    $('#pricePreview').slideDown(300);
                } else {
                    $('#pricePreview').slideUp(300);
                }
            } else {
                $('#pricePreview').hide();
            }
        }

        // Preview functionality
        function generatePreview() {
            const formData = collectFormData();
            const previewHtml = generatePreviewHTML(formData);

            $('#previewContent').html(previewHtml);
            $('#previewModal').modal('show');
        }

        function collectFormData() {
            return {
                name: $('input[name="name"]').val() || 'Belum diisi',
                slug: $('input[name="slug"]').val() || 'Belum diisi',
                category: $('select[name="category_id"] option:selected').text() || 'Belum dipilih',
                brand: $('select[name="brand_id"] option:selected').text() || 'Belum dipilih',
                regular_price: $('input[name="regular_price"]').val() || 'Rp 0',
                sale_price: $('input[name="sale_price"]').val() || 'Tidak ada diskon',
                short_description: $('textarea[name="short_description"]').val() || 'Belum diisi',
                description: $('textarea[name="description"]').val() || 'Belum diisi',
                sku: $('input[name="SKU"]').val() || 'Belum diisi',
                quantity: $('input[name="quantity"]').val() || '0',
                stock_status: $('select[name="stock_status"] option:selected').text(),
                featured: $('select[name="featured"] option:selected').text(),
                has_sizes: $('#hasSizes').is(':checked'),
                total_stock: $('#totalStockValue').text() || '0'
            };
        }

        function generatePreviewHTML(data) {
            const hasDiscount = data.sale_price !== 'Tidak ada diskon' &&
                parseRupiah(data.sale_price) < parseRupiah(data.regular_price);

            return `
                <div class="product-preview">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="mb-3">${data.name}</h4>
                            <div class="preview-section">
                                <h6><i class="icon-info"></i> Informasi Dasar</h6>
                                <div class="row">
                                    <div class="col-6">
                                        <p><strong>Kategori:</strong> ${data.category}</p>
                                        <p><strong>Merek:</strong> ${data.brand}</p>
                                        <p><strong>SKU:</strong> ${data.sku}</p>
                                    </div>
                                    <div class="col-6">
                                        <p><strong>Status:</strong> <span class="badge ${data.stock_status === 'Tersedia' ? 'badge-success' : 'badge-danger'}">${data.stock_status}</span></p>
                                        <p><strong>Unggulan:</strong> <span class="badge ${data.featured === 'Ya' ? 'badge-primary' : 'badge-secondary'}">${data.featured}</span></p>
                                        <p><strong>Slug:</strong> <code>${data.slug}</code></p>
                                    </div>
                                </div>
                            </div>

                            <div class="preview-section">
                                <h6><i class="icon-credit-card"></i> Harga & Stok</h6>
                                <div class="price-preview-modal">
                                    <div class="price-item">
                                        <span>Harga Normal:</span>
                                        <strong>${data.regular_price}</strong>
                                    </div>
                                    ${hasDiscount ? `
                                        <div class="price-item">
                                            <span>Harga Diskon:</span>
                                            <strong class="text-success">${data.sale_price}</strong>
                                        </div>
                                        <div class="price-item">
                                            <span>Hemat:</span>
                                            <strong class="text-danger">${calculateSavingsForPreview(data.regular_price, data.sale_price)}</strong>
                                        </div>
                                    ` : ''}
                                    <div class="price-item">
                                        <span>Stok:</span>
                                        <strong>${data.has_sizes ? data.total_stock + ' unit (dari berbagai ukuran)' : data.quantity + ' unit'}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="preview-section">
                                <h6><i class="icon-file-text"></i> Deskripsi</h6>
                                <p><strong>Singkat:</strong> ${data.short_description}</p>
                                <p><strong>Lengkap:</strong> ${data.description.substring(0, 200)}${data.description.length > 200 ? '...' : ''}</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="preview-images">
                                <h6><i class="icon-picture"></i> Gambar Produk</h6>
                                <div id="preview-main-image" class="mb-3">
                                    ${$('#mainImagePreview .preview-item').length ?
                                      $('#mainImagePreview').html() :
                                      '<div class="text-muted">Belum ada gambar utama</div>'}
                                </div>
                                <div id="preview-gallery">
                                    ${$('#galleryPreview .preview-item').length ?
                                      '<small class="text-muted">Galeri: ' + $('#galleryPreview .preview-item').length + ' gambar</small>' :
                                      '<small class="text-muted">Belum ada gambar galeri</small>'}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        function calculateSavingsForPreview(regularPrice, salePrice) {
            const regular = parseRupiah(regularPrice);
            const sale = parseRupiah(salePrice);
            const savings = regular - sale;
            const percentage = Math.round((savings / regular) * 100);
            return formatRupiah(savings) + ' (' + percentage + '%)';
        }

        function initializeForm() {
            // Set up auto-calculations
            calculateDiscount();
            if ($('#hasSizes').is(':checked')) {
                calculateTotalStock();
            }
        }

        // Success/Error message handling
        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endpush
