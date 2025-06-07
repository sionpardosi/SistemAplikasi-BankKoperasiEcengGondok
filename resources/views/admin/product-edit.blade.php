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
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #495057;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-subtitle {
            font-size: 14px;
            color: #6c757d;
            margin: 5px 0 0 0;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 20px;
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
            padding: 12px 15px;
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

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        /* Price Section */
        .price-section {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .price-calculator {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 6px;
            padding: 15px;
            margin-top: 15px;
            text-align: center;
        }

        .discount-display {
            font-size: 18px;
            font-weight: 700;
            color: #1976d2;
        }

        .savings-display {
            font-size: 14px;
            color: #388e3c;
            margin-top: 5px;
        }

        /* Size Management */
        .size-management {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
        }

        .size-toggle {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .size-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .size-item {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 15px;
            transition: all 0.3s ease;
        }

        .size-item:hover {
            border-color: #007bff;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.15);
        }

        .size-item.active {
            border-color: #28a745;
            background: #f8fff9;
        }

        .size-checkbox {
            margin-right: 8px;
            transform: scale(1.2);
        }

        .size-name {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .stock-input {
            margin-top: 10px;
        }

        .new-size-section {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 20px;
            margin-top: 20px;
        }

        .new-size-row {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 10px;
        }

        /* Image Upload */
        .upload-section {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
        }

        .upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 40px 20px;
            text-align: center;
            transition: all 0.3s ease;
            background: white;
        }

        .upload-area:hover {
            border-color: #007bff;
            background: #f8f9ff;
        }

        .upload-icon {
            font-size: 48px;
            color: #6c757d;
            margin-bottom: 15px;
        }

        .current-image {
            margin-bottom: 20px;
            text-align: center;
        }

        .current-image img {
            max-width: 200px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .gallery-preview {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 10px;
            margin-top: 15px;
        }

        .gallery-item {
            position: relative;
            border-radius: 6px;
            overflow: hidden;
        }

        .gallery-item img {
            width: 100%;
            height: 120px;
            object-fit: cover;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4);
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            border: 1px solid #6c757d;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #545b62;
            border-color: #545b62;
            color: white;
        }

        .btn-success {
            background: #28a745;
            border: 1px solid #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: #218838;
            border-color: #218838;
            color: white;
        }

        .btn-danger {
            background: #dc3545;
            border: 1px solid #dc3545;
            color: white;
            padding: 8px 15px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background: #c82333;
            border-color: #c82333;
            color: white;
        }

        /* Action Buttons */
        .action-buttons {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            text-align: center;
        }

        /* Alerts */
        .alert {
            border: none;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-info {
            background: #e3f2fd;
            color: #1976d2;
            border-left: 4px solid #2196f3;
        }

        .alert-success {
            background: #e8f5e8;
            color: #2e7d32;
            border-left: 4px solid #4caf50;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border-left: 4px solid #ffc107;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-content-inner {
                padding: 1rem;
            }

            .form-section {
                padding: 20px;
            }

            .size-grid {
                grid-template-columns: 1fr;
            }

            .gallery-preview {
                grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            }
        }

        /* Validation Errors */
        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
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
            border: 3px solid rgba(255, 255, 255, .3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Custom Checkbox */
        .custom-checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .custom-checkbox:hover {
            background: #e3f2fd;
            border-color: #2196f3;
        }

        .custom-checkbox input[type="checkbox"] {
            transform: scale(1.3);
            margin: 0;
        }

        .custom-checkbox label {
            margin: 0;
            font-weight: 600;
            color: #495057;
            cursor: pointer;
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Page Header -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Produk</h3>
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
                        <div class="text-tiny">Edit produk</div>
                    </li>
                </ul>
            </div>

            <!-- Main Form -->
            <form class="tf-section-2 form-edit-product" method="POST" enctype="multipart/form-data"
                action="{{ route('admin.product.update') }}" id="productForm">
                <input type="hidden" name="id" value="{{ $product->id }}" />
                @csrf
                @method('PUT')

                <!-- Basic Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="icon-info"></i> Informasi Dasar Produk
                        </h5>
                        <p class="section-subtitle">Masukkan informasi dasar tentang produk Anda</p>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Nama Produk <span class="required">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name', $product->name) }}"
                                    placeholder="Masukkan nama produk" maxlength="100" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Maksimal 100 karakter</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Slug <span class="required">*</span></label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                    name="slug" value="{{ old('slug', $product->slug) }}"
                                    placeholder="Auto-generate dari nama produk" maxlength="100" required>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">URL-friendly version dari nama produk</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Kategori <span class="required">*</span></label>
                                <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Merek <span class="required">*</span></label>
                                <select class="form-select @error('brand_id') is-invalid @enderror" name="brand_id" required>
                                    <option value="">Pilih Merek</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi Singkat <span class="required">*</span></label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror"
                            name="short_description" rows="3" placeholder="Deskripsi singkat produk"
                            maxlength="200" required>{{ old('short_description', $product->short_description) }}</textarea>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Maksimal 200 karakter untuk ditampilkan di preview</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi Lengkap <span class="required">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                            name="description" rows="5" placeholder="Deskripsi lengkap produk" required>{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Jelaskan detail produk, fitur, keunggulan, dll.</div>
                    </div>
                </div>

                <!-- Pricing Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="icon-credit-card"></i> Informasi Harga
                        </h5>
                        <p class="section-subtitle">Tentukan harga dan kalkulasi diskon produk</p>
                    </div>

                    <div class="price-section">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label">Harga Normal <span class="required">*</span></label>
                                    <input type="text" class="form-control @error('regular_price') is-invalid @enderror"
                                        name="regular_price" value="{{ old('regular_price', formatRupiah($product->regular_price)) }}"
                                        placeholder="Rp 0" required id="regularPrice">
                                    @error('regular_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label">Harga Diskon</label>
                                    <input type="text" class="form-control @error('sale_price') is-invalid @enderror"
                                        name="sale_price" value="{{ old('sale_price', formatRupiah($product->sale_price)) }}"
                                        placeholder="Rp 0 (Kosongkan jika tidak ada diskon)" id="salePrice">
                                    @error('sale_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Kosongkan jika tidak ada diskon</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-label">SKU <span class="required">*</span></label>
                                    <input type="text" class="form-control @error('SKU') is-invalid @enderror"
                                        name="SKU" value="{{ old('SKU', $product->SKU) }}"
                                        placeholder="Kode unik produk" required>
                                    @error('SKU')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Price Calculator -->
                        <div class="price-calculator" id="priceCalculator" style="display: none;">
                            <div class="discount-display">
                                Diskon: <span id="discountPercentage">0</span>%
                            </div>
                            <div class="savings-display">
                                Hemat: <span id="savingsAmount">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stock & Size Management Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="icon-package"></i> Manajemen Stok & Ukuran
                        </h5>
                        <p class="section-subtitle">Kelola stok dan ukuran produk Anda</p>
                    </div>

                    <div class="size-management">
                        <!-- Size Toggle -->
                        <div class="size-toggle">
                            <div class="custom-checkbox">
                                <input type="checkbox" name="has_sizes" id="has_sizes"
                                    {{ $product->sizes && $product->sizes->count() > 0 ? 'checked' : '' }}>
                                <label for="has_sizes">
                                    <i class="icon-layers"></i> Produk ini memiliki variasi ukuran
                                </label>
                            </div>
                            <div class="form-text mt-2">
                                Aktifkan jika produk memiliki beberapa ukuran (S, M, L, XL, atau ukuran angka)
                            </div>
                        </div>

                        <!-- Size Container -->
                        <div id="sizes-container" style="{{ $product->sizes && $product->sizes->count() > 0 ? '' : 'display: none;' }}">
                            <div class="alert alert-info">
                                <strong><i class="icon-info"></i> Info:</strong>
                                Pilih ukuran yang tersedia dan tentukan stok untuk masing-masing ukuran.
                            </div>

                            <!-- Existing Sizes -->
                            @if($sizes->count() > 0)
                                <h6><i class="icon-grid"></i> Ukuran yang Tersedia</h6>
                                <div class="size-grid">
                                    @php
                                        $productSizes = $product->sizes ? $product->sizes->pluck('pivot.stock', 'id')->toArray() : [];
                                    @endphp

                                    @foreach ($sizes as $size)
                                        <div class="size-item {{ isset($productSizes[$size->id]) ? 'active' : '' }}">
                                            <div class="size-name">
                                                <input type="checkbox" name="sizes[]" id="size_{{ $size->id }}"
                                                    value="{{ $size->id }}" class="size-checkbox"
                                                    {{ isset($productSizes[$size->id]) ? 'checked' : '' }}>
                                                <label for="size_{{ $size->id }}">{{ $size->name }}</label>
                                            </div>
                                            <div class="stock-input" style="{{ isset($productSizes[$size->id]) ? '' : 'display: none;' }}">
                                                <input type="number" name="stocks[{{ $size->id }}]"
                                                    min="0" placeholder="Stok" class="form-control"
                                                    value="{{ $productSizes[$size->id] ?? 0 }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- New Sizes Section -->
                            <div class="new-size-section">
                                <h6><i class="icon-plus"></i> Tambah Ukuran Baru</h6>
                                <div id="new-sizes-container">
                                    <div class="new-size-row">
                                        <div class="row align-items-center">
                                            <div class="col-lg-4">
                                                <input type="text" name="new_sizes[]" placeholder="Ukuran baru (contoh: XXL)"
                                                    class="form-control">
                                            </div>
                                            <div class="col-lg-3">
                                                <input type="number" name="new_stocks[]" min="0" placeholder="Stok"
                                                    class="form-control" value="0">
                                            </div>
                                            <div class="col-lg-3">
                                                <button type="button" class="btn btn-danger remove-new-size" style="display:none;">
                                                    <i class="icon-trash"></i> Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="add-new-size" class="btn btn-success mt-3">
                                    <i class="icon-plus"></i> Tambah Ukuran Baru
                                </button>
                            </div>

                            <!-- Total Stock Display -->
                            <div id="total-stock-display" class="alert alert-info mt-3" style="display: none;">
                                <strong>Total Stok: <span id="total-stock-value">0</span></strong>
                            </div>
                        </div>

                        <!-- Regular Quantity Field -->
                        <div class="form-group" id="quantity-field"
                            style="{{ $product->sizes && $product->sizes->count() > 0 ? 'display: none;' : '' }}">
                            <label class="form-label">Kuantitas Stok <span class="required">*</span></label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                name="quantity" value="{{ old('quantity', $product->quantity) }}"
                                min="0" placeholder="Masukkan jumlah stok">
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Jumlah stok produk yang tersedia</div>
                        </div>

                        <!-- Stock Status & Featured -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Status Stok</label>
                                    <select class="form-select" name="stock_status">
                                        <option value="instock" {{ old('stock_status', $product->stock_status) == 'instock' ? 'selected' : '' }}>
                                            <i class="icon-check"></i> Tersedia
                                        </option>
                                        <option value="outofstock" {{ old('stock_status', $product->stock_status) == 'outofstock' ? 'selected' : '' }}>
                                            <i class="icon-close"></i> Habis
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Produk Unggulan</label>
                                    <select class="form-select" name="featured">
                                        <option value="0" {{ old('featured', $product->featured) == '0' ? 'selected' : '' }}>
                                            Tidak
                                        </option>
                                        <option value="1" {{ old('featured', $product->featured) == '1' ? 'selected' : '' }}>
                                            Ya, tampilkan sebagai unggulan
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Upload Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="icon-picture"></i> Gambar Produk
                        </h5>
                        <p class="section-subtitle">Upload gambar utama dan galeri produk</p>
                    </div>

                    <div class="upload-section">
                        <!-- Main Image -->
                        <div class="form-group">
                            <label class="form-label">Gambar Utama</label>
                            @if ($product->image)
                                <div class="current-image" id="imgpreview">
                                    <img src="{{ asset('uploads/products') }}/{{ $product->image }}"
                                        alt="{{ $product->name }}" class="img-fluid">
                                    <div class="form-text mt-2">Gambar saat ini</div>
                                </div>
                            @endif

                            <div class="upload-area" id="upload-file">
                                <label for="myFile" class="uploadfile w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                                    <div class="upload-icon">
                                        <i class="icon-upload-cloud"></i>
                                    </div>
                                    <div class="upload-text">
                                        <strong>Klik untuk memilih gambar</strong> atau drag & drop di sini
                                    </div>
                                    <div class="form-text">Format: JPG, PNG, JPEG | Maksimal: 2MB</div>
                                    <input type="file" id="myFile" name="image" accept="image/*" class="d-none">
                                </label>
                            </div>
                        </div>

                        <!-- Gallery Images -->
                        <div class="form-group">
                            <label class="form-label">Galeri Gambar</label>

                            @if ($product->images)
                                <div class="gallery-preview">
                                    @foreach (explode(',', $product->images) as $img)
                                        <div class="gallery-item gitems">
                                            <img src="{{ asset('uploads/products') }}/{{ trim($img) }}"
                                                alt="{{ $product->name }}">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="form-text mb-3">Gambar galeri saat ini</div>
                            @endif

                            <div class="upload-area" id="galUpload">
                                <label for="gFile" class="uploadfile w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                                    <div class="upload-icon">
                                        <i class="icon-upload-cloud"></i>
                                    </div>
                                    <div class="upload-text">
                                        <strong>Upload gambar galeri</strong> (multiple)
                                    </div>
                                    <div class="form-text">Pilih beberapa gambar untuk galeri produk</div>
                                    <input type="file" id="gFile" name="images[]" accept="image/*" multiple class="d-none">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('admin.products') }}" class="btn btn-secondary">
                            <i class="icon-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="icon-check"></i> Perbarui Produk
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function() {
    // ===========================================
    // Image Preview Functions
    // ===========================================
    $("#myFile").on("change", function(e) {
        const [file] = this.files;
        if (file) {
            // Validasi ukuran file (2MB)
            if (file.size > 2048000) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Ukuran file terlalu besar. Maksimal 2MB.',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
                $(this).val('');
                return;
            }

            $("#imgpreview img").attr('src', URL.createObjectURL(file));
            $("#imgpreview").show();
        }
    });

    $("#gFile").on("change", function(e) {
        $(".gitems").remove();
        const gphotos = this.files;
        $.each(gphotos, function(key, val) {
            // Validasi ukuran file
            if (val.size > 2048000) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Salah satu file terlalu besar. Maksimal 2MB per file.',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
                return false;
            }

            $("#galUpload").before(
                `<div class="gallery-item gitems"><img src="${URL.createObjectURL(val)}" alt="Preview"></div>`
            );
        });
    });

    // ===========================================
    // Auto-generate Slug
    // ===========================================
    $("input[name='name']").on("input", function() {
        const slug = StringToSlug($(this).val());
        $("input[name='slug']").val(slug);

        // Check slug uniqueness (optional - requires AJAX)
        if (slug.length > 0) {
            checkSlugUniqueness(slug);
        }
    });

    // ===========================================
    // Price Calculator
    // ===========================================
    function calculateDiscount() {
        const regularPrice = parseFloat($("#regularPrice").val().replace(/[^0-9]/g, '')) || 0;
        const salePrice = parseFloat($("#salePrice").val().replace(/[^0-9]/g, '')) || 0;

        if (regularPrice > 0 && salePrice > 0 && salePrice < regularPrice) {
            const discountPercent = Math.round(((regularPrice - salePrice) / regularPrice) * 100);
            const savings = regularPrice - salePrice;

            $("#discountPercentage").text(discountPercent);
            $("#savingsAmount").text(formatRupiah(savings));
            $("#priceCalculator").fadeIn();
        } else {
            $("#priceCalculator").fadeOut();
        }
    }

    $("#regularPrice, #salePrice").on("input blur", function() {
        // Format to Rupiah on blur
        if ($(this).is(":focus") === false) {
            let value = $(this).val();
            let numeric = value.replace(/[^0-9]/g, '');
            $(this).val(formatRupiah(numeric, 'Rp '));
        }
        calculateDiscount();
    });

    // ===========================================
    // Size Management
    // ===========================================
    $("#has_sizes").on("change", function() {
        if ($(this).is(":checked")) {
            $("#sizes-container").slideDown();
            toggleQuantityField();
        } else {
            $("#sizes-container").slideUp();
            $("#quantity-field").show();
            $("#total-stock-display").hide();
        }
    });

    $(".size-checkbox").on("change", function() {
        const $sizeItem = $(this).closest('.size-item');
        const $stockInput = $sizeItem.find('.stock-input');

        if ($(this).is(":checked")) {
            $stockInput.slideDown();
            $sizeItem.addClass('active');
        } else {
            $stockInput.slideUp();
            $sizeItem.removeClass('active');
        }

        toggleQuantityField();
        calculateTotalStock();
    });

    // Add new size functionality
    $("#add-new-size").on("click", function() {
        const container = $("#new-sizes-container");
        const newRow = $(`
            <div class="new-size-row">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <input type="text" name="new_sizes[]" placeholder="Ukuran baru (contoh: XXL)"
                            class="form-control">
                    </div>
                    <div class="col-lg-3">
                        <input type="number" name="new_stocks[]" min="0" placeholder="Stok"
                            class="form-control" value="0">
                    </div>
                    <div class="col-lg-3">
                        <button type="button" class="btn btn-danger remove-new-size">
                            <i class="icon-trash"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
        `);

        container.append(newRow);

        // Add event listeners
        newRow.find("input[name='new_sizes[]']").on("input", toggleQuantityField);
        newRow.find("input[name='new_stocks[]']").on("input", calculateTotalStock);
        newRow.find(".remove-new-size").on("click", function() {
            $(this).closest('.new-size-row').remove();
            toggleQuantityField();
            calculateTotalStock();
        });

        toggleQuantityField();
    });

    // Event listeners for existing new size inputs
    $("input[name='new_sizes[]']").on("input", toggleQuantityField);
    $("input[name='new_stocks[]']").on("input", calculateTotalStock);

    $(document).on('input', 'input[name^="stocks"], input[name^="new_stocks"]', calculateTotalStock);

    function toggleQuantityField() {
        if ($("#has_sizes").is(":checked")) {
            const hasExistingSizes = $(".size-checkbox:checked").length > 0;
            const hasNewSizes = $("input[name='new_sizes[]']").filter(function() {
                return $(this).val() !== "";
            }).length > 0;

            if (hasExistingSizes || hasNewSizes) {
                $("#quantity-field").hide();
                calculateTotalStock();
            } else {
                $("#quantity-field").show();
                $("#total-stock-display").hide();
            }
        } else {
            $("#quantity-field").show();
            $("#total-stock-display").hide();
        }
    }

    function calculateTotalStock() {
        if ($("#has_sizes").is(":checked")) {
            let totalStock = 0;

            // Calculate from existing sizes
            $(".size-checkbox:checked").each(function() {
                const sizeId = $(this).val();
                const stock = parseInt($("input[name='stocks[" + sizeId + "]']").val()) || 0;
                totalStock += stock;
            });

            // Calculate from new sizes
            $("input[name='new_stocks[]']").each(function() {
                const stock = parseInt($(this).val()) || 0;
                const sizeName = $(this).closest('.new-size-row').find("input[name='new_sizes[]']").val();
                if (sizeName && sizeName.trim() !== '') {
                    totalStock += stock;
                }
            });

            $("#total-stock-value").text(totalStock);
            $("#total-stock-display").show();
        }
    }

    // ===========================================
    // Form Validation & Submission
    // ===========================================
    $("#productForm").on("submit", function(e) {
        let isValid = true;
        const errors = [];

        // Validate required fields
        $("[required]").each(function() {
            if (!$(this).val()) {
                isValid = false;
                $(this).addClass('is-invalid');
                errors.push($(this).attr('name') + ' wajib diisi');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        // Validate price logic
        const regularPrice = parseFloat($("#regularPrice").val().replace(/[^0-9]/g, '')) || 0;
        const salePrice = parseFloat($("#salePrice").val().replace(/[^0-9]/g, '')) || 0;

        if (salePrice > 0 && salePrice >= regularPrice) {
            isValid = false;
            $("#salePrice").addClass('is-invalid');
            errors.push('Harga diskon harus lebih kecil dari harga normal');
        }

        // Show errors if any
        if (!isValid) {
            e.preventDefault();
            Swal.fire({
                title: 'Error Validasi!',
                html: errors.join('<br>'),
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
            return false;
        }

        // Show loading state
        $("#submitBtn").prop('disabled', true).html('<span class="spinner"></span> Memproses...');
    });

    // ===========================================
    // Helper Functions
    // ===========================================
    function StringToSlug(text) {
        return text.toLowerCase()
            .replace(/[^\w\s-]/g, '') // Remove special characters
            .replace(/[\s_-]+/g, '-') // Replace spaces and underscores with hyphens
            .replace(/^-+|-+$/g, ''); // Remove leading/trailing hyphens
    }

    function formatRupiah(angka, prefix = '') {
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
        return prefix + rupiah;
    }

    function checkSlugUniqueness(slug) {
        // AJAX call to check slug uniqueness (optional)
        // Implementation depends on your backend API
    }

    // Initialize on page load
    toggleQuantityField();
    calculateDiscount();
    calculateTotalStock();

    // ===========================================
    // Success/Error Messages
    // ===========================================
    @if (session('status'))
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('status') }}',
            icon: 'success',
            confirmButtonColor: '#28a745'
        });
    @endif

    @if (session('error'))
        Swal.fire({
            title: 'Error!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonColor: '#dc3545'
        });
    @endif
});
</script>
@endpush
