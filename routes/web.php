<?php

use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\PenjadwalanPenjemputan;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ChatbotAIController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\RajaOngkirController;
use App\Http\Controllers\StokBahanBakuController;
use App\Http\Controllers\SupplierRequestController;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\PenjadwalanPenjemputanController;


// =====================================================================================================================================================================================================
// -------------------------------------------------------------------------------------------- AUTH --------------------------------------------------------------------------------------------
// =====================================================================================================================================================================================================
// Route untuk login dan logout integrasi Google
Auth::routes();
// Route untuk login dan logout
Route::get('oauth/google', [OAuthController::class, 'redirectToGoogle'])->name('oauth.google');
// Route untuk callback setelah login dengan Google
Route::get('oauth/google/callback', [OAuthController::class, 'handleGoogleCallback'])->name('oauth.google.callback');


// ====================================================================================================
// Api RajaOngkir
// ====================================================================================================
Route::get('/api/rajaongkir/provinces', 'RajaOngkirController@getProvinces');
// Route untuk mendapatkan kota berdasarkan ID provinsi
Route::get('/api/rajaongkir/cities/{province_id}', 'RajaOngkirController@getCities');
// Route untuk mendapatkan ongkos kirim berdasarkan kota asal, kota tujuan, dan berat
Route::post('/api/rajaongkir/calculate', 'RajaOngkirController@calculateShipping');
// Route untuk verifikasi origin city (opsional - untuk testing)
Route::get('rajaongkir/origin-info', [RajaOngkirController::class, 'getOriginCityInfo']);


// ====================================================================================================
// Halaman Verifikasi Email
// ====================================================================================================
Route::post('/verification/send', [App\Http\Controllers\Auth\EmailVerificationController::class, 'sendVerificationCode'])->name('verification.send');
// Rute untuk menampilkan form verifikasi email
Route::get('/verification/form', [App\Http\Controllers\Auth\EmailVerificationController::class, 'showVerificationForm'])->name('verification.form');
// Rute untuk memverifikasi kode yang dikirimkan ke email
Route::post('/verification/verify-code', [App\Http\Controllers\Auth\EmailVerificationController::class, 'verifyCode'])->name('verification.verify-code');
// Rute untuk mengirim ulang kode verifikasi
Route::get('/verification/resend', [App\Http\Controllers\Auth\EmailVerificationController::class, 'resendVerificationCode'])->name('verification.resend');


// =====================================================================================================================================================================================================
// -------------------------------------------------------------------------------------------- ChatBot AI --------------------------------------------------------------------------------------------
// =====================================================================================================================================================================================================
Route::get('/chat-widget', [ChatbotAIController::class, 'chat'])->name("components.chat-widget");


// =====================================================================================================================================================================================================
// -------------------------------------------------------------------------------------------- PENGUNJUNG ---------------------------------------------------------------------------------------------
// =====================================================================================================================================================================================================
Route::get('/', [HomeController::class, 'index'])->name('home.index');


// ====================================================================================================
// Halaman Produk
// ====================================================================================================
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
// Halaman Produk Detail
Route::get('/shop/{product_slug}', [ShopController::class, 'product_details'])->name("shop.product.details");


// ====================================================================================================
// Halaman Keranjang
// ====================================================================================================
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
// Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.store');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
// Route untuk menambahkan item di keranjang
Route::put('/cart/increase-qunatity/{rowId}', [CartController::class, 'increase_item_quantity'])->name('cart.increase.qty');
// Route untuk mengurangi item di keranjang
Route::put('/cart/reduce-qunatity/{rowId}', [CartController::class, 'reduce_item_quantity'])->name('cart.reduce.qty');
// Route untuk menghapus item di keranjang
Route::delete('/cart/remove/{rowId}', [CartController::class, 'remove_item_from_cart'])->name('cart.remove');
// Route untuk mengosongkan keranjang
Route::delete('/cart/clear', [CartController::class, 'empty_cart'])->name('cart.empty');
// Route untuk menghitung diskon
Route::post('/cart/apply-coupon', [CartController::class, 'apply_coupon_code'])->name('cart.coupon.apply');
// Route untuk menghapus diskon
Route::delete('/cart/remove-coupon', [CartController::class, 'remove_coupon_code'])->name('cart.coupon.remove');
// Route menambah
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
// route untuk menangani update kuantitas via AJAX
Route::put('/cart/update-qty/{rowId}', [CartController::class, 'update_item_quantity'])->name('cart.update.qty');
// buat route untuk menangani checkout dengan item terpilih
Route::post('/checkout-selected', [CartController::class, 'checkoutSelected'])->name('cart.checkout.selected');
// Route menambah item ke keranjang
Route::middleware(['auth'])->group(function () {
    Route::get('/auth/redirect', function () {
        if (Session::has('redirect_after_login')) {
            $redirect = Session::get('redirect_after_login');
            Session::forget('redirect_after_login');
            return redirect($redirect);
        }

        return redirect('/');
    })->name('auth.redirect');
});
Route::post('/cart/validate-stock', [CartController::class, 'validate_stock'])->name('cart.validate.stock');
Route::put('/cart/update-qty/{rowId}', [CartController::class, 'update_item_quantity'])->name('cart.update.qty');


