@extends('layouts.admin')

@section('content')
    <style>
        .product-card {
            transition: all 0.3s ease;
            border: 1px solid #e3e6f0;
            border-radius: 8px;
        }
        .product-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
        }
        .badge-status {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        .dropdown-toggle::after {
            margin-left: 0.5rem;
        }
        .bulk-actions {
            background: #f8f9fc;
            border: 1px solid #e3e6f0;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1rem;
            display: none;
        }
        .table-modern th {
            background: #f8f9fc;
            border-top: none;
            font-weight: 600;
            color: #5a5c69;
            font-size: 0.875rem;
            padding: 1rem 0.75rem;
        }
        .table-modern td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
            border-top: 1px solid #e3e6f0;
        }
        .product-name {
            font-weight: 600;
            color: #5a5c69;
            margin-bottom: 0.25rem;
        }
        .product-sku {
            font-size: 0.75rem;
            color: #858796;
        }
        .filter-section {
            background: white;
            border: 1px solid #e3e6f0;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .stats-card {
            background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .btn-sm-custom {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
        .price-display {
            font-weight: 600;
            color: #28a745;
        }
        .price-original {
            text-decoration: line-through;
            color: #858796;
            font-size: 0.875rem;
        }
        .stock-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 0.5rem;
        }
        .stock-in { background-color: #28a745; }
        .stock-out { background-color: #dc3545; }
        .stock-low { background-color: #ffc107; }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <!-- Header Section -->
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <div>
                    <h3 class="mb-2">Manajemen Produk</h3>
                    <p class="text-tiny text-muted">Kelola produk e-commerce Anda dengan mudah</p>
                </div>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><div class="text-tiny">Produk</div></li>
                </ul>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">{{ $products->total() }}</h4>
                                <small>Total Produk</small>
                            </div>
                            <i class="icon-package" style="font-size: 2rem; opacity: 0.7;"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card" style="background: linear-gradient(45deg, #f093fb 0%, #f5576c 100%);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">{{ $products->where('featured', 1)->count() }}</h4>
                                <small>Produk Unggulan</small>
                            </div>
                            <i class="icon-star" style="font-size: 2rem; opacity: 0.7;"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card" style="background: linear-gradient(45deg, #4facfe 0%, #00f2fe 100%);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">{{ $products->where('stock_status', 'instock')->count() }}</h4>
                                <small>Stok Tersedia</small>
                            </div>
                            <i class="icon-check-circle" style="font-size: 2rem; opacity: 0.7;"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card" style="background: linear-gradient(45deg, #fa709a 0%, #fee140 100%);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">{{ $products->where('stock_status', 'outofstock')->count() }}</h4>
                                <small>Stok Habis</small>
                            </div>
                            <i class="icon-alert-triangle" style="font-size: 2rem; opacity: 0.7;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wg-box">
                <!-- Filter & Search Section -->
                <div class="filter-section">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-md-6 mb-3 mb-lg-0">
                            <div class="wg-filter">
                                <form class="form-search" method="GET">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Cari produk..."
                                               name="search" value="{{ request('search') }}">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="icon-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 mb-3 mb-lg-0">
                            <select class="form-select" name="category_filter" onchange="filterProducts()">
                                <option value="">Semua Kategori</option>
                                <!-- Add categories dynamically -->
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-6 mb-3 mb-lg-0">
                            <select class="form-select" name="status_filter" onchange="filterProducts()">
                                <option value="">Semua Status</option>
                                <option value="instock">Tersedia</option>
                                <option value="outofstock">Habis</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-6 text-lg-end">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="exportProducts()">
                                    <i class="icon-download"></i> Export
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="toggleBulkActions()">
                                    <i class="icon-check-square"></i> Bulk
                                </button>
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.product.add') }}">
                                    <i class="icon-plus"></i> Tambah Produk
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bulk Actions -->
                <div class="bulk-actions" id="bulkActions">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <span class="text-muted">
                                <span id="selectedCount">0</span> produk dipilih
                            </span>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-success btn-sm" onclick="bulkActivate()">
                                    <i class="icon-check"></i> Aktifkan
                                </button>
                                <button type="button" class="btn btn-outline-warning btn-sm" onclick="bulkDeactivate()">
                                    <i class="icon-pause"></i> Nonaktifkan
                                </button>
                                <button type="button" class="btn btn-outline-info btn-sm" onclick="bulkFeatured()">
                                    <i class="icon-star"></i> Jadikan Unggulan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Success Message -->
                @if (Session::has('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="icon-check-circle me-2"></i>{{ Session::get('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Products Table -->
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th width="50">
                                    <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                </th>
                                <th width="300">Produk</th>
                                <th width="150">Harga</th>
                                <th width="120">Stok</th>
                                <th width="100">Status</th>
                                <th width="120">Rating</th>
                                <th width="120">Terakhir Update</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr class="product-row" data-product-id="{{ $product->id }}">
                                    <td>
                                        <input type="checkbox" class="product-checkbox" value="{{ $product->id }}"
                                               onchange="updateSelectedCount()">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('uploads/products/thumbnails') }}/{{ $product->image }}"
                                                 alt="{{ $product->name }}" class="product-image me-3">
                                            <div>
                                                <div class="product-name">{{ Str::limit($product->name, 40) }}</div>
                                                <div class="product-sku">SKU: {{ $product->SKU }}</div>
                                                <div class="product-sku">{{ $product->category->name }} • {{ $product->brand->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="price-display">{{ formatRupiah($product->sale_price) }}</div>
                                        @if($product->regular_price > $product->sale_price)
                                            <div class="price-original">{{ formatRupiah($product->regular_price) }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="stock-indicator {{ $product->quantity > 10 ? 'stock-in' : ($product->quantity > 0 ? 'stock-low' : 'stock-out') }}"></span>
                                            <span class="fw-bold">{{ $product->quantity }}</span>
                                            <small class="text-muted ms-1">unit</small>
                                        </div>
                                        <div class="mt-1">
                                            <span class="badge {{ $product->stock_status == 'instock' ? 'badge-success' : 'badge-danger' }} badge-status">
                                                {{ $product->stock_status == 'instock' ? 'Tersedia' : 'Habis' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="mb-1">
                                            @if($product->featured)
                                                <span class="badge badge-warning badge-status">
                                                    <i class="icon-star"></i> Unggulan
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="badge {{ $product->quantity > 0 ? 'badge-success' : 'badge-secondary' }} badge-status">
                                                {{ $product->quantity > 0 ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="icon-star {{ $i <= 4 ? 'text-warning' : 'text-muted' }}" style="font-size: 0.75rem;"></i>
                                                @endfor
                                            </div>
                                            <small class="text-muted">(4.0)</small>
                                        </div>
                                        <small class="text-muted">25 ulasan</small>
                                    </td>
                                    <td>
                                        <div class="text-muted" style="font-size: 0.75rem;">
                                            {{ $product->updated_at->format('d/m/Y') }}
                                            <br>
                                            {{ $product->updated_at->format('H:i') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                    type="button" data-bs-toggle="dropdown">
                                                <i class="icon-more-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="viewProduct({{ $product->id }})">
                                                        <i class="icon-eye me-2"></i>Lihat Detail
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.product.edit', ['id' => $product->id]) }}">
                                                        <i class="icon-edit me-2"></i>Edit Produk
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="duplicateProduct({{ $product->id }})">
                                                        <i class="icon-copy me-2"></i>Duplikasi
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="toggleFeatured({{ $product->id }})">
                                                        <i class="icon-star me-2"></i>
                                                        {{ $product->featured ? 'Hapus dari Unggulan' : 'Jadikan Unggulan' }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-warning" href="#" onclick="deactivateProduct({{ $product->id }})">
                                                        <i class="icon-pause me-2"></i>Nonaktifkan Produk
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="#" onclick="confirmDeactivate({{ $product->id }})">
                                                        <i class="icon-trash-2 me-2"></i>Hapus Produk
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="icon-package" style="font-size: 3rem; opacity: 0.3;"></i>
                                            <h5 class="mt-3">Belum ada produk</h5>
                                            <p>Mulai tambahkan produk pertama Anda</p>
                                            <a href="{{ route('admin.product.add') }}" class="btn btn-primary">
                                                <i class="icon-plus"></i> Tambah Produk
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    <div class="text-muted">
                        Menampilkan {{ $products->firstItem() ?? 0 }} sampai {{ $products->lastItem() ?? 0 }}
                        dari {{ $products->total() }} produk
                    </div>
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Product Detail Modal -->
    <div class="modal fade" id="productDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="productDetailContent">
                    <!-- Content will be loaded dynamically -->
                </div>
            </div>
        </div>
    </div>

    <!-- Deactivate Confirmation Modal -->
    <div class="modal fade" id="deactivateModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Nonaktifkan Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="icon-alert-triangle text-warning" style="font-size: 4rem;"></i>
                        <h4 class="mt-3">Nonaktifkan Produk?</h4>
                        <p class="text-muted">
                            Produk akan disembunyikan dari toko dan tidak bisa dibeli pelanggan.
                            Data produk akan tetap tersimpan.
                        </p>
                        <div class="alert alert-info">
                            <small>
                                <i class="icon-info me-1"></i>
                                Anda dapat mengaktifkan kembali produk ini kapan saja.
                            </small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-warning" onclick="confirmDeactivateAction()">
                        Ya, Nonaktifkan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let selectedProductId = null;

        // Toggle select all products
        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
            updateSelectedCount();
        }

        // Update selected count
        function updateSelectedCount() {
            const checkboxes = document.querySelectorAll('.product-checkbox:checked');
            const count = checkboxes.length;
            document.getElementById('selectedCount').textContent = count;

            const bulkActions = document.getElementById('bulkActions');
            if (count > 0) {
                bulkActions.style.display = 'block';
            } else {
                bulkActions.style.display = 'none';
            }
        }

        // Toggle bulk actions
        function toggleBulkActions() {
            const bulkActions = document.getElementById('bulkActions');
            if (bulkActions.style.display === 'none' || bulkActions.style.display === '') {
                bulkActions.style.display = 'block';
            } else {
                bulkActions.style.display = 'none';
            }
        }

        // View product detail
        function viewProduct(productId) {
            // Show loading
            document.getElementById('productDetailContent').innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat detail produk...</p>
                </div>
            `;

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('productDetailModal'));
            modal.show();

            // Here you would typically load product details via AJAX
            setTimeout(() => {
                document.getElementById('productDetailContent').innerHTML = `
                    <div class="text-center text-muted">
                        <p>Fitur detail produk akan segera tersedia</p>
                    </div>
                `;
            }, 1000);
        }

        // Confirm deactivate product
        function confirmDeactivate(productId) {
            selectedProductId = productId;
            const modal = new bootstrap.Modal(document.getElementById('deactivateModal'));
            modal.show();
        }

        // Confirm deactivate action
        function confirmDeactivateAction() {
            if (selectedProductId) {
                // Create and submit form for soft delete
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/product/${selectedProductId}/deactivate`;

                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Add method override
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'PATCH';
                form.appendChild(methodField);

                document.body.appendChild(form);
                form.submit();
            }
        }

        // Toggle featured status
        function toggleFeatured(productId) {
            if (confirm('Ubah status unggulan produk ini?')) {
                // Create and submit form
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/product/${productId}/toggle-featured`;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'PATCH';
                form.appendChild(methodField);

                document.body.appendChild(form);
                form.submit();
            }
        }

        // Duplicate product
        function duplicateProduct(productId) {
            if (confirm('Duplikasi produk ini?')) {
                window.location.href = `/admin/product/${productId}/duplicate`;
            }
        }

        // Bulk actions
        function bulkActivate() {
            const selected = getSelectedProducts();
            if (selected.length === 0) {
                alert('Pilih produk terlebih dahulu');
                return;
            }
            if (confirm(`Aktifkan ${selected.length} produk yang dipilih?`)) {
                performBulkAction('activate', selected);
            }
        }

        function bulkDeactivate() {
            const selected = getSelectedProducts();
            if (selected.length === 0) {
                alert('Pilih produk terlebih dahulu');
                return;
            }
            if (confirm(`Nonaktifkan ${selected.length} produk yang dipilih?`)) {
                performBulkAction('deactivate', selected);
            }
        }

        function bulkFeatured() {
            const selected = getSelectedProducts();
            if (selected.length === 0) {
                alert('Pilih produk terlebih dahulu');
                return;
            }
            if (confirm(`Jadikan ${selected.length} produk sebagai unggulan?`)) {
                performBulkAction('featured', selected);
            }
        }

        // Get selected products
        function getSelectedProducts() {
            const checkboxes = document.querySelectorAll('.product-checkbox:checked');
            return Array.from(checkboxes).map(cb => cb.value);
        }

        // Perform bulk action
        function performBulkAction(action, products) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/products/bulk-action';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            const actionField = document.createElement('input');
            actionField.type = 'hidden';
            actionField.name = 'action';
            actionField.value = action;
            form.appendChild(actionField);

            const productsField = document.createElement('input');
            productsField.type = 'hidden';
            productsField.name = 'products';
            productsField.value = JSON.stringify(products);
            form.appendChild(productsField);

            document.body.appendChild(form);
            form.submit();
        }

        // Export products
        function exportProducts() {
            window.location.href = '/admin/products/export';
        }

        // Filter products
        function filterProducts() {
            // This would trigger a form submission or AJAX request
            console.log('Filter products');
        }

        // Initialize tooltips (if using Bootstrap tooltips)
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
