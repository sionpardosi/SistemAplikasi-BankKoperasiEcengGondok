<?php

use Illuminate\Http\Request;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\API\JobController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\ShopController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\RajaOngkirController;
use App\Http\Controllers\API\WishlistController;
use App\Http\Controllers\API\GoogleAuthController;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\API\JobApplicationController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan route API untuk aplikasi Anda. Route ini
| akan dimuat oleh RouteServiceProvider dan diberi middleware "api".
|
*/

// =====================================================================================================================================================================================================
// -------------------------------------------------------------------------------------------- RAJA ONGKIR --------------------------------------------------------------------------------------------
// =====================================================================================================================================================================================================
Route::get('rajaongkirprovinces', [RajaOngkirController::class, 'getProvinces']);
// Route untuk mendapatkan daftar kota berdasarkan ID provinsi
Route::get('rajaongkircities/{id}', [RajaOngkirController::class, 'getCities']);
// Route untuk mendapatkan daftar kecamatan berdasarkan ID kota
Route::get('useraddressgetaddress/{id}', [RajaOngkirController::class, 'userAddressGetAddress']);
// Route untuk mendapatkan daftar kecamatan berdasarkan ID kota
Route::post('rajaongkircalculate', [RajaOngkirController::class, 'calculateShipping']);
// Route untuk mendapatkan daftar kecamatan berdasarkan ID kota
Route::post('saveshippingcost', [RajaOngkirController::class, 'saveShippingCost']); // optional
// Route untuk verifikasi origin city (opsional - untuk testing)
Route::get('rajaongkir/origin-info', [RajaOngkirController::class, 'getOriginCityInfo']);

// =====================================================================================================================================================================================================
// -------------------------------------------------------------------------------------------- CHATBOT AI --------------------------------------------------------------------------------------------
// =====================================================================================================================================================================================================
Route::post('/chat', function (Request $request) {
    $message = $request->input('message');

    $response = Http::withToken(env('OPENAI_API_KEY'))->post('https://api.openai.com/v1/chat/completions', [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ['role' => 'system', 'content' => 'You are a helpful assistant.'],
            ['role' => 'user', 'content' => $message],
        ],
    ]);

    return response()->json([
        'reply' => $response['choices'][0]['message']['content'] ?? 'Maaf, terjadi kesalahan.',
    ]);
});


// =====================================================================================================================================================================================================
// -------------------------------------------------------------------------------------------- AUTH --------------------------------------------------------------------------------------------
// =====================================================================================================================================================================================================


// ====================================================================================================
// API Auth
// ====================================================================================================
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/forgot-password', 'forgotPassword');
    Route::post('/reset-password', 'resetPassword');
    Route::get('/email/verify/{id}/{hash}', 'verifyEmail')->name('verification.verify');
});


// ====================================================================================================
// API Email Auth untuk verifikasi email real-time
// ====================================================================================================
Route::controller(App\Http\Controllers\API\EmailVerificationController::class)->group(function () {
    Route::post('/verification/send', 'sendVerificationCode');
    Route::post('/verification/verify-code', 'verifyCode');
    Route::post('/verification/resend', 'resendVerificationCode');
});


// ====================================================================================================
// API Pembayaran Midtrans
// ====================================================================================================
Route::post('/midtrans/callback', [MidtransCallbackController::class, 'handle']);


// =====================================================================================================================================================================================================
// -------------------------------------------------------------------------------------------- PENGUNJUNG ---------------------------------------------------------------------------------------------
// =====================================================================================================================================================================================================

// ====================================================================================================
// Halaman API Pengunjung
// ====================================================================================================
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/contact/store', 'contactStore');
});


// ====================================================================================================
// Halaman API Produk
// ====================================================================================================
Route::prefix('shop')->controller(ShopController::class)->group(function () {
    // Route untuk menampilkan daftar produk
    Route::get('/', 'index');
    // Route untuk menampilkan detail produk
    Route::get('/{product_slug}', 'productDetails');
});