// ====================================================================================================
// Route untuk Wishlist
// ====================================================================================================
// Route untuk menambahkan Wishlist
Route::post('/wishlist/add', [WishlistController::class, 'add_to_wishlist'])->name('wishlist.add');
// Route for getting wishlist count (AJAX)
Route::get('/wishlist/count', [WishlistController::class, 'getWishlistCount'])->name('wishlist.count');


// ====================================================================================================
// Route untuk Checkout/Order
// ====================================================================================================
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
// Route untuk menyimpan order
Route::post('/place-order', [CartController::class, 'place_order'])->name('cart.place.order');
// Route untuk menampilkan order confirmation
Route::get('/order-confirmation', [CartController::class, 'confirmation'])->name('cart.confirmation');
// Route untuk upload bukti pembayaran transfer bank
Route::post('/upload-payment-proof', [CartController::class, 'uploadPaymentProof'])->name('upload.payment.proof');
// Route untuk menampilkan halaman pembayaran
Route::get('/account-orders', [CartController::class, 'accountOrders'])->name('account-orders')->middleware('auth');
// Route untuk menampilkan detail order
Route::post('/upload-payment-proof', [CartController::class, 'uploadPaymentProof'])->name('upload.payment.proof');
// Route untuk memeriksa status pembayaran
Route::get('/check-payment-status/{transaction_id}', [UserController::class, 'checkPaymentStatus'])->name('check.payment.status');
 // Route untuk manual refresh status (debugging)
 Route::post('/manual-refresh-status', [UserController::class, 'manualRefreshStatus'])->name('manual.refresh.status');
//  Route untuk auto check payment status
Route::post('/auto-check-payment-status', [UserController::class, 'autoCheckPaymentStatus'])->name('auto.check.payment.status');


// ====================================================================================================
// Halaman Kontak
// ====================================================================================================
Route::get('/contact-us', [HomeController::class, 'contact'])->name('home.contact.index');


// ====================================================================================================
// Halaman Lowongan Pekerjaan
// ====================================================================================================
Route::get('/job-vacancy', function () {
    return view('user.job_vacancy.index');
})->name('job-vacancy');


// ====================================================================================================
// Halaman Req Pemasok user - Override to include supplier info
// ====================================================================================================
Route::get('/supplier', [SupplierRequestController::class, 'getSupplierInfo'])->name('supplier.index');

// ====================================================================================================
// Halaman Req Pemasok user - Override to total penjemputan
// ====================================================================================================
Route::get('/total-penjemputan', function () {
    $total = PenjadwalanPenjemputan::count();
    return $total;
});

// ====================================================================================================
// Halaman Req Pemasok user - Override to total penjemputan
// ====================================================================================================
Route::get('/total/penjemputan', function () {
    return PenjadwalanPenjemputan::count();
});


// ====================================================================================================
// Halaman Privasi dan Policy
// ====================================================================================================
Route::get('/privacy-policy', [HomeController::class, 'privacy_policy'])->name('home.privacy-policy');


// ====================================================================================================
// Halaman Terms dan Conditions
// ====================================================================================================
Route::get('/terms-conditions', [HomeController::class, 'terms_conditions'])->name('home.terms-conditions');


