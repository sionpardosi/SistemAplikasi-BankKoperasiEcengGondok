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
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
        }

        .form-header {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-header h4 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            color: white;
        }

        .form-header p {
            margin: 8px 0 0;
            opacity: 0.9;
            font-size: 14px;
            color: white;
        }

        /* Category Info Card */
        .category-info-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .category-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .stat-item {
            background: white;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
            border: 1px solid #e9ecef;
        }

        .stat-number {
            font-size: 24px;
            font-weight: 700;
            color: #007bff;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 12px;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-size: 15px;
            font-weight: 700;
            color: #495057;
            margin-bottom: 8px;
            display: block;
        }

        .required-marker {
            color: #dc3545;
            font-weight: 700;
            margin-left: 3px;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #ffffff;
            width: 100%;
        }

        .form-control:focus {
            border-color: #17a2b8;
            box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.25);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .form-control.is-valid {
            border-color: #28a745;
        }

        /* Help Text */
        .form-help {
            font-size: 13px;
            color: #6c757d;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Error Messages */
        .error-message {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 10px 15px;
            border-radius: 6px;
            font-size: 14px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* File Upload Styling */
        .upload-container {
            border: 2px dashed #e9ecef;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            background: #f8f9fa;
            position: relative;
            cursor: pointer;
        }

        .upload-container:hover {
            border-color: #17a2b8;
            background: #e1f7fa;
        }

        .upload-container.dragover {
            border-color: #17a2b8;
            background: #e1f7fa;
            transform: scale(1.02);
        }

        .current-image {
            text-align: center;
            margin-bottom: 20px;
        }

        .current-image img {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            object-fit: cover;
        }

        .current-image-label {
            font-size: 14px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 10px;
        }

        .change-image-btn {
            background: #17a2b8;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 13px;
            margin-top: 10px;
            cursor: pointer;
        }

        .upload-icon {
            font-size: 48px;
            color: #6c757d;
            margin-bottom: 15px;
        }

        .upload-text {
            font-size: 16px;
            color: #495057;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .upload-subtext {
            font-size: 14px;
            color: #6c757d;
        }

        #myFile {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        /* Image Preview */
        .preview-container {
            margin-top: 20px;
            display: none;
        }

        .preview-image {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            object-fit: cover;
        }

        .preview-info {
            margin-top: 10px;
            font-size: 13px;
            color: #6c757d;
        }

        .remove-image {
            background: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            margin-top: 8px;
            cursor: pointer;
        }

        /* Action Buttons */
        .action-buttons {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(23, 162, 184, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(23, 162, 184, 0.4);
        }

        .btn-secondary {
            background: #6c757d;
            border: 1px solid #6c757d;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: #545b62;
            border-color: #545b62;
            color: white;
            transform: translateY(-1px);
        }

        .btn-danger {
            background: #dc3545;
            border: 1px solid #dc3545;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background: #c82333;
            border-color: #c82333;
            color: white;
            transform: translateY(-1px);
        }

        /* Character Counter */
        .char-counter {
            font-size: 12px;
            color: #6c757d;
            text-align: right;
            margin-top: 5px;
        }

        .char-counter.warning {
            color: #f39c12;
        }

        .char-counter.danger {
            color: #e74c3c;
        }

        /* Slug Preview */
        .slug-preview {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            padding: 8px 12px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            color: #495057;
            margin-top: 8px;
        }

        /* Live Validation */
        .validation-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
        }

        .input-group {
            position: relative;
        }

        /* Products List */
        .products-preview {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .products-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .products-title {
            font-size: 16px;
            font-weight: 700;
            color: #1976d2;
            margin: 0;
        }

        .view-all-btn {
            background: #1976d2;
            color: white;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 12px;
            text-decoration: none;
            border: none;
        }

        .products-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
        }

        .product-item {
            background: white;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #e3f2fd;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .product-thumb {
            width: 40px;
            height: 40px;
            border-radius: 4px;
            object-fit: cover;
        }

        .product-info {
            flex: 1;
        }

        .product-name {
            font-size: 13px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 2px;
        }

        .product-price {
            font-size: 12px;
            color: #28a745;
            font-weight: 600;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content-inner {
                padding: 1rem;
            }

            .form-container {
                padding: 20px;
            }

            .action-buttons {
                flex-direction: column;
                text-align: center;
            }

            .action-buttons .btn {
                width: 100%;
            }

            .category-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Page Header -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Manajemen Edit Kategori Produk</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.categories') }}">
                            <div class="text-tiny">Kategori</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Edit: {{ $category->name }}</div>
                    </li>
                </ul>
            </div>

            <!-- Category Info Card -->
            <div class="category-info-card">
                <h5 style="margin: 0 0 15px; color: #495057;">
                    <i class="icon-info"></i> Informasi Kategori: {{ $category->name }}
                </h5>
                <div class="category-stats">
                    <div class="stat-item">
                        <div class="stat-number">{{ $category->products()->count() }}</div>
                        <div class="stat-label">Total Produk</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $category->products()->where('stock_status', 'instock')->count() }}</div>
                        <div class="stat-label">Produk Tersedia</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $category->created_at->format('d M Y') }}</div>
                        <div class="stat-label">Dibuat</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $category->updated_at->format('d M Y') }}</div>
                        <div class="stat-label">Terakhir Update</div>
                    </div>
                </div>
            </div>

            <!-- Products Preview -->
            @if($category->products()->count() > 0)
                <div class="products-preview">
                    <div class="products-header">
                        <h5 class="products-title">
                            <i class="icon-shopping-bag"></i> Produk dalam Kategori Ini ({{ $category->products()->count() }})
                        </h5>
                        <button type="button" class="view-all-btn" data-bs-toggle="modal" data-bs-target="#productsModal">
                            <i class="icon-eye"></i> Lihat Semua
                        </button>
                    </div>
                    <div class="products-list">
                        @foreach($category->products()->take(6)->get() as $product)
                            <div class="product-item">
                                @if($product->image)
                                    <img src="{{ asset('uploads/products/thumbnails/' . $product->image) }}"
                                        alt="{{ $product->name }}" class="product-thumb">
                                @else
                                    <div class="product-thumb" style="background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                                        <i class="icon-image" style="color: #6c757d;"></i>
                                    </div>
                                @endif
                                <div class="product-info">
                                    <div class="product-name">{{ Str::limit($product->name, 25) }}</div>
                                    <div class="product-price">
                                        Rp {{ number_format($product->sale_price ?: $product->regular_price, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Form Container -->
            <div class="form-container">
                <div class="form-header">
                    <h4><i class="icon-edit"></i> Edit Kategori Produk</h4>
                    <p>Perbarui informasi kategori produk di bawah ini</p>
                </div>

                <form class="form-edit-category" action="{{ route('admin.category.update') }}" method="POST"
                    enctype="multipart/form-data" id="categoryForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $category->id }}">

                    <!-- Category Name -->
                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="icon-tag"></i> Nama Kategori
                            <span class="required-marker">*</span>
                        </label>
                        <div class="input-group">
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Masukkan nama kategori produk" value="{{ old('name', $category->name) }}" required
                                maxlength="100" autocomplete="off">
                            <div class="validation-icon" id="nameValidation"></div>
                        </div>
                        <div class="form-help">
                            <i class="icon-info"></i>
                            <span>Nama kategori harus unik dan deskriptif (maksimal 100 karakter)</span>
                        </div>
                        <div class="char-counter" id="nameCounter">0/100 karakter</div>
                        @error('name')
                            <div class="error-message">
                                <i class="icon-alert-triangle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Category Slug -->
                    <div class="form-group">
                        <label for="slug" class="form-label">
                            <i class="icon-link"></i> Slug Kategori
                            <span class="required-marker">*</span>
                        </label>
                        <div class="input-group">
                            <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror"
                                placeholder="kategori-slug" value="{{ old('slug', $category->slug) }}" required
                                pattern="^[a-z0-9-]+$" maxlength="100">
                            <div class="validation-icon" id="slugValidation"></div>
                        </div>
                        <div class="form-help">
                            <i class="icon-info"></i>
                            <span>Slug digunakan untuk URL kategori. Hanya boleh huruf kecil, angka, dan tanda (-)</span>
                        </div>
                        <div class="slug-preview" id="slugPreview">
                            URL Preview: <span id="slugUrl">{{ url('/kategori/') }}/{{ $category->slug }}</span>
                        </div>
                        @error('slug')
                            <div class="error-message">
                                <i class="icon-alert-triangle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Category Description (New Feature) -->
                    <div class="form-group">
                        <label for="description" class="form-label">
                            <i class="icon-file-text"></i> Deskripsi Kategori
                            <span style="color: #6c757d; font-weight: normal;">(Opsional)</span>
                        </label>
                        <textarea id="description" name="description" class="form-control" rows="4"
                            placeholder="Deskripsi singkat tentang kategori ini..." maxlength="500">{{ old('description', $category->description ?? '') }}</textarea>
                        <div class="form-help">
                            <i class="icon-info"></i>
                            <span>Deskripsi akan ditampilkan di halaman kategori untuk membantu customer</span>
                        </div>
                        <div class="char-counter" id="descCounter">0/500 karakter</div>
                    </div>

                    <!-- SEO Meta (New Feature) -->
                    <div class="form-group">
                        <label for="meta_title" class="form-label">
                            <i class="icon-search"></i> Meta Title SEO
                            <span style="color: #6c757d; font-weight: normal;">(Opsional)</span>
                        </label>
                        <input type="text" id="meta_title" name="meta_title" class="form-control"
                            placeholder="Title untuk SEO (akan menggunakan nama kategori jika kosong)"
                            value="{{ old('meta_title', $category->meta_title ?? '') }}" maxlength="60">
                        <div class="form-help">
                            <i class="icon-info"></i>
                            <span>Meta title untuk SEO dan hasil pencarian Google (maksimal 60 karakter)</span>
                        </div>
                        <div class="char-counter" id="metaTitleCounter">0/60 karakter</div>
                    </div>

                    <!-- Category Image -->
                    <div class="form-group">
                        <label for="myFile" class="form-label">
                            <i class="icon-image"></i> Gambar Kategori
                        </label>

                        @if($category->image)
                            <div class="current-image" id="currentImageContainer">
                                <div class="current-image-label">Gambar Saat Ini:</div>
                                <img src="{{ asset('uploads/categories/' . $category->image) }}" alt="{{ $category->name }}">
                                <br>
                                <button type="button" class="change-image-btn" onclick="showUploadContainer()">
                                    <i class="icon-refresh"></i> Ganti Gambar
                                </button>
                            </div>
                        @endif

                        <div class="upload-container" id="uploadContainer" style="{{ $category->image ? 'display: none;' : '' }}">
                            <input type="file" id="myFile" name="image" accept="image/*">
                            <div class="upload-content">
                                <div class="upload-icon">
                                    <i class="icon-upload-cloud"></i>
                                </div>
                                <div class="upload-text">{{ $category->image ? 'Pilih gambar baru' : 'Drag & Drop gambar di sini' }}</div>
                                <div class="upload-subtext">atau klik untuk memilih file</div>
                                <div style="margin-top: 10px; font-size: 12px; color: #6c757d;">
                                    Format: JPG, PNG, WEBP • Maksimal: 2MB • Minimal: 300x300px
                                </div>
                            </div>
                        </div>

                        <div class="preview-container" id="previewContainer">
                            <div style="text-align: center;">
                                <img id="previewImage" class="preview-image" alt="Preview">
                                <div class="preview-info" id="previewInfo"></div>
                                <button type="button" class="remove-image" id="removeImage">
                                    <i class="icon-trash"></i> Hapus Gambar Baru
                                </button>
                            </div>
                        </div>

                        @error('image')
                            <div class="error-message">
                                <i class="icon-alert-triangle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Sort Order (New Feature) -->
                    <div class="form-group">
                        <label for="sort_order" class="form-label">
                            <i class="icon-list"></i> Urutan Tampil
                            <span style="color: #6c757d; font-weight: normal;">(Opsional)</span>
                        </label>
                        <input type="number" id="sort_order" name="sort_order" class="form-control"
                            placeholder="0" value="{{ old('sort_order', $category->sort_order ?? 0) }}" min="0" max="999">
                        <div class="form-help">
                            <i class="icon-info"></i>
                            <span>Angka kecil akan ditampilkan lebih dulu. Kosongkan untuk urutan default</span>
                        </div>
                    </div>

                    <!-- Featured Category (New Feature) -->
                    <div class="form-group">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <input type="checkbox" id="is_featured" name="is_featured" value="1"
                                {{ old('is_featured', $category->is_featured ?? false) ? 'checked' : '' }}>
                            <label for="is_featured" class="form-label" style="margin: 0;">
                                <i class="icon-star"></i> Jadikan Kategori Unggulan
                            </label>
                        </div>
                        <div class="form-help" style="margin-left: 30px;">
                            <i class="icon-info"></i>
                            <span>Kategori unggulan akan ditampilkan di homepage dan mendapat prioritas lebih tinggi</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <div>
                            <a href="{{ route('admin.categories') }}" class="btn-secondary">
                                <i class="icon-arrow-left"></i> Kembali ke Daftar
                            </a>
                        </div>
                        <div style="display: flex; gap: 15px;">
                            @if($category->products()->count() == 0)
                                <button type="button" class="btn-danger" id="deleteBtn">
                                    <i class="icon-trash"></i> Hapus Kategori
                                </button>
                            @endif
                            <button type="submit" class="btn-primary" id="submitBtn">
                                <i class="icon-check"></i> Update Kategori
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Products Modal -->
    @if($category->products()->count() > 0)
        <div class="modal fade" id="productsModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="icon-shopping-bag"></i> Semua Produk dalam Kategori: {{ $category->name }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th width="40%">Produk</th>
                                        <th width="20%">Harga</th>
                                        <th width="15%">Stok</th>
                                        <th width="15%">Status</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category->products as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($product->image)
                                                        <img src="{{ asset('uploads/products/thumbnails/' . $product->image) }}"
                                                            alt="{{ $product->name }}" class="me-2"
                                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                                    @endif
                                                    <div>
                                                        <div class="fw-bold">{{ $product->name }}</div>
                                                        <small class="text-muted">SKU: {{ $product->SKU }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($product->sale_price && $product->sale_price < $product->regular_price)
                                                    <div class="fw-bold text-success">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</div>
                                                    <small class="text-muted text-decoration-line-through">Rp {{ number_format($product->regular_price, 0, ',', '.') }}</small>
                                                @else
                                                    <div class="fw-bold">Rp {{ number_format($product->regular_price, 0, ',', '.') }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fw-bold {{ $product->quantity > 10 ? 'text-success' : ($product->quantity > 0 ? 'text-warning' : 'text-danger') }}">
                                                    {{ $product->quantity }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge {{ $product->stock_status == 'instock' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $product->stock_status == 'instock' ? 'Tersedia' : 'Habis' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary" title="Edit Produk">
                                                    <i class="icon-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@push('scripts')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            const descInput = document.getElementById('description');
            const metaTitleInput = document.getElementById('meta_title');
            const fileInput = document.getElementById('myFile');
            const uploadContainer = document.getElementById('uploadContainer');
            const previewContainer = document.getElementById('previewContainer');
            const previewImage = document.getElementById('previewImage');
            const removeImageBtn = document.getElementById('removeImage');
            const form = document.getElementById('categoryForm');
            const submitBtn = document.getElementById('submitBtn');
            const deleteBtn = document.getElementById('deleteBtn');

            // Character counters
            const nameCounter = document.getElementById('nameCounter');
            const descCounter = document.getElementById('descCounter');
            const metaTitleCounter = document.getElementById('metaTitleCounter');

            // Auto-generate slug from name
            nameInput.addEventListener('input', function() {
                updateSlugPreview(slugInput.value);
                updateCharCounter(nameCounter, this.value.length, 100);
                validateField(this);
            });

            // Slug input validation
            slugInput.addEventListener('input', function() {
                const slug = this.value.toLowerCase().replace(/[^a-z0-9-]/g, '');
                this.value = slug;
                updateSlugPreview(slug);
                validateField(this);
            });

            // Description counter
            if (descInput) {
                descInput.addEventListener('input', function() {
                    updateCharCounter(descCounter, this.value.length, 500);
                });
            }

            // Meta title counter
            if (metaTitleInput) {
                metaTitleInput.addEventListener('input', function() {
                    updateCharCounter(metaTitleCounter, this.value.length, 60);
                });
            }

            // File upload handling
            fileInput.addEventListener('change', handleFileSelect);

            // Drag and drop
            uploadContainer.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });

            uploadContainer.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
            });

            uploadContainer.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    handleFileSelect();
                }
            });

            // Remove image
            removeImageBtn.addEventListener('click', function() {
                fileInput.value = '';
                previewContainer.style.display = 'none';
            });

            // Delete category
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Hapus Kategori?',
                        text: 'Kategori "{{ $category->name }}" akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#dc3545'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Create delete form and submit
                            const deleteForm = document.createElement('form');
                            deleteForm.method = 'POST';
                            deleteForm.action = '{{ route("admin.category.delete", ["id" => $category->id]) }}';

                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = '{{ csrf_token() }}';

                            const methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'DELETE';

                            deleteForm.appendChild(csrfToken);
                            deleteForm.appendChild(methodInput);
                            document.body.appendChild(deleteForm);
                            deleteForm.submit();
                        }
                    });
                });
            }

            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                if (!validateForm()) {
                    return;
                }

                submitBtn.classList.add('btn-loading');
                submitBtn.innerHTML = '<i class="icon-loading"></i> Menyimpan...';

                Swal.fire({
                    title: 'Menyimpan Perubahan...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit form
                setTimeout(() => {
                    this.submit();
                }, 1000);
            });

            // Functions
            function updateSlugPreview(slug) {
                const slugUrl = document.getElementById('slugUrl');
                slugUrl.textContent = `{{ url('/kategori/') }}/${slug || 'your-slug'}`;
            }

            function updateCharCounter(counter, current, max) {
                counter.textContent = `${current}/${max} karakter`;
                counter.classList.remove('warning', 'danger');

                if (current > max * 0.8) {
                    counter.classList.add('warning');
                }
                if (current > max * 0.95) {
                    counter.classList.add('danger');
                }
            }

            function handleFileSelect() {
                const file = fileInput.files[0];
                if (file) {
                    if (file.size > 2 * 1024 * 1024) {
                        Swal.fire({
                            title: 'File Terlalu Besar',
                            text: 'Ukuran file maksimal 2MB',
                            icon: 'error'
                        });
                        fileInput.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewContainer.style.display = 'block';

                        const fileSize = (file.size / 1024 / 1024).toFixed(2);
                        document.getElementById('previewInfo').innerHTML =
                            `<strong>${file.name}</strong><br>Ukuran: ${fileSize} MB<br><small class="text-warning">Gambar baru akan menggantikan gambar lama</small>`;
                    };
                    reader.readAsDataURL(file);
                }
            }

            function validateField(field) {
                const icon = document.getElementById(field.id + 'Validation');
                if (field.value.trim() !== '' && field.checkValidity()) {
                    field.classList.remove('is-invalid');
                    field.classList.add('is-valid');
                    if (icon) icon.innerHTML = '<i class="icon-check" style="color: #28a745;"></i>';
                } else {
                    field.classList.remove('is-valid');
                    if (field.value.trim() !== '') {
                        field.classList.add('is-invalid');
                        if (icon) icon.innerHTML = '<i class="icon-close" style="color: #dc3545;"></i>';
                    } else {
                        field.classList.remove('is-invalid');
                        if (icon) icon.innerHTML = '';
                    }
                }
            }

            function validateForm() {
                let isValid = true;
                const requiredFields = [nameInput, slugInput];

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    }
                });

                if (!isValid) {
                    Swal.fire({
                        title: 'Form Belum Lengkap',
                        text: 'Mohon lengkapi semua field yang wajib diisi',
                        icon: 'warning'
                    });
                }

                return isValid;
            }

            // Initialize counters
            updateCharCounter(nameCounter, nameInput.value.length, 100);
            updateCharCounter(descCounter, descInput.value.length, 500);
            updateCharCounter(metaTitleCounter, metaTitleInput.value.length, 60);
            updateSlugPreview(slugInput.value);
        });

        function showUploadContainer() {
            document.getElementById('currentImageContainer').style.display = 'none';
            document.getElementById('uploadContainer').style.display = 'block';
        }
    </script>
@endpush
