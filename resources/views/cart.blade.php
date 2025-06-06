@extends('layouts.app')

@section('content')

    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title mb-4" style="letter-spacing:1px; margin-bottom: 3.5rem !important;">Keranjang</h2>

            <div class="shopping-cart">
                @if ($cartItems->count() > 0)
                    <div class="cart-table__wrapper">
                        <div class="select-all-container mb-3">
                            <input type="checkbox" id="select-all" class="cart-checkbox" checked>
                            <label for="select-all">Pilih Semua Produk</label>
                        </div>

                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th style="width: 5%"></th>
                                    <th style="width: 15%">Produk</th>
                                    <th style="width: 25%"></th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Sub Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $cartItem)
                                    <tr class="cart-item-row" data-row-id="{{ $cartItem->rowId }}"
                                        data-price="{{ $cartItem->price }}" data-qty="{{ $cartItem->qty }}">
                                        <td>
                                            <input type="checkbox" class="cart-checkbox item-checkbox"
                                                name="selected_items[]" value="{{ $cartItem->rowId }}" checked
                                                data-price="{{ $cartItem->price }}" data-qty="{{ $cartItem->qty }}"
                                                data-subtotal="{{ $cartItem->subtotal(0, '', '') }}">
                                        </td>
                                        <td>
                                            <div class="shopping-cart__product-item">
                                                <img loading="lazy"
                                                    src="{{ asset('uploads/products/thumbnails') }}/{{ $cartItem->model->image }}"
                                                    width="120" height="120" alt="{{ $cartItem->name }}" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="shopping-cart__product-item__detail">
                                                <h4>{{ $cartItem->name }}</h4>
                                                @if (isset($cartItem->options['size_name']))
                                                    <div class="product-size-badge">
                                                        <i class="fas fa-ruler-combined me-1"></i>
                                                        Ukuran: {{ $cartItem->options['size_name'] }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="shopping-cart__product-price">{{ formatRupiah($cartItem->price) }}</span>
                                        </td>
                                        <td>
                                            <div class="qty-control position-relative">
                                                <input type="number" name="quantity" value="{{ $cartItem->qty }}"
                                                    min="1" class="qty-control__number text-center qty-input"
                                                    data-row-id="{{ $cartItem->rowId }}">
                                                <form method="POST"
                                                    action="{{ route('cart.reduce.qty', ['rowId' => $cartItem->rowId]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="qty-control__reduce">-</div>
                                                </form>
                                                <form method="POST"
                                                    action="{{ route('cart.increase.qty', ['rowId' => $cartItem->rowId]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="qty-control__increase">+</div>
                                                </form>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="shopping-cart__subtotal">
                                                {{ formatRupiah($cartItem->subtotal(0, '', '')) }}
                                            </span>
                                        </td>
                                        <td>
                                            <form method="POST"
                                                action="{{ route('cart.remove', ['rowId' => $cartItem->rowId]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:void(0)" class="remove-cart">
                                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                                        <path
                                                            d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                                    </svg>
                                                </a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="cart-table-footer">
                            @if (!Session::has('coupon'))
                                <form class="position-relative bg-body" method="POST"
                                    action="{{ route('cart.coupon.apply') }}">
                                    @csrf
                                    <input class="form-control" type="text" name="coupon_code"
                                        placeholder="Masukkan Kupon Diskon">
                                    <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4"
                                        type="submit"
                                        style="background-color: #956a3b; border-color: #956a3b; color: #ffffff;"
                                        value="TERAPKAN KUPON">
                                </form>
                            @else
                                <form class="position-relative bg-body" method="POST"
                                    action="{{ route('cart.coupon.remove') }}">
                                    @csrf
                                    @method('DELETE')
                                    <input class="form-control text-success fw-bold" type="text" name="coupon_code"
                                        placeholder="Kupon Diskon"
                                        value="{{ session()->get('coupon')['code'] }} diterapkan!" readonly>
                                    <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4 text-danger"
                                        type="submit" value="HAPUS KUPON">
                                </form>
                            @endif
                            <form class="position-relative bg-body" method="POST" action="{{ route('cart.empty') }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-light" type="submit">KOSONGKAN KERANJANG</button>
                            </form>
                        </div>

                        <div>
                            @if (Session::has('success'))
                                <p class="text-success">{{ Session::get('success') }}</p>
                            @elseif(Session::has('error'))
                                <p class="text-danger">{{ Session::get('error') }}</p>
                            @endif
                        </div>

                    </div>
                    <div class="shopping-cart__totals-wrapper">
                        <div class="sticky-content">
                            <div class="shopping-cart__totals">
                                <h3>Detail Pembayaran</h3>

                                <table class="cart-totals">
                                    <tbody>
                                        <tr>
                                            <th>Subtotal</th>
                                            <td id="cart-subtotal">
                                                {{ formatRupiah(\Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->subtotal(0, '', '')) }}
                                            </td>
                                        </tr>
                                        @if (Session::has('discounts'))
                                            <tr>
                                                <th>Diskon {{ Session('coupon')['code'] }}</th>
                                                <td id="cart-discount">
                                                    -{{ formatRupiah((float) Session('discounts')['discount']) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Subtotal Setelah Diskon</th>
                                                <td id="cart-subtotal-after-discount">
                                                    {{ formatRupiah((float) Session('discounts')['subtotal']) }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th>Ongkos Kirim</th>
                                            <td class="shipping-cost">
                                                <div class="shipping-info">
                                                    <span>DIHITUNG KETIKA MELANJUTKAN PEMBAYARAN</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="cart-total">
                                            <th>Total</th>
                                            <td id="cart-total">
                                                @if (Session::has('discounts'))
                                                    {{ formatRupiah((float) Session('discounts')['subtotal']) }}
                                                @else
                                                    {{ formatRupiah(\Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->subtotal(0, '', '')) }}
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mobile_fixed-btn_wrapper">
                                <div class="button-wrapper container">
                                    <form id="checkout-form" action="{{ route('cart.checkout') }}" method="GET">
                                        <input type="hidden" name="selected_items" id="selected-items-input">
                                        <button type="submit" class="btn btn-primary btn-checkout text-white w-100"
                                            id="checkout-btn"
                                            style="background-color: #956a3b; border-color: #956a3b; color: #ffffff;">
                                            LANJUTKAN KE PEMBAYARAN
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Simple Empty Cart Design -->
                    <div class="empty-cart-elegant">
                        <div class="empty-cart-content">

                            <h3 class="empty-cart-title">Keranjang Belanja Kosong</h3>

                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>

    @push('scripts')
        <script>
            $(function() {
                // Update cart totals when checkboxes or quantities change
                function updateCartTotals() {
                    let subtotal = 0;
                    let selectedItems = [];

                    // Calculate totals based on selected items
                    $('.item-checkbox:checked').each(function() {
                        const rowId = $(this).val();
                        const price = parseFloat($(this).data('price'));
                        const qty = parseInt($(this).closest('tr').find('.qty-input').val());
                        const itemSubtotal = price * qty;

                        subtotal += itemSubtotal;
                        selectedItems.push(rowId);
                    });

                    // Update the hidden input with selected items
                    $('#selected-items-input').val(JSON.stringify(selectedItems));

                    // Format the number to currency
                    const formattedSubtotal = formatRupiah(subtotal);
                    $('#cart-subtotal').text(formattedSubtotal);

                    // If there's a coupon, recalculate discount
                    @if (Session::has('discounts'))
                        const discount = calculateDiscount(subtotal);
                        const subtotalAfterDiscount = subtotal - discount;

                        $('#cart-discount').text('-' + formatRupiah(discount));
                        $('#cart-subtotal-after-discount').text(formatRupiah(subtotalAfterDiscount));
                        $('#cart-total').text(formatRupiah(subtotalAfterDiscount));
                    @else
                        $('#cart-total').text(formattedSubtotal);
                    @endif

                    // Apply visual dimming to unselected items
                    $('.cart-item-row').each(function() {
                        const isChecked = $(this).find('.item-checkbox').is(':checked');
                        $(this).toggleClass('dimmed', !isChecked);
                    });

                    // Disable checkout button if no items selected
                    if (selectedItems.length === 0) {
                        $('#checkout-btn').prop('disabled', true).css('opacity', '0.5');
                    } else {
                        $('#checkout-btn').prop('disabled', false).css('opacity', '1');
                    }
                }


                // Format number to Rupiah
                function formatRupiah(number) {
                    return 'Rp' + number.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                }

                // Select/deselect all items
                $('#select-all').on('change', function() {
                    const isChecked = $(this).is(':checked');
                    $('.item-checkbox').prop('checked', isChecked);
                    updateCartTotals();
                });

                // Individual item selection
                $('.item-checkbox').on('change', function() {
                    // Update "select all" checkbox based on individual selections
                    if ($('.item-checkbox:checked').length === $('.item-checkbox').length) {
                        $('#select-all').prop('checked', true);
                    } else {
                        $('#select-all').prop('checked', false);
                    }

                    updateCartTotals();
                });

                // Update totals when quantity changes
                $('.qty-input').on('change', function() {
                    const rowId = $(this).data('row-id');
                    const newQty = $(this).val();

                    // Update the cart via AJAX
                    $.ajax({
                        url: '{{ url('/cart/update-qty') }}/' + rowId,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'PUT',
                            quantity: newQty
                        },
                        success: function(response) {
                            // Update subtotal display for this item
                            const price = parseFloat($(`tr[data-row-id="${rowId}"]`).data('price'));
                            const newSubtotal = price * newQty;
                            $(`tr[data-row-id="${rowId}"] .shopping-cart__subtotal`).text(
                                formatRupiah(newSubtotal));

                            // Update checkbox data attribute
                            $(`input[value="${rowId}"]`).data('qty', newQty);
                            $(`input[value="${rowId}"]`).data('subtotal', newSubtotal);

                            updateCartTotals();
                        }
                    });
                });

                // Handle quantity buttons
                $(".qty-control__increase").on("click", function() {
                    const input = $(this).closest('td').find('.qty-input');
                    input.val(parseInt(input.val()) + 1).trigger('change');

                    // Don't submit the form as we're handling it via AJAX
                    return false;
                });

                $(".qty-control__reduce").on("click", function() {
                    const input = $(this).closest('td').find('.qty-input');
                    const newVal = Math.max(1, parseInt(input.val()) - 1);
                    input.val(newVal).trigger('change');

                    // Don't submit the form as we're handling it via AJAX
                    return false;
                });

                // Handle remove item
                $('.remove-cart').on("click", function() {
                    $(this).closest('form').submit();
                });

                // Initialize totals on page load
                updateCartTotals();

                // Form submit handler for checkout
                $('#checkout-form').on('submit', function(e) {
                    const selectedItems = $('.item-checkbox:checked').length;
                    if (selectedItems === 0) {
                        e.preventDefault();
                        alert('Silakan pilih setidaknya satu produk untuk checkout');
                    }
                });
            });
        </script>

        <script>
            $(function() {
                // Function to show notification
                function showCartNotification(message, isSuccess = true) {
                    // Cek apakah notifikasi sudah ada, jika belum tambahkan ke body
                    if (!$('#cart-notification-simple').length) {
                        $('body').append(`
                    <div class="cart-notification" id="cart-notification-simple" style="display: none;">
                        <div class="cart-notification__icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="cart-notification__content">
                            <div class="cart-notification__title" id="cart-notification-title-simple">Notifikasi</div>
                            <div class="cart-notification__message" id="cart-notification-message-simple"></div>
                        </div>
                        <button class="cart-notification__close" id="close-cart-notification-simple">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `);

                        // Event handler untuk tombol close
                        $(document).on('click', '#close-cart-notification-simple', function() {
                            $('#cart-notification-simple').removeClass('show');
                            setTimeout(() => $('#cart-notification-simple').css('display', 'none'), 300);
                        });
                    }

                    const notification = $('#cart-notification-simple');
                    const title = $('#cart-notification-title-simple');
                    const messageEl = $('#cart-notification-message-simple');

                    // Set content
                    messageEl.text(message);

                    // Set type (success or error)
                    if (isSuccess) {
                        notification.removeClass('error').addClass('success');
                        title.text('Berhasil');
                        $('.cart-notification__icon i').removeClass('fa-exclamation-circle').addClass(
                            'fa-check-circle');
                    } else {
                        notification.removeClass('success').addClass('error');
                        title.text('Error');
                        $('.cart-notification__icon i').removeClass('fa-check-circle').addClass(
                            'fa-exclamation-circle');
                    }

                    // Show notification
                    notification.css('display', 'flex').addClass('show');

                    // Auto hide after 4 seconds
                    setTimeout(() => {
                        notification.removeClass('show');
                        setTimeout(() => notification.css('display', 'none'), 300);
                    }, 4000);
                }

                // Update cart totals when checkboxes or quantities change
                function updateCartTotals() {
                    let subtotal = 0;
                    let selectedItems = [];

                    // Calculate totals based on selected items
                    $('.item-checkbox:checked').each(function() {
                        const rowId = $(this).val();
                        const price = parseFloat($(this).data('price'));
                        const qty = parseInt($(this).closest('tr').find('.qty-input').val());
                        const itemSubtotal = price * qty;

                        subtotal += itemSubtotal;
                        selectedItems.push(rowId);
                    });

                    // Update the hidden input with selected items
                    $('#selected-items-input').val(JSON.stringify(selectedItems));

                    // Format the number to currency
                    const formattedSubtotal = formatRupiah(subtotal);
                    $('#cart-subtotal').text(formattedSubtotal);

                    // If there's a coupon, recalculate discount
                    @if (Session::has('discounts'))
                        const discount = calculateDiscount(subtotal);
                        const subtotalAfterDiscount = subtotal - discount;

                        $('#cart-discount').text('-' + formatRupiah(discount));
                        $('#cart-subtotal-after-discount').text(formatRupiah(subtotalAfterDiscount));
                        $('#cart-total').text(formatRupiah(subtotalAfterDiscount));
                    @else
                        $('#cart-total').text(formattedSubtotal);
                    @endif

                    // Apply visual dimming to unselected items
                    $('.cart-item-row').each(function() {
                        const isChecked = $(this).find('.item-checkbox').is(':checked');
                        $(this).toggleClass('dimmed', !isChecked);
                    });

                    // Disable checkout button if no items selected
                    if (selectedItems.length === 0) {
                        $('#checkout-btn').prop('disabled', true).css('opacity', '0.5');
                    } else {
                        $('#checkout-btn').prop('disabled', false).css('opacity', '1');
                    }
                }

                // Calculate discount based on coupon
                function calculateDiscount(subtotal) {
                    @if (Session::has('coupon'))
                        const discountAmount = parseFloat("{{ Session::get('coupon')['discount_amount'] }}");
                        // Pastikan diskon tidak melebihi subtotal
                        return Math.min(discountAmount, subtotal);
                    @else
                        return 0;
                    @endif
                }

                // Format number to Rupiah
                function formatRupiah(number) {
                    return 'Rp' + number.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                }

                // Select/deselect all items
                $('#select-all').on('change', function() {
                    const isChecked = $(this).is(':checked');
                    $('.item-checkbox').prop('checked', isChecked);
                    updateCartTotals();
                });

                // Individual item selection
                $('.item-checkbox').on('change', function() {
                    // Update "select all" checkbox based on individual selections
                    if ($('.item-checkbox:checked').length === $('.item-checkbox').length) {
                        $('#select-all').prop('checked', true);
                    } else {
                        $('#select-all').prop('checked', false);
                    }

                    updateCartTotals();
                });

                // PERBAIKAN: Update totals when quantity changes dengan validasi stok
                $('.qty-input').on('change', function() {
                    const rowId = $(this).data('row-id');
                    const newQty = parseInt($(this).val());
                    const $this = $(this);

                    // Validasi minimum quantity
                    if (newQty < 1) {
                        $(this).val(1);
                        return;
                    }

                    // Update the cart via AJAX dengan validasi stok
                    $.ajax({
                        url: '{{ url('/cart/update-qty') }}/' + rowId,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'PUT',
                            quantity: newQty
                        },
                        success: function(response) {
                            if (response.success) {
                                // Update subtotal display for this item
                                const price = parseFloat($(`tr[data-row-id="${rowId}"]`).data(
                                    'price'));
                                const newSubtotal = price * newQty;
                                $(`tr[data-row-id="${rowId}"] .shopping-cart__subtotal`).text(
                                    formatRupiah(newSubtotal));

                                // Update checkbox data attribute
                                $(`input[value="${rowId}"]`).data('qty', newQty);
                                $(`input[value="${rowId}"]`).data('subtotal', newSubtotal);

                                updateCartTotals();
                            } else {
                                // Jika gagal, kembalikan ke nilai sebelumnya dan tampilkan error
                                showCartNotification(response.message, false);

                                // Jika ada max_quantity dari response, set ke nilai maksimum
                                if (response.max_quantity) {
                                    $this.val(response.max_quantity);
                                    $this.trigger(
                                        'change'); // Trigger change dengan nilai yang benar
                                } else {
                                    // Kembalikan ke nilai sebelumnya
                                    const previousQty = $this.data('previous-qty') || 1;
                                    $this.val(previousQty);
                                }
                            }
                        },
                        error: function(xhr) {
                            let errorMsg = 'Gagal mengupdate kuantitas';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            showCartNotification(errorMsg, false);

                            // Kembalikan ke nilai sebelumnya
                            const previousQty = $this.data('previous-qty') || 1;
                            $this.val(previousQty);
                        }
                    });
                });

                // PERBAIKAN: Handle quantity buttons dengan mencegah form submit dan validasi stok
                $(".qty-control__increase").off('click').on("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const $input = $(this).closest('td').find('.qty-input');
                    const currentQty = parseInt($input.val());
                    const newQty = currentQty + 1;

                    // Simpan nilai sebelumnya untuk rollback jika gagal
                    $input.data('previous-qty', currentQty);

                    // Update input value dan trigger change untuk validasi
                    $input.val(newQty).trigger('change');

                    return false; // Prevent form submission
                });

                $(".qty-control__reduce").off('click').on("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const $input = $(this).closest('td').find('.qty-input');
                    const currentQty = parseInt($input.val());
                    const newQty = Math.max(1, currentQty - 1);

                    // Simpan nilai sebelumnya untuk rollback jika gagal
                    $input.data('previous-qty', currentQty);

                    // Update input value dan trigger change untuk validasi
                    $input.val(newQty).trigger('change');

                    return false; // Prevent form submission
                });

                // TAMBAHAN: Prevent form submission untuk quantity forms
                $('.qty-control form').on('submit', function(e) {
                    e.preventDefault();
                    return false;
                });

                // Handle remove item
                $('.remove-cart').on("click", function() {
                    $(this).closest('form').submit();
                });

                // Initialize totals on page load
                updateCartTotals();

                // Form submit handler for checkout
                $('#checkout-form').on('submit', function(e) {
                    const selectedItems = $('.item-checkbox:checked').length;
                    if (selectedItems === 0) {
                        e.preventDefault();
                        alert('Silakan pilih setidaknya satu produk untuk checkout');
                    }
                });

                // TAMBAHAN: Simpan nilai awal quantity untuk rollback
                $('.qty-input').each(function() {
                    $(this).data('previous-qty', parseInt($(this).val()));
                });
            });
        </script>
    @endpush
@endsection