// ====================================================================================================
// Halaman About
// ====================================================================================================
Route::get('/about', [HomeController::class, 'about'])->name('user.about.index');


// ====================================================================================================
// Halaman Payment Midtrans
// ====================================================================================================
Route::get('/payment_success', [MidtransCallbackController::class, 'paymentSuccess'])->name('cart.payment_success');
Route::get('/payment_pending', [MidtransCallbackController::class, 'paymentPending'])->name('cart.payment_pending');


// ====================================================================================================
// function search
// ====================================================================================================
Route::get('/search', [HomeController::class, 'search'])->name('home.search');
// Route::get('/products', [HomeController::class, 'productSearch'])->name('shop.products.search');


// =====================================================================================================================================================================================================
// --------------------------------------------------------------------------------------------USER lOGIN----------------------------------------------------------------------------------------------------
// =====================================================================================================================================================================================================

Route::middleware(['auth'])->group(function () {

    // ====================================================================================================
    // Halaman Index
    // ====================================================================================================
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');


    // ====================================================================================================
    // Halaman Orders
    // ====================================================================================================
    Route::get('/account-orders', [UserController::class, 'account_orders'])->name('user.account.orders');
    // Halaman Order Details
    Route::get('/account-order-details/{order_id}', [UserController::class, 'account_order_details'])->name('user.account.order.details');
    // Route untuk menampilkan invoice
    Route::get('/order-payment/{transaction_id}', [UserController::class, 'order_payment']);
    // Route untuk cancel order
    Route::put('/account-order/cancel-order', [UserController::class, 'account_cancel_order'])->name('user.account_cancel_order');
    // Route untuk konfirmasi penerimaan pesanan
    Route::post('/account-order/confirm-delivery', [UserController::class, 'account_confirm_delivery'])->name('user.account.confirm.delivery');
    // Route untuk mengonfirmasi pembayaran
    Route::get('/account-pending-order-details/{pending_order_id}', [UserController::class, 'account_pending_order_details'])->name('user.pending.order.details');


    // ====================================================================================================
    // Reviews
    // ====================================================================================================
    Route::post('/account/reviews', [ReviewController::class, 'store'])->name('user.reviews.store');
    // Route untuk menampilkan form edit review
    Route::put('/account/reviews/{id}', [ReviewController::class, 'update'])->name('user.reviews.update');
    // Route untuk menghapus review
    Route::delete('/account/reviews/media/{id}', [ReviewController::class, 'deleteMedia'])->name('user.reviews.delete-media');


    // ====================================================================================================
    // Halaman Supplier
    // ====================================================================================================
    Route::get('/account-supplier-request', [UserController::class, 'supplier_request'])->name('user.account.supplier.request');
    // Route untuk menampilkan form supplier request
    Route::post('/supplier-request', [SupplierRequestController::class, 'store'])->name('supplier.store');


    // ====================================================================================================
    // Halaman Kontak (hanya untuk user login)
    // ====================================================================================================
    Route::post('/contact/store', [HomeController::class, 'contact_store'])->name('home.contact.store');


    // ====================================================================================================
    // Halaman Alamat (hanya untuk user login)
    // ====================================================================================================
    Route::get('/account-address', [UserController::class, 'accountAddress'])->name('user.address.account-address');


    // ====================================================================================================
    // CRUD Alamat
    // ====================================================================================================
    Route::get('/user/address/create', [UserController::class, 'addAddress'])->name('user.address.add-address');
    // Route untuk menyimpan alamat
    Route::post('/user/address/store', [UserController::class, 'storeAddress'])->name('user.address.store-address');
    // Route untuk menampilkan form edit alamat
    Route::get('/user/address/edit/{id}', [UserController::class, 'editAddress'])->name('user.address.edit-address');
    // Route untuk memperbarui alamat
    Route::put('/user/address/update/{id}', [UserController::class, 'updateAddress'])->name('user.address.update-address');
    // Route untuk menghapus alamat
    Route::delete('/user/address/delete/{id}', [UserController::class, 'deleteAddress'])->name('user.address.delete-address');
    // Route untuk mengatur alamat sebagai default
    Route::post('/user/address/set-default/{id}', [UserController::class, 'setDefaultAddress'])->name('user.address.set-default');


    // ====================================================================================================
    // Halaman Detail Akun (hanya untuk user login)
    // ====================================================================================================
    // Rute-rute lain yang sudah ada
    Route::get('/account-details', [UserController::class, 'accountDetails'])->name('user.accountdetails.account-details');
    Route::post('/update-account-details', [UserController::class, 'updateAccountDetails'])->name('user.accountdetails.update');


    // ====================================================================================================
    // Halaman Wishlist (hanya untuk user login)
    // ====================================================================================================
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    // Route untuk menghapus item di Wishlist
    Route::delete('/wishlist/remove/{rowId}', [WishlistController::class, 'remove_item_from_wishlist'])->name('wishlist.remove');
    // Route untuk mengosongkan Wishlist
    Route::delete('/wishlist/clear', [WishlistController::class, 'empty_wishlist'])->name('wishlist.empty');
    // Route untuk memindahkan item dari Wishlist ke Cart
    Route::post('/wishlist/move-to-cart/{rowId}', [WishlistController::class, 'move_to_cart'])->name('wishlist.move.to.cart');
});