// ====================================================================================================
// Halaman API stock produk
// ====================================================================================================
Route::get('/check-stock/{product}', function (App\Models\Product $product) {
    return response()->json([
        'stock' => $product->quantity
    ]);
});


// ====================================================================================================
// Halaman API Jobs
// ====================================================================================================
Route::get('/jobs', [JobController::class, 'index']);
// Detail lowongan kerja
Route::get('/jobs/{id}', [JobController::class, 'show']);


// ====================================================================================================
// API Job Application
// ====================================================================================================
Route::controller(JobApplicationController::class)->group(function () {
    Route::post('/jobs/{job_id}/apply', 'apply');
    Route::get('/user/applications', 'userApplications');
});


// =====================================================================================================================================================================================================
// --------------------------------------------------------------------------------------------USER lOGIN----------------------------------------------------------------------------------------------------
// =====================================================================================================================================================================================================

Route::middleware('auth.user')->group(function () {

    // ====================================================================================================
    // API Keranjang Belanja
    // ====================================================================================================
    Route::prefix('cart')->controller(CartController::class)->group(function () {
        Route::get('/', 'index');
        // Route untuk menambahkan item di keranjang
        Route::post('/add', 'addToCart');
        // Route untuk menambahkan jumlah item di keranjang
        Route::put('/increase-quantity/{productId}', 'increaseItemQuantity');
        // Route untuk mengurangi jumlah item di keranjang
        Route::put('/reduce-quantity/{productId}', 'reduceItemQuantity');
        // Route untuk menghapus item di keranjang
        Route::delete('/remove/{productId}', 'removeItemFromCart');
        // Route untuk mengosongkan keranjang
        Route::delete('/clear', 'emptyCart');
        // Route untuk menggunakan kupon
        Route::post('/apply-coupon', 'applyCouponCode');
        // Route untuk menghitung diskon
        Route::get('/calculate-discount', 'calculateDiscount');
        // Route untuk menghapus kupon
        Route::delete('/remove-coupon', 'removeCouponCode');
    });


    // ====================================================================================================
    // API Wishlist
    // ====================================================================================================
    Route::prefix('wishlist')->controller(WishlistController::class)->group(function () {
        // Route untuk menampilkan Wishlist
        Route::get('/', 'index');
        // Route untuk menambahkan item ke Wishlist
        Route::post('/add', 'addToWishlist');
        // Route untuk menghapus item dari Wishlist
        Route::delete('/remove/{productId}', 'removeItemFromWishlist');
        // Route untuk mengosongkan Wishlist
        Route::delete('/clear', 'emptyWishlist');
        // Route untuk memindahkan item dari Wishlist ke Keranjang
        Route::post('/move-to-cart/{productId}', 'moveToCart');
    });


    // ====================================================================================================
    // API Checkout/Order
    // ====================================================================================================
    Route::controller(CartController::class)->group(function () {
        // Route untuk menampilkan halaman checkout
        Route::get('/checkout', 'checkout');
        // Route untuk menyimpan order
        Route::post('/place-order', 'placeOrder');
        // Route untuk menampilkan order confirmation
        Route::get('/order-confirmation', 'confirmation');
    });


    // ====================================================================================================
    // API User
    // ====================================================================================================
    Route::controller(UserController::class)->group(function () {
        // ====================================================================================================
        // API Orders
        // ====================================================================================================
        // Route untuk menampilkan daftar order pengguna
        Route::get('/account-orders', 'accountOrders');
        // Route untuk menampilkan detail order pengguna berdasarkan order_id
        Route::post('/account-order-details/{order_id}', 'accountOrderDetails');
        // Route untuk membatalkan order
        Route::put('/account-order/cancel-order', 'accountCancelOrder');
    });


    // ====================================================================================================
    // API Logout & Resend Verification Email
    // ====================================================================================================
    Route::controller(AuthController::class)->group(function () {
        Route::post('/logout', 'logout');
        Route::post('/email/resend', 'resendVerificationEmail');
    });


    // =====================================================================================================================================================================================================
    // -------------------------------------------------------------------------------------------- ADMIN --------------------------------------------------------------------------------------------------
    // =====================================================================================================================================================================================================

    Route::prefix('api')->middleware(['auth', AuthAdmin::class])->group(function () {
        Route::get('/admin/chart-data', [AdminController::class, 'getChartData'])->name('api.admin.chart.data');
    });

    Route::middleware('isAdmin')->prefix('admin')->controller(AdminController::class)->group(function () {
        Route::get('/', 'index');


        // ====================================================================================================
        // API Admin Brands
        // ====================================================================================================
        Route::get('/brands',  'brands');
        // Menambahkan Brand
        Route::post('/brand/add',  'addBrand');
        // Edit Brand
        Route::get('/brand/edit/{id}',  'brandDetails');
        // Update Brand
        Route::post('/brand/update/{id}',  'updateBrand');
        // Delete Brand
        Route::delete('/brand/{id}/delete',  'deleteBrand');


        // ====================================================================================================
        // API Admin Categories
        // ====================================================================================================
        Route::get('/categories',  'categories');
        // Menambahkan Category
        Route::post('/category/add',  'addCategory');
        // Edit Category
        Route::get('/category/{id}/edit',  'categoryDetails');
        // Update Category
        Route::post('/category/update/{id}',  'updateCategory');
        // Delete Category
        Route::delete('/category/{id}/delete',  'deleteCategory');


        // ====================================================================================================
        // API Admin Produk
        // ====================================================================================================
        Route::get('/products',  'products');
        // Menambahkan Produk
        Route::post('/product/add',  'addProduct');
        // Edit Produk
        Route::get('/product/{id}/edit',  'productDetails');
        // Update Produk
        Route::post('/product/{id}/update',  'updateProduct');
        // Delete Produk
        Route::delete('/product/{id}/delete',  'deleteProduct');


        // ====================================================================================================
        // API Admin Coupons
        // ====================================================================================================
        Route::get('/coupons',  'coupons');
        // Add Coupon
        Route::post('/coupon/add',  'addCoupon');
        // Edit Coupon
        Route::get('/coupon/{id}/edit',  'couponDetails');
        // Update Coupon
        Route::post('/coupon/{id}/update',  'updateCoupon');
        // Delete Coupon
        Route::delete('/coupon/{id}/delete',  'deleteCoupon');


        // ====================================================================================================
        // API Admin Orders
        // ====================================================================================================
        Route::get('/orders',  'orders');
        // Order Details
        Route::get('/order/items/{order_id}',  'orderItems');
        // Update Order Update Status
        Route::post('/order/update-status',  'updateOrderStatus');


        // ====================================================================================================
        // API Admin Slides
        // ====================================================================================================
        Route::get('/slides',  'slides');
        // Route untuk menambahkan slide
        Route::post('/slide/add',  'addSlide');
        // Route untuk edit slide
        Route::get('/slide/{id}/edit',  'slideDetails');
        // Route untuk update slide
        Route::post('/slide/{id}/update',  'updateSlide');
        // Route untuk delete slide
        Route::delete('/slide/{id}/delete',  'deleteSlide');


        // ====================================================================================================
        // API Admin Contact
        // ====================================================================================================
        Route::get('/contact',  'contacts');
        // Route untuk delete contact
        Route::delete('/contact/{id}/delete',  'contact_delete');
    });
});


// =====================================================================================================================================================================================================
// --------------------------------------------------------------------------------------------ADMIN JOBs ---------------------------------------------------------------------------------------------------
// =====================================================================================================================================================================================================
Route::prefix('admin')->group(function () {
    Route::post('/jobs', [JobController::class, 'store']);
    Route::get('/jobs/{id}', [JobController::class, 'show']);
    Route::put('/jobs/{id}', [JobController::class, 'update']);
    Route::delete('/jobs/{id}', [JobController::class, 'destroy']);
    Route::post('/jobs/applications/{id}/update',  [JobApplicationController::class, 'updateStatus']);
    Route::get('/jobs/{id}/applications',  [JobApplicationController::class, 'getJobApplications']);
});



