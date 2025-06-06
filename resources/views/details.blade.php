@extends('layouts.app')

@section('content')


    <main class="pt-90">
        <div class="mb-md-1 pb-md-3"></div>
        <section class="product-single container">
            <div class="row" style="margin-top: 2%">
                <div class="col-lg-7">
                    <div class="product-single__media" data-media-type="vertical-thumbnail">
                        <div class="product-single__image">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide product-single__image-item">
                                        <img loading="lazy" class="h-auto"
                                            src="{{ asset('uploads/products') }}/{{ $product->image }}" width="674"
                                            height="674" alt="" />


                                        <a data-fancybox="gallery"
                                            href="{{ asset('uploads/products') }}/{{ $product->image }}"
                                            data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">


                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_zoom" />
                                            </svg>
                                        </a>
                                    </div>

                                    @foreach (explode(',', $product->images) as $gimg)
                                        <div class="swiper-slide product-single__image-item">
                                            <img loading="lazy" class="h-auto"
                                                src="{{ asset('uploads/products') }}/{{ trim($gimg) }}" width="674"
                                                height="674" alt="" />
                                            <a data-fancybox="gallery"
                                                href="{{ asset('uploads/products') }}/{{ trim($gimg) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_zoom" />
                                                </svg>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-prev"><svg width="7" height="11" viewBox="0 0 7 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_prev_sm" />
                                    </svg></div>
                                <div class="swiper-button-next"><svg width="7" height="11" viewBox="0 0 7 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_next_sm" />
                                    </svg></div>
                            </div>
                        </div>
                        <div class="product-single__thumbnail">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide product-single__image-item"><img loading="lazy" class="h-auto"
                                            src="{{ asset('uploads/products/thumbnails') }}/{{ $product->image }}"
                                            width="104" height="104" alt="" /></div>
                                    @foreach (explode(',', $product->images) as $gimg)
                                        <div class="swiper-slide product-single__image-item">
                                            <img loading="lazy" class="h-auto"
                                                src="{{ asset('uploads/products/thumbnails') }}/{{ trim($gimg) }}"
                                                width="104" height="104" alt="" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <h1 class="product-single__name">{{ $product->name }}</h1>


                    <div class="product-single__price">
                        <span class="current-price">
                            @if ($product->sale_price < $product->regular_price)
                                <s>{{ formatRupiah($product->regular_price) }}</s>
                                {{ formatRupiah($product->sale_price) }}
                                <span class="discount-text">
                                    {{ round((($product->regular_price - $product->sale_price) * 100) / $product->regular_price) }}%
                                    DISKON
                                </span>
                            @else
                                {{ formatRupiah($product->regular_price) }}
                            @endif
                        </span>
                    </div>
                    <div class="product-single__short-desc">
                        <p>{{ $product->short_description }}</p>
                    </div>

                    <div class="stock-info d-flex align-items-center">
                        <span class="text-secondary fw-semibold me-2" style="font-size: 1rem;">
                            <i class="fas fa-box-open me-1"></i> Stok tersedia:
                        </span>
                        <span class="badge fw-bold rounded-pill px-3" id="main-stock-display"
                            style="background-color: #D2B48C; color: #fff; font-size: 0.9rem;">
                            @if ($product->sizes->count() > 0)
                                {{ $product->sizes->sum('pivot.stock') }}
                            @else
                                {{ $product->quantity - ($product->reserved_quantity ?? 0) }}
                            @endif
                        </span>
                    </div>

                    <!-- Tambahan: Info stok per ukuran yang dipilih -->
                    <div class="size-specific-stock d-none mt-2" id="size-specific-stock">
                        <div class="d-flex align-items-center">
                            <span class="text-muted small me-2">
                                <i class="fas fa-info-circle me-1"></i>
                            </span>
                            <span class="badge bg-info text-white small" id="selected-size-stock-text">
                                Stok: 0
                            </span>
                        </div>
                    </div>
                    <!-- Hidden input untuk simpan stok ukuran yang dipilih -->
                    <input type="hidden" id="selected-size-stock" value="0">
                    <!-- Sebelum buttons "Tambahkan ke Keranjang" dan "Beli Sekarang" -->
                    <div class="product-single__addtocart">
                        @if ($product->sizes->count() > 0)
                            <div class="size-selector mb-3">
                                <label class="fw-semibold mb-2">Pilih Ukuran:</label>
                                <div class="d-flex flex-wrap gap-2" id="size-buttons">
                                    @foreach ($product->sizes as $size)
                                        <button type="button" class="btn size-btn" data-size-id="{{ $size->id }}"
                                            data-size-name="{{ $size->name }}" data-stock="{{ $size->pivot->stock }}"
                                            @if ($size->pivot->stock <= 0) disabled @endif
                                            style="border: 1px solid #d2b48c; color: #956a3b; background-color: white; min-width: 50px; padding: 8px 16px; border-radius: 4px;
                                               @if ($size->pivot->stock <= 0) opacity: 0.5; cursor: not-allowed; @endif">
                                            {{ $size->name }}
                                            <small class="d-block text-muted mt-1" style="font-size: 0.75rem;">
                                                @if ($size->pivot->stock > 0)
                                                    Stok: {{ $size->pivot->stock }}
                                                @else
                                                    <span class="text-danger">Habis</span>
                                                @endif
                                            </small>
                                        </button>
                                    @endforeach
                                </div>
                                <div class="selected-size mt-2 d-none" id="selected-size-info">
                                    <span class="badge bg-secondary">Ukuran dipilih: <span id="size-name"></span></span>
                                </div>
                                <div class="text-danger small mt-2 d-none" id="size-error">
                                    Silakan pilih ukuran terlebih dahulu
                                </div>
                                <input type="hidden" id="selected-size-id" name="size_id" value="">
                            </div>
                        @endif

                        <div class="d-flex gap-2 mt-3">
                            <button type="button" class="btn flex-grow-1" id="open-quantity-modal"
                                style="background-color: rgba(149, 106, 59, 0.2); border: 1px solid #956a3b; color: #956a3b; padding: 0.75rem 1rem;">
                                <i class="fas fa-shopping-cart me-2"></i> Tambahkan ke Keranjang
                            </button>
                            <button type="button" id="buy-now" class="btn btn-dark flex-grow-1"
                                style="background-color: #956a3b; border-color: #956a3b; color: #ffffff; padding: 0.75rem 1rem;">
                                <i class=""></i> Beli Sekarang
                            </button>
                        </div>
                    </div>

                    <!-- Hidden Forms for Cart and Buy Now -->
                    <form name="addtocart-form" id="addtocart-form" method="POST" action="{{ route('cart.add') }}"
                        style="display: none;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id }}" />
                        <input type="hidden" name="name" value="{{ $product->name }}" />
                        <input type="hidden" name="quantity" id="cart-quantity" value="1" />
                        <input type="hidden" name="price"
                            value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price }}" />
                        <input type="hidden" name="size_id" id="cart-size-id" value="" />
                    </form>

                    <form name="buynow-form" id="buynow-form" method="POST" action="{{ route('cart.add') }}"
                        style="display: none;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id }}" />
                        <input type="hidden" name="name" value="{{ $product->name }}" />
                        <input type="hidden" name="quantity" id="buynow-quantity" value="1" />
                        <input type="hidden" name="price"
                            value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price }}" />
                        <input type="hidden" name="size_id" id="buynow-size-id" value="" />
                        <input type="hidden" name="checkout_redirect" value="1" />
                    </form>

                    <!-- Quantity Modal (Diperbaiki) -->
                    <div class="modal fade quantity-modal" id="quantityModal" tabindex="-1"
                        aria-labelledby="quantityModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="quantityModalLabel">
                                        <i class="fas fa-shopping-basket me-2"></i> Pilih Jumlah
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="product-info">
                                        <img src="{{ asset('uploads/products') }}/{{ $product->image }}"
                                            alt="{{ $product->name }}" class="product-thumbnail">
                                        <div class="product-details">
                                            <h5>{{ $product->name }}</h5>
                                            <div class="product-price">
                                                @if ($product->sale_price < $product->regular_price)
                                                    <span>{{ formatRupiah($product->sale_price) }}</span>
                                                    <small
                                                        class="text-muted"><s>{{ formatRupiah($product->regular_price) }}</s></small>
                                                @else
                                                    <span>{{ formatRupiah($product->regular_price) }}</span>
                                                @endif
                                            </div>
                                            @if ($product->sizes->count() > 0)
                                                <div class="selected-size-info mt-1" id="modal-size-info">
                                                    <span class="badge bg-secondary">Ukuran: <span
                                                            id="modal-size-name"></span></span>
                                                </div>
                                            @endif
                                            <div class="stock-info">
                                                <i class="fas fa-box-open me-1"></i> Stok tersedia: <span
                                                    class="fw-semibold" id="modal-available-stock">
                                                    @if ($product->sizes->count() > 0)
                                                        0 <!-- Akan diupdate via JavaScript saat ukuran dipilih -->
                                                    @else
                                                        {{ $product->quantity - ($product->reserved_quantity ?? 0) }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="quantity-controls">
                                        <button type="button" class="qty-btn modal-reduce-qty">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" class="qty-input modal-qty-input" value="1"
                                            min="1" max="{{ $product->quantity - $product->reserved_quantity }}">
                                        <button type="button" class="qty-btn modal-increase-qty">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-cancel"
                                        data-bs-dismiss="modal">Batalkan</button>
                                    <button type="button" class="btn btn-confirm" id="confirmAddToCart">
                                        <i class="fas fa-shopping-cart me-2"></i> Tambahkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Actions Section -->
                    <div class="product-single__addtolinks mt-4 d-flex gap-3">
                        @if (\Surfsidemedia\Shoppingcart\Facades\Cart::instance('wishlist')->content()->where('id', $product->id)->count() > 0)
                            <form method="POST"
                                action="{{ route('wishlist.remove', ['rowId' => \Surfsidemedia\Shoppingcart\Facades\Cart::instance('wishlist')->content()->where('id', $product->id)->first()->rowId]) }}"
                                id="frm-remove-item">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="wishlist-btn in-wishlist" id="remove-from-wishlist">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16"
                                        viewBox="0 0 20 18" fill="#e53935">
                                        <path
                                            d="M10 18L8.55 16.7C3.4 12.1 0 9.1 0 5.5C0 2.5 2.42 0 5.5 0C7.24 0 8.91 0.81 10 2.09C11.09 0.81 12.76 0 14.5 0C17.58 0 20 2.5 20 5.5C20 9.1 16.6 12.1 11.45 16.7L10 18Z" />
                                    </svg>
                                    <span>Hapus dari Favorit</span>
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('wishlist.add') }}" id="wishlist-form">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}" />
                                <input type="hidden" name="name" value="{{ $product->name }}" />
                                <input type="hidden" name="price"
                                    value="{{ $product->sale_price == '' ? $product->regular_price : $product->sale_price }}" />
                                <input type="hidden" name="quantity" value="1" />
                                <button type="button" class="wishlist-btn" id="add-to-wishlist">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16"
                                        viewBox="0 0 20 18" fill="none" stroke="#555" stroke-width="1.5">
                                        <path
                                            d="M10 18L8.55 16.7C3.4 12.1 0 9.1 0 5.5C0 2.5 2.42 0 5.5 0C7.24 0 8.91 0.81 10 2.09C11.09 0.81 12.76 0 14.5 0C17.58 0 20 2.5 20 5.5C20 9.1 16.6 12.1 11.45 16.7L10 18Z" />
                                    </svg>
                                    <span>Tambahkan ke Favorit</span>
                                </button>
                            </form>
                        @endif

                    </div>

                    <!-- Custom notification element -->
                    <div class="wishlist-notification" id="wishlist-notification">
                        <div class="wishlist-notification__icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="wishlist-notification__content">
                            <div class="wishlist-notification__title" id="notification-title">Ditambahkan ke Favorit</div>
                            <div class="wishlist-notification__message" id="notification-message"></div>
                        </div>
                        <button class="wishlist-notification__close" id="close-notification">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                </div>
            </div>


        </section>

        <!-- Cart notification -->
        <div class="cart-notification" id="cart-notification">
            <div class="cart-notification__icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="cart-notification__content">
                <div class="cart-notification__title" id="cart-notification-title">Ditambahkan ke Keranjang</div>
                <div class="cart-notification__message" id="cart-notification-message"></div>

                <!-- Indicator stok (opsional) -->
                <div class="stock-level-indicator d-none" id="stock-level-indicator">
                    <div class="stock-level-bar" id="stock-level-bar"></div>
                </div>

                <!-- Tombol aksi (opsional) -->
                <div class="cart-notification__actions d-none" id="cart-notification-actions">
                    <button class="cart-notification__action-btn cart-notification__secondary-btn"
                        id="notification-dismiss">Tutup</button>
                    <button class="cart-notification__action-btn cart-notification__primary-btn"
                        id="notification-action">Lihat Keranjang</button>
                </div>
            </div>
            <button class="cart-notification__close" id="close-cart-notification">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </main>