// =====================================================================================================================================================================================================
// --------------------------------------------------------------------------------------------ADMIN ---------------------------------------------------------------------------------------------------
// =====================================================================================================================================================================================================

Route::middleware(['auth', AuthAdmin::class])->group(function () {

    // ====================================================================================================
    // Halaman Index
    // ====================================================================================================
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    // API untuk Chart Data (TAMBAHKAN INI)
    Route::get('/admin/chart-data', [AdminController::class, 'getChartData'])->name('admin.chart.data');


    // ====================================================================================================
    // Halaman Brands
    // ====================================================================================================
    Route::get('/admin/brands', [AdminController::class, 'brands'])->name('admin.brands');
    // Halaman Menambahkan Brand
    Route::get('/admin/brand/add', [AdminController::class, 'add_brand'])->name('admin.brand.add');
    // Halaman Menyimpan Brand
    Route::post('/admin/brand/store', [AdminController::class, 'add_brand_store'])->name('admin.brand.store');
    // Halaman Edit Brand
    Route::get('/admin/brand/edit/{id}', [AdminController::class, 'brand_edit'])->name('admin.brand.edit');
    // Halaman Update Brand
    Route::put('/admin/brand/update', [AdminController::class, 'update_brand'])->name('admin.brand.update');
    // Halaman Delete Brand
    Route::delete('/admin/brand/{id}/delete', [AdminController::class, 'delete_brand'])->name('admin.brand.delete');


    // ====================================================================================================
    // Halaman Categories
    // ====================================================================================================
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    // Halaman Menambahkan Category
    Route::get('/admin/category/add', [AdminController::class, 'add_category'])->name('admin.category.add');
    // Halaman Menyimpan Category
    Route::post('/admin/category/store', [AdminController::class, 'add_category_store'])->name('admin.category.store');
    // Halaman Edit Category
    Route::get('/admin/category/{id}/edit', [AdminController::class, 'edit_category'])->name('admin.category.edit');
    // Halaman Update Category
    Route::put('/admin/category/update', [AdminController::class, 'update_category'])->name('admin.category.update');
    // Halaman Delete Category
    Route::delete('/admin/category/{id}/delete', [AdminController::class, 'delete_category'])->name('admin.category.delete');


    // ====================================================================================================
    // Halaman Produk
    // ====================================================================================================
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    // Halaman Menambahkan Produk
    Route::get('/admin/product/add', [AdminController::class, 'add_product'])->name('admin.product.add');
    // Halaman Menyimpan Produk
    Route::post('/admin/product/store', [AdminController::class, 'product_store'])->name('admin.product.store');
    // Halaman Edit Produk
    Route::get('/admin/product/{id}/edit', [AdminController::class, 'edit_product'])->name('admin.product.edit');
    // Halaman Update Produk
    Route::put('/admin/product/update', [AdminController::class, 'update_product'])->name('admin.product.update');
    // Halaman Delete Produk
    Route::delete('/admin/product/{id}/delete', [AdminController::class, 'delete_product'])->name('admin.product.delete');
    // Nonaktifkan produk (pengganti delete)
    Route::patch('/admin/product/{id}/deactivate', [AdminController::class, 'deactivate_product'])->name('admin.product.deactivate');
    // Toggle status unggulan
    Route::patch('/admin/product/{id}/toggle-featured', [AdminController::class, 'toggle_featured'])->name('admin.product.toggle_featured');
    // Duplikasi produk
    Route::get('/admin/product/{id}/duplicate', [AdminController::class, 'duplicate_product'])->name('admin.product.duplicate');
    // Bulk actions
    Route::post('/admin/products/bulk-action', [AdminController::class, 'bulk_action_produk'])->name('admin.products.bulk_action');
    // Export produk
    Route::get('/admin/products/export', [AdminController::class, 'export_products'])->name('admin.products.export');
    // Get product detail (AJAX)
    Route::get('/admin/product/{id}/detail', [AdminController::class, 'product_detail'])->name('admin.product.detail');
    // ====================================================================================================
    // Optional: Import produk dari CSV (fitur tambahan)
    // ====================================================================================================
    Route::get('/admin/products/import', [AdminController::class, 'import_products_form'])->name('admin.products.import.form');
    Route::post('/admin/products/import', [AdminController::class, 'import_products'])->name('admin.products.import');


    // ====================================================================================================
    // Halaman Coupons
    // ====================================================================================================
    Route::get('/admin/coupons', [AdminController::class, 'coupons'])->name('admin.coupons');
    // Add Coupon
    Route::get('/admin/coupon/add', [AdminController::class, 'add_coupon'])->name('admin.coupon.add');
    // Store Coupon
    Route::post('/admin/coupon/store', [AdminController::class, 'add_coupon_store'])->name('admin.coupon.store');
    // Edit Coupon
    Route::get('/admin/coupon/{id}/edit', [AdminController::class, 'edit_coupon'])->name('admin.coupon.edit');
    // Update Coupon
    Route::put('/admin/coupon/update', [AdminController::class, 'update_coupon'])->name('admin.coupon.update');
    // Delete Coupon
    Route::delete('/admin/coupon/{id}/delete', [AdminController::class, 'delete_coupon'])->name('admin.coupon.delete');


    // ====================================================================================================
    // Halaman Orders
    // ====================================================================================================
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/admin/readall', [AdminController::class, 'readall']);
    // Halaman Order Details
    Route::get('/admin/order/items/{order_id}', [AdminController::class, 'order_items'])->name('admin.order.items');
    // Update Order Update Status
    Route::put('/admin/order/update-status', [AdminController::class, 'update_order_status'])->name('admin.order.status.update');


    // ====================================================================================================
    // Halaman Laporan
    // ====================================================================================================
    Route::get('/admin/laporanpenjualan', [AdminController::class, 'laporanpenjualan']);


    // ====================================================================================================
    // Halaman Slides
    // ====================================================================================================
    Route::get('/admin/slides', [AdminController::class, 'slides'])->name('admin.slides');
    // Route untuk menambahkan slide
    Route::get('/admin/slide/add', [AdminController::class, 'slide_add'])->name('admin.slide.add');
    // Route untuk menyimpan slide
    Route::post('/admin/slide/store', [AdminController::class, 'slide_store'])->name('admin.slide.store');
    // Route untuk edit slide
    Route::get('/admin/slide/{id}/edit', [AdminController::class, 'slide_edit'])->name('admin.slide.edit');
    // Route untuk update slide
    Route::put('/admin/slide/update', [AdminController::class, 'slide_update'])->name('admin.slide.update');
    // Route untuk delete slide
    Route::delete('/admin/slide/{id}/delete', [AdminController::class, 'slide_delete'])->name('admin.slide.delete');


    // ====================================================================================================
    // Halaman Contact
    // ====================================================================================================
    Route::get('/admin/contact', [AdminController::class, 'contacts'])->name('admin.contacts');
    // Route untuk delete contact
    Route::delete('/admin/contact/{id}/delete', [AdminController::class, 'contact_delete'])->name('admin.contact.delete');


    // ====================================================================================================
    // Halaman Jobs
    // ====================================================================================================
    Route::get('/admin/jobs', [AdminController::class, 'jobs'])->name('admin.jobs');
    // Route untuk menambahkan job
    Route::get('/admin/jobs/add', [AdminController::class, 'job_add'])->name('admin.jobs.add');
    // Route untuk menyimpan job
    // Route::post('/admin/job/store', [AdminController::class, 'job_store'])->name('admin.job.store');
    // Route untuk edit job
    Route::get('/admin/jobs/edit/{id}', [AdminController::class, 'job_edit'])->name('admin.jobs.edit');
    Route::get('/admin/jobs/{id}/applications', [AdminController::class, 'viewApplications'])->name('admin.job.applications');
    // Route untuk update job
    // Route::put('/admin/job/update', [AdminController::class, 'job_update'])->name('admin.job.update');
    // Route untuk delete job
    // Route::delete('/admin/job/{id}/delete', [AdminController::class, 'job_delete'])->name('admin.job.delete');


    // ====================================================================================================
    // Halaman Supplier Request
    // ====================================================================================================
    Route::get('/admin/supplier-request', [SupplierRequestController::class, 'index'])->name('admin.supplier.index');
    // Route untuk menampilkan form supplier request
    Route::get('/admin/supplier-request/add', [SupplierRequestController::class, 'create'])->name('admin.supplier.request.add');
    // Route untuk menambahkan supplier request
    Route::post('/admin/supplier-request', [SupplierRequestController::class, 'store'])->name('admin.supplier.request.store');
    Route::get('/admin/supplier-request/export', [SupplierRequestController::class, 'export'])->name('admin.supplier.request.export');
    // Route untuk menampilkan detail supplier request
    Route::get('/admin/supplier-request/{id}', [SupplierRequestController::class, 'edit'])->name('admin.supplier.request.edit');
    // Route untuk mengubah status supplier request
    Route::put('/admin/supplier-request/{id}', [SupplierRequestController::class, 'update'])->name('admin.supplier.request.update');
    // Route untuk delete supplier request
    Route::delete('/admin/supplier-request/{id}/delete', [SupplierRequestController::class, 'destroy'])->name('admin.supplier.request.delete');

    // =================================================================================================================
    // Halaman dashboard supplier
    // =================================================================================================================
    Route::get('/admin/dashboard/supplier', [SupplierRequestController::class, 'supplierDashboard'])->name('admin.supplier.dashboard');

    // ====================================================================================================
    // Halaman Informasi Supplier
    // ====================================================================================================
    Route::get('/admin/adminsupplier/informasi_supplier/', [SupplierRequestController::class, 'indexInformationSupplier'])->name('admin.adminsupplier.informasi_supplier.index');
    // Create & Store
    Route::get('/admin/adminsupplier/informasi_supplier/create', [SupplierRequestController::class, 'createInformationSupplier'])->name('admin.adminsupplier.informasi_supplier.create');
    Route::post('/admin/adminsupplier/informasi_supplier/store', [SupplierRequestController::class, 'storeInformationSupplier'])->name('admin.adminsupplier.informasi_supplier.store');
    // Edit & Update
    Route::get('/admin/adminsupplier/informasi_supplier/{id}/edit', [SupplierRequestController::class, 'editInformationSupplier'])->name('admin.adminsupplier.informasi_supplier.edit');
    Route::put('/admin/adminsupplier/informasi_supplier/{id}/update', [SupplierRequestController::class, 'updateInformationSupplier'])->name('admin.adminsupplier.informasi_supplier.update');
    // Delete
    Route::delete('/admin/adminsupplier/informasi_supplier/{id}/delete', [SupplierRequestController::class, 'destroyInformationSupplier'])->name('admin.adminsupplier.informasi_supplier.delete');


    // =================================================================================================================
    // Halaman Stok Bahan Baku
    // =================================================================================================================
    Route::get('/admin/stok-bahan-baku', [StokBahanBakuController::class, 'index'])->name('admin.stok.index');
    // Route untuk menambahkan stok bahan baku
    Route::post('/admin/stok-bahan-baku', [StokBahanBakuController::class, 'store'])->name('admin.stok.store');
    // Route untuk mengedit stok bahan baku
    Route::get('/admin/stok-bahan-baku/{id}/edit', [StokBahanBakuController::class, 'edit'])->name('admin.stok.edit');
    // Route untuk mengupdate stok bahan baku
    Route::put('/admin/stok-bahan-baku/{id}', [StokBahanBakuController::class, 'update'])->name('admin.stok.update');
    // Route untuk menghapus stok bahan baku
    Route::delete('/admin/stok-bahan-baku/{id}', [StokBahanBakuController::class, 'destroy'])->name('admin.stok.delete');


    // =================================================================================================================
    // Halaman Penjadwalan Penjemputan
    // =================================================================================================================
    Route::get('/admin/penjadwalan-penjemputan', [PenjadwalanPenjemputanController::class, 'index'])->name('admin.penjadwalan.index');
    // Route untuk menambahkan penjadwalan penjemputan
    Route::get('/admin/penjadwalan-penjemputan/add', [PenjadwalanPenjemputanController::class, 'create'])->name('admin.penjadwalan.add');
    // Route untuk menyimpan penjadwalan penjemputan
    Route::post('/admin/penjadwalan-penjemputan', [PenjadwalanPenjemputanController::class, 'store'])->name('admin.penjadwalan.store');
    // Route untuk mengekspor penjadwalan penjemputan
    Route::get('/admin/penjadwalan-penjemputan/export', [PenjadwalanPenjemputanController::class, 'export'])->name('admin.penjadwalan.export');
    // Route untuk mengedit penjadwalan penjemputan
    Route::get('/admin/penjadwalan-penjemputan/{id}/edit', [PenjadwalanPenjemputanController::class, 'edit'])->name('admin.penjadwalan.edit');
    // Route untuk mengupdate penjadwalan penjemputan
    Route::put('/admin/penjadwalan-penjemputan/{id}', [PenjadwalanPenjemputanController::class, 'update'])->name('admin.penjadwalan.update');
    // Route untuk menghapus penjadwalan penjemputan
    Route::delete('/admin/penjadwalan-penjemputan/{id}', [PenjadwalanPenjemputanController::class, 'destroy'])->name('admin.penjadwalan.delete');


    // ====================================================================================================
    // Halaman About
    // ====================================================================================================
    // Index & Pagination
    Route::get('/admin/about', [AdminController::class, 'about'])->name('admin.about.index');
    // Create & Store
    Route::get('/admin/about/create', [AdminController::class, 'createAbout'])->name('admin.about.create');
    Route::post('/admin/about', [AdminController::class, 'storeAbout'])->name('admin.about.store');
    // Edit & Update
    Route::get('/admin/about/{about}/edit', [AdminController::class, 'editAbout'])->name('admin.about.edit');
    Route::put('/admin/about/{about}', [AdminController::class, 'updateAbout'])->name('admin.about.update');
    // Delete
    Route::delete('/admin/about/{about}', [AdminController::class, 'destroyAbout'])->name('admin.about.destroy');


    // ====================================================================================================
    // Halaman Data Pengguna
    // ====================================================================================================
    // Index & Pagination dengan filtering
    Route::get('/admin/data-pengguna', [AdminController::class, 'data_pengguna'])->name('admin.data-pengguna.index');
    // Create new user
    Route::get('/admin/data-pengguna/create', [AdminController::class, 'create_user'])->name('admin.data-pengguna.create');
    Route::post('/admin/data-pengguna', [AdminController::class, 'store_user'])->name('admin.data-pengguna.store');
    // Show user details
    Route::get('/admin/data-pengguna/{id}', [AdminController::class, 'show_user'])->name('admin.data-pengguna.show');
    // Edit user
    Route::get('/admin/data-pengguna/{id}/edit', [AdminController::class, 'edit_user'])->name('admin.data-pengguna.edit');
    Route::put('/admin/data-pengguna/{id}', [AdminController::class, 'update_user'])->name('admin.data-pengguna.update');
    // Delete user
    Route::delete('/admin/data-pengguna/{id}', [AdminController::class, 'delete_user'])->name('admin.data-pengguna.delete');
    // Toggle email verification
    Route::patch('/admin/data-pengguna/{id}/toggle-verification', [AdminController::class, 'toggle_verification'])->name('admin.data-pengguna.toggle-verification');
    // Bulk actions
    Route::post('/admin/data-pengguna/bulk-action', [AdminController::class, 'bulk_action'])->name('admin.data-pengguna.bulk-action');
    // Export users
    Route::get('/admin/data-pengguna/export/csv', [AdminController::class, 'export_users'])->name('admin.data-pengguna.export');

    // User Addresses Management (opsional untuk admin)
    // ====================================================================================================
    // View user addresses
    Route::get('/admin/data-pengguna/{user_id}/addresses', [AdminController::class, 'user_addresses'])->name('admin.data-pengguna.addresses');
    // Delete user address
    Route::delete('/admin/data-pengguna/{user_id}/addresses/{address_id}', [AdminController::class, 'delete_user_address'])->name('admin.data-pengguna.addresses.delete');

    // ====================================================================================================
    // HALAMAN DATA PENGGUNA - COMPLETE MANAGEMENT SYSTEM
    // ====================================================================================================

    // Main user management routes
    Route::prefix('admin/data-pengguna')->name('admin.data-pengguna.')->group(function () {

        // Index & Pagination dengan filtering dan searching
        Route::get('/', [AdminController::class, 'data_pengguna'])->name('index');

        // CRUD Operations
        Route::get('/create', [AdminController::class, 'create_user'])->name('create');
        Route::post('/', [AdminController::class, 'store_user'])->name('store');
        Route::get('/{id}', [AdminController::class, 'show_user'])->name('show');
        Route::get('/{id}/edit', [AdminController::class, 'edit_user'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'update_user'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'delete_user'])->name('delete');

        // Advanced User Management
        Route::patch('/{id}/toggle-verification', [AdminController::class, 'toggle_verification'])->name('toggle-verification');
        Route::post('/{id}/send-verification', [AdminController::class, 'send_verification_email'])->name('send-verification');
        Route::post('/{id}/reset-password', [AdminController::class, 'reset_user_password'])->name('reset-password');

        // Bulk Operations
        Route::post('/bulk-action', [AdminController::class, 'bulk_action'])->name('bulk-action');

        // Data Export & Import
        Route::get('/export/csv', [AdminController::class, 'export_users'])->name('export');
        Route::get('/export/template', [AdminController::class, 'download_template'])->name('export.template');
        Route::post('/import/csv', [AdminController::class, 'import_users'])->name('import');

        // AJAX Data for DataTables (optional untuk implementasi DataTables)
        Route::get('/data/ajax', [AdminController::class, 'users_data'])->name('data.ajax');

        // Statistics & Analytics
        Route::get('/statistics/data', [AdminController::class, 'user_statistics'])->name('statistics');

        // User Address Management
        Route::get('/{user_id}/addresses', [AdminController::class, 'user_addresses'])->name('addresses');
        Route::delete('/{user_id}/addresses/{address_id}', [AdminController::class, 'delete_user_address'])->name('addresses.delete');
    });

    // ====================================================================================================
    // ADDITIONAL ADMIN ROUTES (contoh untuk sistem yang lebih lengkap)
    // ====================================================================================================

    // Admin Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Admin Profile Management
    Route::prefix('admin/profile')->name('admin.profile.')->group(function () {
        Route::get('/', [AdminController::class, 'admin_profile'])->name('index');
        Route::put('/update', [AdminController::class, 'update_admin_profile'])->name('update');
        Route::post('/change-password', [AdminController::class, 'change_admin_password'])->name('change-password');
    });

    // System Settings (opsional)
    Route::prefix('admin/settings')->name('admin.settings.')->group(function () {
        Route::get('/', [AdminController::class, 'system_settings'])->name('index');
        Route::post('/update', [AdminController::class, 'update_settings'])->name('update');
    });

    // Activity Logs (opsional untuk audit trail)
    Route::prefix('admin/logs')->name('admin.logs.')->group(function () {
        Route::get('/', [AdminController::class, 'activity_logs'])->name('index');
        Route::get('/user/{user_id}', [AdminController::class, 'user_activity_logs'])->name('user');
        Route::delete('/clear', [AdminController::class, 'clear_logs'])->name('clear');
    });

    // Reports & Analytics (opsional)
    Route::prefix('admin/reports')->name('admin.reports.')->group(function () {
        Route::get('/', [AdminController::class, 'reports_index'])->name('index');
        Route::get('/users', [AdminController::class, 'users_report'])->name('users');
        Route::get('/registrations', [AdminController::class, 'registrations_report'])->name('registrations');
        Route::post('/generate', [AdminController::class, 'generate_report'])->name('generate');
    });
});