@endsection

@push('scripts')
    <!-- Function to show cart notification -->
    <script>
        // Function to show cart notification
        function showCartNotification(message, isSuccess = true) {
            const notification = $('#cart-notification');
            const title = $('#cart-notification-title');
            const messageEl = $('#cart-notification-message');

            // Set content
            messageEl.text(message);

            // Set type (success or error)
            if (isSuccess) {
                notification.removeClass('error').addClass('success');
                title.text('Ditambahkan ke Keranjang');
                $('.cart-notification__icon i').removeClass('fa-exclamation-circle').addClass('fa-shopping-cart');
            } else {
                notification.removeClass('success').addClass('error');
                title.text('Gagal Ditambahkan');
                $('.cart-notification__icon i').removeClass('fa-shopping-cart').addClass('fa-exclamation-circle');
            }

            // Show notification
            notification.css('display', 'flex').addClass('show');

            // Auto hide after 3 seconds
            setTimeout(() => {
                notification.removeClass('show');
                setTimeout(() => notification.css('display', 'none'), 300);
            }, 3000);
        }

        // Fungsi notifikasi yang ditingkatkan
        function showEnhancedStockNotification(availableStock, requestedQuantity, productName, isOutOfStock = false) {
            // Dapatkan elemen notifikasi
            const notification = $('#cart-notification');
            const title = $('#cart-notification-title');
            const messageEl = $('#cart-notification-message');
            const stockIndicator = $('#stock-level-indicator');
            const stockBar = $('#stock-level-bar');
            const actions = $('#cart-notification-actions');

            // Set judul dan pesan berdasarkan kondisi stok
            if (isOutOfStock) {
                // Stok habis total
                title.text('Stok Tidak Tersedia');
                messageEl.html(
                    `<strong>${productName}</strong> sedang tidak tersedia. Silakan cek kembali nanti atau hubungi layanan pelanggan kami.`
                );

                // Tampilkan tombol aksi jika diinginkan
                actions.removeClass('d-none');
                $('#notification-action').text('Lihat Produk Serupa').attr('data-action', 'similar');
            } else {
                // Stok ada tapi kurang dari permintaan
                title.text('Stok Terbatas');
                messageEl.html(
                    `Maksimal pembelian <strong>${availableStock} item</strong> untuk produk ini.<br>Jumlah permintaan Anda (${requestedQuantity}) melebihi stok yang tersedia.`
                );

                // Tampilkan indikator stok
                stockIndicator.removeClass('d-none');

                // Hitung persentase stok dan atur warna
                const stockPercent = Math.min(availableStock / 10 * 100, 100); // Asumsi max stok 10 untuk indikator
                stockBar.css('width', `${stockPercent}%`);

                if (stockPercent > 60) {
                    stockBar.addClass('stock-level-high').removeClass('stock-level-medium stock-level-low');
                } else if (stockPercent > 30) {
                    stockBar.addClass('stock-level-medium').removeClass('stock-level-high stock-level-low');
                } else {
                    stockBar.addClass('stock-level-low').removeClass('stock-level-high stock-level-medium');
                }

                // Tampilkan tombol aksi
                actions.removeClass('d-none');
                $('#notification-action').text('Sesuaikan Kuantitas').attr('data-action', 'adjust');
            }

            // Atur tampilan notifikasi
            notification.removeClass('success').addClass('error');
            $('.cart-notification__icon i').removeClass('fa-shopping-cart').addClass('fa-exclamation-triangle');

            // Tampilkan notifikasi dengan animasi yang lebih menarik
            notification.css({
                'display': 'flex',
                'transform': 'translateY(-20px)',
                'opacity': '0'
            }).addClass('show');

            // Animasi masuk
            setTimeout(() => {
                notification.css({
                    'transform': 'translateY(0)',
                    'opacity': '1'
                });
            }, 10);

            // Auto hide setelah 5 detik
            setTimeout(() => {
                notification.css({
                    'transform': 'translateY(-20px)',
                    'opacity': '0'
                });
                setTimeout(() => notification.css('display', 'none'), 300);
            }, 5000);

            // Hapus kelas show untuk memungkinkan notifikasi muncul lagi
            setTimeout(() => {
                notification.removeClass('show');
            }, 5300);
        }

        // Fungsi pemeriksaan stok yang ditingkatkan
        function enhancedStockCheck(requestedQuantity, availableStock, productName) {
            // Untuk produk dengan ukuran, gunakan stok ukuran yang dipilih
            if ({{ $product->sizes->count() > 0 ? 'true' : 'false' }}) {
                const selectedSizeId = $('#selected-size-id').val();
                if (!selectedSizeId) {
                    showCartNotification('Silakan pilih ukuran terlebih dahulu', false);
                    return false;
                }

                // Ambil stok dari tombol ukuran yang dipilih
                const selectedSizeBtn = $(`.size-btn[data-size-id="${selectedSizeId}"]`);
                availableStock = selectedSizeBtn.data('stock') || 0;
            }

            if (availableStock <= 0) {
                showEnhancedStockNotification(0, requestedQuantity, productName, true);
                updateButtonsForOutOfStock(true);
                return false;
            } else if (requestedQuantity > availableStock) {
                showEnhancedStockNotification(availableStock, requestedQuantity, productName, false);

                if ($('.modal-qty-input').length) {
                    $('.modal-qty-input').val(availableStock).trigger('change');
                }
                return false;
            }

            return true;
        }

        // Fungsi untuk memperbarui tampilan tombol ketika stok habis
        function updateButtonsForOutOfStock(isOutOfStock) {
            if (isOutOfStock) {
                // Disable tombol dan ubah tampilannya
                $('#open-quantity-modal, #buy-now').prop('disabled', true)
                    .addClass('out-of-stock')
                    .css({
                        'background-color': '#f5f5f5',
                        'border-color': '#ddd',
                        'color': '#aaa',
                        'cursor': 'not-allowed'
                    });

                // Ubah teks tombol
                $('#open-quantity-modal').html('<i class="fas fa-ban me-2"></i> Stok Habis');
                $('#buy-now').html('<i class="fas fa-exclamation-circle me-2"></i> Tidak Tersedia');

                // Tambahkan tooltip
                $('#open-quantity-modal, #buy-now').attr('data-bs-toggle', 'tooltip')
                    .attr('data-bs-placement', 'top')
                    .attr('title', 'Produk ini sedang tidak tersedia. Silakan cek kembali nanti.');

                // Initialize tooltips jika Bootstrap sudah dimuat
                if (typeof bootstrap !== 'undefined') {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                    tooltipTriggerList.map(function(tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                }
            } else {
                // Kembalikan ke tampilan normal jika stok tersedia kembali
                $('#open-quantity-modal, #buy-now').prop('disabled', false)
                    .removeClass('out-of-stock')
                    .removeAttr('data-bs-toggle')
                    .removeAttr('data-bs-placement')
                    .removeAttr('title');

                $('#open-quantity-modal').html('<i class="fas fa-shopping-cart me-2"></i> Tambahkan ke Keranjang')
                    .css({
                        'background-color': 'rgba(149, 106, 59, 0.2)',
                        'border': '1px solid #956a3b',
                        'color': '#956a3b',
                        'cursor': 'pointer'
                    });

                $('#buy-now').html('Beli Sekarang')
                    .css({
                        'background-color': '#956a3b',
                        'border-color': '#956a3b',
                        'color': '#ffffff',
                        'cursor': 'pointer'
                    });
            }
        }

        // Close notification button
        $('#close-cart-notification').on('click', function() {
            const notification = $('#cart-notification');
            notification.removeClass('show');
            setTimeout(() => notification.css('display', 'none'), 300);
        });

        // Event handler untuk tombol aksi di notifikasi
        $(document).ready(function() {
            // Handler untuk tombol dismiss
            $(document).on('click', '#notification-dismiss', function() {
                $('#cart-notification').removeClass('show');
                setTimeout(() => $('#cart-notification').css('display', 'none'), 300);
            });

            // Handler untuk tombol aksi utama
            $(document).on('click', '#notification-action', function() {
                const action = $(this).attr('data-action');

                if (action === 'adjust') {
                    // Buka kembali modal kuantitas dengan nilai maksimal
                    $('#cart-notification').removeClass('show');
                    setTimeout(() => {
                        $('#cart-notification').css('display', 'none');
                        $('#quantityModal').modal('show');
                    }, 300);
                } else if (action === 'similar') {
                    // Redirect ke halaman produk serupa (kategori yang sama)
                    window.location.href =
                        "{{ route('shop.index', ['category' => $product->category->slug]) }}";
                }
            });

            // Periksa stok saat halaman dimuat
            const initialStock = {{ $product->quantity - $product->reserved_quantity }};

            // Jika stok kosong, update tampilan tombol
            if (initialStock <= 0) {
                updateButtonsForOutOfStock(true);
            }

            // Jika stok sangat terbatas (misalnya kurang dari 5)
            else if (initialStock < 5) {
                // Tampilkan peringatan stok terbatas
                const stockWarning = `
            <div class="alert alert-warning mt-3 d-flex align-items-center" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div>
                    <strong>Stok Terbatas!</strong> Tersisa hanya ${initialStock} item.
                </div>
            </div>
        `;
                if (!$('.alert-warning').length) {
                    $('.product-single__addtocart').before(stockWarning);
                }
            }
        });
    </script>

    <!-- Function to show cart notification Tombol Beli Sekarang -->
    <script>
        $(document).ready(function() {
            // Kode yang sudah ada tetap dipertahankan

            // Tombol Beli Sekarang
            $('#buy-now').on('click', function() {
                const quantity = $('.qty-control__number').val();
                const maxStock = {{ $product->quantity }};

                // Validasi quantity tidak melebihi stok
                if (parseInt(quantity) > maxStock) {
                    showNotification(`Tidak bisa menambah lebih dari stok yang tersedia: ${maxStock} item`,
                        'error');
                    return;
                }

                // Update quantity di form beli sekarang
                $('#buynow-quantity').val(quantity);

                // Submit form secara asynchronous
                const formData = $('#buynow-form').serialize();

                $.ajax({
                    url: "{{ route('cart.add') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Update jumlah item di navbar jika perlu
                            $('.js-cart-items-count').text(response.cartCount);

                            // Redirect ke halaman keranjang
                            window.location.href = "{{ route('cart.index') }}";
                        } else {
                            showNotification(response.message ||
                                'Gagal menambahkan produk ke keranjang', 'error');
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Gagal menambahkan produk ke keranjang';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        showNotification(errorMsg, 'error');
                    }
                });
            });
        });
    </script>

    <!-- Function modals -->
    <script>
        $(document).ready(function() {
            // Clear any existing event handlers to prevent conflicts
            $('#open-quantity-modal').off('click');

            // Create a single, consolidated event handler
            $('#open-quantity-modal').on('click', function() {
                console.log('Add to Cart button clicked');

                // Check if product has sizes and if size is selected
                if ({{ $product->sizes->count() > 0 ? 'true' : 'false' }} && !$('#selected-size-id')
                    .val()) {
                    $('#size-error').removeClass('d-none');
                    $('html, body').animate({
                        scrollTop: $("#size-buttons").offset().top - 100
                    }, 500);
                    return false; // Prevent further execution
                }

                // Explicitly reset buyNow flag
                $('#quantityModal').data('buyNow', false);

                // Update modal with selected size information
                if ({{ $product->sizes->count() > 0 ? 'true' : 'false' }}) {
                    const sizeId = $('#selected-size-id').val();
                    const sizeName = $('#size-name').text();
                    const sizeBtn = $(`.size-btn[data-size-id="${sizeId}"]`);

                    // Update size info in modal
                    $('#modal-size-name').text(sizeName);

                    // Update stock info in modal
                    if (sizeBtn.length) {
                        const availableStock = sizeBtn.data('stock');
                        $('#modal-available-stock').text(availableStock);
                        $('.modal-qty-input').attr('max', availableStock);
                    }
                }

                // Show the modal
                $('#quantityModal').modal('show');
            });

            // Ensure size buttons work correctly
            $('.size-btn').off('click').on('click', function() {
                console.log('Size button clicked');

                // Remove active class from all buttons
                $('.size-btn').removeClass('active')
                    .css({
                        'background-color': 'white',
                        'color': '#956a3b'
                    });

                // Add active class to selected button
                $(this).addClass('active')
                    .css({
                        'background-color': '#956a3b',
                        'color': 'white'
                    });

                // Get size info
                const sizeId = $(this).data('size-id');
                const sizeName = $(this).data('size-name');

                // Update all hidden inputs
                $('#selected-size-id').val(sizeId);
                $('#cart-size-id').val(sizeId);
                $('#buynow-size-id').val(sizeId);

                // Update visible size info
                $('#size-name').text(sizeName);
                $('#selected-size-info').removeClass('d-none');
                $('#size-error').addClass('d-none');

                console.log('Size selected:', {
                    id: sizeId,
                    name: sizeName,
                    'selected-size-id': $('#selected-size-id').val()
                });
            });
        });
    </script>

    <!-- Function to initialize tooltips and track product navigation -->
    <script>
        $(document).ready(function() {
            // Initialize tooltips for product navigation
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    delay: {
                        show: 500,
                        hide: 100
                    }
                });
            });

            // Track product navigation for analytics (optional enhancement)
            $('.product-single__nav .nav-item').on('click', function() {
                const direction = $(this).find('.menu-link').text().trim();
                const targetProduct = $(this).attr('title') || 'Unknown product';

                // You can send this data to your analytics system
                console.log(`Navigation: ${direction} to ${targetProduct}`);

                // Optional: Add loading indicator
                $(this).append(
                    '<span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>'
                );
            });
        });
    </script>

    <!-- Function to handle size selection and stock updates -->
    <script>
        $(document).ready(function() {
            // Inisialisasi variabel untuk simpan stok yang tersedia
            const hasProductSizes = {{ $product->sizes->count() > 0 ? 'true' : 'false' }};
            let selectedSizeStock = 0;

            // Fungsi untuk mengupdate informasi stok berdasarkan ukuran yang dipilih
            function updateStockInfo(sizeId, sizeName, stock) {
                selectedSizeStock = stock;
                $('#selected-size-stock').val(stock);

                // Update tampilan stok spesifik ukuran
                let stockClass = 'bg-info';
                let stockText = `Stok ${sizeName}: ${stock}`;

                if (stock <= 0) {
                    stockClass = 'bg-danger';
                    stockText = `${sizeName}: Habis`;
                } else if (stock <= 5) {
                    stockClass = 'bg-warning text-dark';
                    stockText = `Stok ${sizeName}: ${stock} (Terbatas)`;
                }

                $('#selected-size-stock-text')
                    .removeClass('bg-info bg-warning bg-danger text-dark text-white')
                    .addClass(stockClass)
                    .text(stockText);
                $('#size-specific-stock').removeClass('d-none');

                // PERBAIKAN: Update max quantity dengan stok yang tepat
                $('#modal-available-stock').text(stock);
                $('.modal-qty-input').attr('max', stock);

                // Reset quantity jika melebihi stok
                const currentQty = parseInt($('.modal-qty-input').val());
                if (currentQty > stock) {
                    $('.modal-qty-input').val(Math.min(1, stock));
                }

                // Update tombol berdasarkan stok
                if (stock <= 0) {
                    $('#open-quantity-modal, #buy-now').prop('disabled', true)
                        .css('opacity', '0.6')
                        .attr('title', 'Stok tidak tersedia untuk ukuran ini');
                } else {
                    $('#open-quantity-modal, #buy-now').prop('disabled', false)
                        .css('opacity', '1')
                        .removeAttr('title');
                }
            }

            // Handle klik tombol ukuran
            $('.size-btn').on('click', function() {
                // Dapatkan informasi ukuran
                const sizeId = $(this).data('size-id');
                const sizeName = $(this).data('size-name');
                const stock = $(this).data('stock');

                // Reset semua tombol ukuran
                $('.size-btn').removeClass('active')
                    .css({
                        'background-color': 'white',
                        'color': '#956a3b'
                    });

                // Aktifkan tombol ukuran yang dipilih
                $(this).addClass('active')
                    .css({
                        'background-color': '#956a3b',
                        'color': 'white'
                    });

                // Update hidden inputs
                $('#selected-size-id').val(sizeId);
                $('#cart-size-id').val(sizeId);
                $('#buynow-size-id').val(sizeId);

                // Update informasi ukuran yang dipilih
                $('#size-name').text(sizeName);
                $('#selected-size-info').removeClass('d-none');
                $('#size-error').addClass('d-none');

                // Update informasi stok
                updateStockInfo(sizeId, sizeName, stock);

                // Perbarui informasi ukuran di modal
                $('#modal-size-name').text(sizeName);
            });

            // Handle klik tombol ukuran - PERBAIKAN
            $('.size-btn').on('click', function() {
                // Jangan proses jika tombol disabled (stok habis)
                if ($(this).prop('disabled')) {
                    return false;
                }

                // Dapatkan informasi ukuran
                const sizeId = $(this).data('size-id');
                const sizeName = $(this).data('size-name');
                const stock = $(this).data('stock');

                // Reset semua tombol ukuran
                $('.size-btn').removeClass('active')
                    .css({
                        'background-color': 'white',
                        'color': '#956a3b'
                    });

                // Aktifkan tombol ukuran yang dipilih (hanya jika ada stok)
                if (stock > 0) {
                    $(this).addClass('active')
                        .css({
                            'background-color': '#956a3b',
                            'color': 'white'
                        });

                    // Update hidden inputs
                    $('#selected-size-id').val(sizeId);
                    $('#cart-size-id').val(sizeId);
                    $('#buynow-size-id').val(sizeId);

                    // Update informasi ukuran yang dipilih
                    $('#size-name').text(sizeName);
                    $('#selected-size-info').removeClass('d-none');
                    $('#size-error').addClass('d-none');

                    // Update informasi stok
                    updateStockInfo(sizeId, sizeName, stock);

                    // Perbarui informasi ukuran di modal
                    $('#modal-size-name').text(sizeName);
                } else {
                    // Jika stok habis, tampilkan peringatan
                    showCartNotification(`Stok untuk ukuran ${sizeName} tidak tersedia`, false);
                }
            });

            // Tombol tambah/kurang kuantitas di modal
            $('.modal-reduce-qty').on('click', function() {
                let qty = parseInt($('.modal-qty-input').val());
                if (qty > 1) {
                    $('.modal-qty-input').val(qty - 1);
                }
            });

            $('.modal-increase-qty').on('click', function() {
                let qty = parseInt($('.modal-qty-input').val());
                let max = parseInt($('.modal-qty-input').attr('max'));

                // Pastikan max diset dengan benar
                if (hasProductSizes) {
                    max = selectedSizeStock;
                }

                if (qty < max) {
                    $('.modal-qty-input').val(qty + 1);
                }
            });

            // Validasi input kuantitas langsung
            $('.modal-qty-input').on('change', function() {
                let qty = parseInt($(this).val());
                let max = parseInt($(this).attr('max'));

                // Pastikan max diset dengan benar
                if (hasProductSizes) {
                    max = selectedSizeStock;
                }

                if (qty < 1) {
                    $(this).val(1);
                } else if (qty > max) {
                    $(this).val(max);
                    showCartNotification(`Stok hanya tersedia ${max} unit untuk ukuran ini`, false);
                }
            });

            // Tombol buka modal quantity
            $('#open-quantity-modal').on('click', function() {
                // Cek apakah produk punya ukuran dan ukuran sudah dipilih
                if (hasProductSizes && !$('#selected-size-id').val()) {
                    $('#size-error').removeClass('d-none');
                    $('html, body').animate({
                        scrollTop: $("#size-buttons").offset().top - 100
                    }, 500);
                    return;
                }

                // Update modal dengan informasi ukuran yang dipilih
                if (hasProductSizes) {
                    const sizeId = $('#selected-size-id').val();
                    const sizeName = $('#size-name').text();

                    // Update UI modal
                    $('#modal-size-name').text(sizeName);
                    $('#modal-size-info').removeClass('d-none');

                    // Update stok tersedia di modal
                    $('#modal-available-stock').text(selectedSizeStock);
                    $('.modal-qty-input').attr('max', selectedSizeStock);
                }

                // Reset quantity ke 1
                $('.modal-qty-input').val(1);

                // Tampilkan modal
                $('#quantityModal').modal('show');
            });

            // Tombol konfirmasi tambah ke keranjang
            $('#confirmAddToCart').on('click', function() {
                const quantity = parseInt($('.modal-qty-input').val());
                const productName = "{{ $product->name }}";

                let availableStock;

                // PERBAIKAN: Gunakan stok per ukuran
                if ({{ $product->sizes->count() > 0 ? 'true' : 'false' }}) {
                    const selectedSizeId = $('#selected-size-id').val();
                    if (!selectedSizeId) {
                        showCartNotification('Silakan pilih ukuran terlebih dahulu', false);
                        return;
                    }

                    const selectedSizeBtn = $(`.size-btn[data-size-id="${selectedSizeId}"]`);
                    availableStock = selectedSizeBtn.data('stock') || 0;
                } else {
                    availableStock = {{ $product->quantity - ($product->reserved_quantity ?? 0) }};
                }

                // Periksa stok dengan fungsi yang sudah diperbaiki
                if (!enhancedStockCheck(quantity, availableStock, productName)) {
                    return;
                }
                // Update quantity di form
                $('#cart-quantity').val(quantity);

                // Submit form via AJAX
                const formData = $('#addtocart-form').serialize();

                $.ajax({
                    url: "{{ route('cart.add') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Update cart count di navbar
                            $('.js-cart-items-count').text(response.cartCount);

                            // Tampilkan notifikasi sukses
                            showCartNotification(
                                '{{ $product->name }} berhasil ditambahkan ke keranjang Anda.',
                                true);

                            // Tutup modal
                            $('#quantityModal').modal('hide');
                        } else {
                            showCartNotification(response.message ||
                                'Gagal menambahkan produk ke keranjang', false);
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Gagal menambahkan produk ke keranjang';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        showCartNotification(errorMsg, false);
                    }
                });
            });

            // Tombol Beli Sekarang
            $('#buy-now').on('click', function() {
                // Cek ukuran untuk produk yang memiliki size
                if ({{ $product->sizes->count() > 0 ? 'true' : 'false' }}) {
                    const selectedSizeId = $('#selected-size-id').val();
                    if (!selectedSizeId) {
                        $('#size-error').removeClass('d-none');
                        $('html, body').animate({
                            scrollTop: $("#size-buttons").offset().top - 100
                        }, 500);
                        return;
                    }

                    // Ambil stok dari ukuran yang dipilih
                    const selectedSizeBtn = $(`.size-btn[data-size-id="${selectedSizeId}"]`);
                    const availableStock = selectedSizeBtn.data('stock') || 0;

                    // Validasi stok
                    if (availableStock <= 0) {
                        const sizeName = selectedSizeBtn.data('size-name');
                        showCartNotification(`Ukuran ${sizeName} tidak tersedia`, false);
                        return;
                    }
                }

                // Set default quantity
                const quantity = 1;
                const productName = "{{ $product->name }}";


                // Validasi stok dengan fungsi yang ditingkatkan
                let availableStock;
                if ({{ $product->sizes->count() > 0 ? 'true' : 'false' }}) {
                    availableStock = parseInt(selectedSizeStock);
                } else {
                    availableStock = {{ $product->quantity - $product->reserved_quantity }};
                }

                // Periksa stok dengan fungsi baru kita
                if (!enhancedStockCheck(quantity, availableStock, productName)) {
                    return;
                }

                // Update quantity di form
                $('#buynow-quantity').val(quantity);

                // Submit form via AJAX
                const formData = $('#buynow-form').serialize();

                $.ajax({
                    url: "{{ route('cart.add') }}",
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Redirect ke checkout
                            window.location.href = "{{ route('cart.index') }}";
                        } else {
                            showCartNotification(response.message ||
                                'Gagal menambahkan produk ke keranjang', false);
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Gagal menambahkan produk ke keranjang';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        showCartNotification(errorMsg, false);
                    }
                });
            });
        });
    </script>

    <!-- Function to update main stock display -->
    <script>
        // Fungsi untuk update tampilan stok utama
        function updateMainStockDisplay() {
            if (hasProductSizes) {
                // Jika ada ukuran yang dipilih, tampilkan stok ukuran tersebut
                if (selectedSizeStock > 0) {
                    $('#main-stock-display').text(selectedSizeStock);
                } else {
                    // Tampilkan total stok semua ukuran
                    const totalStock = {{ $product->sizes->sum('pivot.stock') }};
                    $('#main-stock-display').text(totalStock);
                }
            } else {
                // Untuk produk tanpa ukuran
                const stock = {{ $product->quantity - ($product->reserved_quantity ?? 0) }};
                $('#main-stock-display').text(stock);
            }
        }

        // Panggil fungsi ini setiap kali ukuran berubah
        $(document).ready(function() {
            updateMainStockDisplay();
        });
    </script>

    <script>
        $(document).ready(function() {
            // ======================================================================
            // PERBAIKAN FUNGSI TAMBAH KE KERANJANG PADA PRODUK TERKAIT
            // ======================================================================

            // Ambil data produk untuk cek stok
            $.ajax({
                url: `/api/product/${productId}/check-stock`,
                type: 'GET',
                success: function(response) {
                    // Jika tidak ada API endpoint untuk cek stok, bisa menggunakan quantity dari form
                    const availableStock = response ? response.available_stock : 1;

                    if (availableStock <= 0) {
                        // Tampilkan notifikasi stok kosong
                        showCartNotification(`Stok produk ${productName} tidak tersedia.`,
                            false);
                        return;
                    }

                    // Lanjutkan dengan tambah ke keranjang jika stok tersedia
                    $.ajax({
                        url: '/cart/add',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                // Update jumlah item di cart navbar
                                $('.js-cart-items-count').text(response
                                    .cartCount);

                                // Tampilkan notifikasi sukses
                                showCartNotification(
                                    `${productName} berhasil ditambahkan ke keranjang Anda.`,
                                    true);
                            } else {
                                showCartNotification(response.message ||
                                    'Gagal menambahkan produk ke keranjang',
                                    false);
                            }
                        },
                        error: function(xhr) {
                            let errorMsg =
                                'Gagal menambahkan produk ke keranjang';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            showCartNotification(errorMsg, false);
                        }
                    });
                },
                error: function() {
                    // Jika endpoint cek stok tidak ada, langsung lakukan tambah ke keranjang
                    addToCartWithoutStockCheck(formData, productName);
                }
            });
        });

        // Fungsi tambah ke keranjang tanpa cek stok (fallback)
        function addToCartWithoutStockCheck(formData, productName) {
            $.ajax({
                url: '/cart/add',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Update jumlah item di cart navbar
                        $('.js-cart-items-count').text(response.cartCount);

                        // Tampilkan notifikasi sukses
                        showCartNotification(
                            `${productName} berhasil ditambahkan ke keranjang Anda.`, true);
                    } else {
                        showCartNotification(response.message ||
                            'Gagal menambahkan produk ke keranjang', false);
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Gagal menambahkan produk ke keranjang';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    showCartNotification(errorMsg, false);
                }
            });
        }

        // ======================================================================
        // PERBAIKAN FUNGSI WISHLIST PADA PRODUK TERKAIT
        // ======================================================================

        // Fungsi untuk menangani klik pada ikon wishlist produk terkait
        $('.pc__btn-wl').on('click', function(e) {
            e.preventDefault();

            const productCard = $(this).closest('.product-card');
            const productId = productCard.find('input[name="id"]').val();
            const productName = productCard.find('input[name="name"]').val();
            const productPrice = productCard.find('input[name="price"]').val();

            // Cek apakah sudah di wishlist (berdasarkan class)
            const isInWishlist = $(this).hasClass('in-wishlist');

            if (isInWishlist) {
                // Jika sudah di wishlist, hapus dari wishlist
                removeFromWishlist(this);
            } else {
                // Jika belum di wishlist, tambahkan ke wishlist
                addToWishlist(this, productId, productName, productPrice);
            }
        });

        // Fungsi untuk menambahkan ke wishlist
        function addToWishlist(button, productId, productName, productPrice) {
            const data = {
                id: productId,
                name: productName,
                price: productPrice,
                quantity: 1,
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: '/wishlist/add',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Update tampilan button
                        $(button).addClass('in-wishlist');
                        $(button).find('svg').attr('fill', '#e53935').removeAttr('stroke');

                        // Tambahkan animasi detak jantung
                        $(button).find('svg').addClass('heart-beat');
                        setTimeout(function() {
                            $(button).find('svg').removeClass('heart-beat');
                        }, 800);

                        // Update counter wishlist di navbar
                        $('.js-wishlist-items-count').text(response.count || parseInt($(
                            '.js-wishlist-items-count').text()) + 1);

                        // Tampilkan notifikasi
                        showFavoritNotification(
                            'Produk berhasil ditambahkan ke daftar favorit Anda.', true);
                    } else {
                        if (response.redirect) {
                            // Jika perlu login terlebih dahulu
                            window.location.href = response.redirect;
                        } else {
                            showFavoritNotification(response.message ||
                                'Gagal menambahkan ke favorit', false);
                        }
                    }
                },
                error: function(xhr) {
                    // Tampilkan pesan error
                    let errorMsg = 'Gagal menambahkan ke favorit';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }

                    // Jika perlu login, arahkan ke halaman login
                    if (xhr.status === 401) {
                        window.location.href = '/login';
                    } else {
                        showFavoritNotification(errorMsg, false);
                    }
                }
            });
        }

        // Fungsi untuk menghapus dari wishlist
        function removeFromWishlist(button) {
            const productCard = $(button).closest('.product-card');
            const productId = productCard.find('input[name="id"]').val();

            // Dapatkan rowId dari wishlist item
            $.ajax({
                url: '/wishlist',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const wishlistItems = response.items || [];

                    // Cari item dengan product_id yang sama
                    const item = wishlistItems.find(item => item.id === productId);

                    if (item && item.rowId) {
                        // Hapus dari wishlist menggunakan rowId
                        $.ajax({
                            url: `/wishlist/remove/${item.rowId}`,
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    // Update tampilan button
                                    $(button).removeClass('in-wishlist');
                                    $(button).find('svg').attr('fill', 'none').attr(
                                        'stroke', '#555');

                                    // Update counter wishlist di navbar
                                    const currentCount = parseInt($(
                                        '.js-wishlist-items-count').text());
                                    $('.js-wishlist-items-count').text(response.count ||
                                        Math.max(0, currentCount - 1));

                                    // Tampilkan notifikasi
                                    showFavoritNotification(
                                        'Produk berhasil dihapus dari daftar favorit Anda.',
                                        false);
                                } else {
                                    showFavoritNotification(response.message ||
                                        'Gagal menghapus dari favorit', false);
                                }
                            },
                            error: function(xhr) {
                                let errorMsg = 'Gagal menghapus dari favorit';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMsg = xhr.responseJSON.message;
                                }
                                showFavoritNotification(errorMsg, false);
                            }
                        });
                    } else {
                        // Fallback jika rowId tidak ditemukan
                        directRemoveFromWishlist(button, productId);
                    }
                },
                error: function() {
                    // Fallback jika endpoint tidak tersedia
                    directRemoveFromWishlist(button, productId);
                }
            });
        }

        // Fungsi fallback untuk menghapus dari wishlist
        function directRemoveFromWishlist(button, productId) {
            // Langsung update UI
            $(button).removeClass('in-wishlist');
            $(button).find('svg').attr('fill', 'none').attr('stroke', '#555');

            // Update counter wishlist di navbar
            const currentCount = parseInt($('.js-wishlist-items-count').text());
            $('.js-wishlist-items-count').text(Math.max(0, currentCount - 1));

            // Tampilkan notifikasi
            showFavoritNotification('Produk berhasil dihapus dari daftar favorit Anda.', false);
        }

        // ======================================================================
        // FUNGSI NOTIFIKASI
        // ======================================================================

        // Fungsi untuk menampilkan notifikasi keranjang
        function showCartNotification(message, isSuccess = true) {
            const notification = $('#cart-notification');
            const title = $('#cart-notification-title');
            const messageEl = $('#cart-notification-message');

            // Set konten
            messageEl.text(message);

            // Set tipe (success atau error)
            if (isSuccess) {
                notification.removeClass('error').addClass('success');
                title.text('Ditambahkan ke Keranjang');
                $('.cart-notification__icon i').removeClass('fa-exclamation-circle').addClass(
                    'fa-shopping-cart');
            } else {
                notification.removeClass('success').addClass('error');
                title.text('Gagal Ditambahkan');
                $('.cart-notification__icon i').removeClass('fa-shopping-cart').addClass(
                    'fa-exclamation-circle');
            }

            // Tampilkan notifikasi
            notification.css('display', 'flex').addClass('show');

            // Auto hide setelah 3 detik
            setTimeout(() => {
                notification.removeClass('show');
                setTimeout(() => notification.css('display', 'none'), 300);
            }, 3000);
        }

        // Fungsi untuk menampilkan notifikasi favorit
        function showFavoritNotification(message, isSuccess = true) {
            // Cek apakah notifikasi sudah ada, jika belum tambahkan ke body
            if (!$('#favorit-notification').length) {
                $('body').append(`
                <div class="favorit-notification" id="favorit-notification">
                    <div class="favorit-notification__icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="favorit-notification__content">
                        <div class="favorit-notification__title" id="favorit-notification-title">Ditambahkan ke Favorit</div>
                        <div class="favorit-notification__message" id="favorit-notification-message"></div>
                    </div>
                    <button class="favorit-notification__close" id="close-favorit-notification">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `);

                // Tambahkan event handler untuk tombol close
                $(document).on('click', '#close-favorit-notification', function() {
                    $('#favorit-notification').removeClass('show');
                    setTimeout(function() {
                        $('#favorit-notification').css('display', 'none');
                    }, 300);
                });
            }

            const notification = $('#favorit-notification');
            const title = $('#favorit-notification-title');
            const messageEl = $('#favorit-notification-message');

            // Set konten
            messageEl.text(message);

            // Set tipe (success atau error)
            if (isSuccess) {
                notification.removeClass('removed').addClass('success');
                title.text('Ditambahkan ke Favorit');
                $('.favorit-notification__icon i').removeClass('fa-trash').addClass('fa-heart');
            } else {
                notification.removeClass('success').addClass('removed');
                title.text('Dihapus dari Favorit');
                $('.favorit-notification__icon i').removeClass('fa-heart').addClass('fa-trash');
            }

            // Tampilkan notifikasi
            notification.css('display', 'flex').addClass('show');

            // Auto hide setelah 3 detik
            setTimeout(function() {
                notification.removeClass('show');
                setTimeout(function() {
                    notification.css('display', 'none');
                }, 300);
            }, 3000);
        }

        // ======================================================================
        // INISIALISASI OTOMATIS - PENGECEKAN STATUS WISHLIST PRODUK TERKAIT
        // ======================================================================

        // Cek produk mana yang sudah ada di wishlist dan update tampilannya
        function initializeWishlistUI() {
            // Ambil data wishlist dari API atau localStorage jika ada
            $.ajax({
                url: '/wishlist/count',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.count > 0) {
                        // Jika ada item di wishlist, cek detail item
                        $.ajax({
                            url: '/wishlist',
                            type: 'GET',
                            dataType: 'json',
                            success: function(wishlistResponse) {
                                const wishlistItems = wishlistResponse.items || [];
                                const wishlistProductIds = wishlistItems.map(item =>
                                    item.id);

                                // Update tampilan ikon wishlist berdasarkan status
                                $('.product-card').each(function() {
                                    const productId = $(this).find(
                                        'input[name="id"]').val();

                                    if (wishlistProductIds.includes(
                                            productId)) {
                                        // Produk ada di wishlist
                                        const wishlistButton = $(this).find(
                                            '.pc__btn-wl');
                                        wishlistButton.addClass('in-wishlist');
                                        wishlistButton.find('svg').attr('fill',
                                            '#e53935').removeAttr('stroke');
                                    }
                                });
                            }
                        });
                    }
                }
            });
        }

        // Panggil inisialisasi
        initializeWishlistUI();
        });
    </script>

    <!-- Functionality to handle size selection error -->
    <script>
        $(document).ready(function() {
            // Cek apakah ada parameter size_required di URL
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('size_required') === '1') {
                // Tampilkan notifikasi error ukuran
                $('#size-error').removeClass('d-none');

                // Scroll ke bagian ukuran
                if ($("#size-buttons").length) {
                    $('html, body').animate({
                        scrollTop: $("#size-buttons").offset().top - 100
                    }, 500);
                }

                // Hapus parameter dari URL setelah ditampilkan
                if (window.history.replaceState) {
                    const newUrl = window.location.href.split('?')[0];
                    window.history.replaceState({}, '', newUrl);
                }
            }
        });
    </script>
@endpush
