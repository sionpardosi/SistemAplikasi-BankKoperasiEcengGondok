<?php

use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WishlistController;

// ====================================================================================================
// Halaman AUTH
// ====================================================================================================
Auth::routes();


// ====================================================================================================
// Halaman Pengunjung
// ====================================================================================================
Route::get('/', [HomeController::class, 'index'])->name('home.index');


// ====================================================================================================
// Halaman Produk
// ====================================================================================================
Route::get('/shop',[ShopController::class,'index'])->name('shop.index');
// Halaman Produk Detail
Route::get('/shop/{product_slug}',[ShopController::class,'product_details'])->name("shop.product.details");


// ====================================================================================================
// Halaman Keranjang
// ====================================================================================================
Route::get('/cart',[CartController::class,'index'])->name('cart.index');
// Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.store');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
// Route untuk menambahkan item di keranjang
Route::put('/cart/increase-qunatity/{rowId}',[CartController::class,'increase_item_quantity'])->name('cart.increase.qty');
// Route untuk mengurangi item di keranjang
Route::put('/cart/reduce-qunatity/{rowId}',[CartController::class,'reduce_item_quantity'])->name('cart.reduce.qty');
// Route untuk menghapus item di keranjang
Route::delete('/cart/remove/{rowId}',[CartController::class,'remove_item_from_cart'])->name('cart.remove');
// Route untuk mengosongkan keranjang
Route::delete('/cart/clear',[CartController::class,'empty_cart'])->name('cart.empty');

// ====================================================================================================
// Route untuk menambahkan Wishlist
// ====================================================================================================
Route::post('/wishlist/add',[WishlistController::class,'add_to_wishlist'])->name('wishlist.add');
// Route untuk menampilkan Wishlist
Route::get('/wishlist',[WishlistController::class,'index'])->name('wishlist.index');
// Route untuk menghapus item di Wishlist
Route::delete('/wishlist/remove/{rowId}',[WishlistController::class,'remove_item_from_wishlist'])->name('wishlist.remove');
// Route untuk mengosongkan Wishlist
Route::delete('/wishlist/clear',[WishlistController::class,'empty_wishlist'])->name('wishlist.empty');
// Route untuk memindahkan item dari Wishlist ke Cart
Route::post('/wishlist/move-to-cart/{rowId}',[WishlistController::class,'move_to_cart'])->name('wishlist.move.to.cart');


// User
Route::middleware(['auth'])->group(function () {
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
});


//  Admin
Route::middleware(['auth', AuthAdmin::class])->group(function () {

    // ====================================================================================================
    // Halaman Index
    // ====================================================================================================
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');


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
    Route::get('/admin/products',[AdminController::class,'products'])->name('admin.products');
    // Halaman Menambahkan Produk
    Route::get('/admin/product/add',[AdminController::class,'add_product'])->name('admin.product.add');
    // Halaman Menyimpan Produk
    Route::post('/admin/product/store',[AdminController::class,'product_store'])->name('admin.product.store');
    // Halaman Edit Produk
    Route::get('/admin/product/{id}/edit',[AdminController::class,'edit_product'])->name('admin.product.edit');
    // Halaman Update Produk
    Route::put('/admin/product/update',[AdminController::class,'update_product'])->name('admin.product.update');
    // Halaman Delete Produk
    Route::delete('/admin/product/{id}/delete',[AdminController::class,'delete_product'])->name('admin.product.delete');


    // ====================================================================================================
    // Halaman Coupons
    // ====================================================================================================
    Route::get('/admin/coupons',[AdminController::class,'coupons'])->name('admin.coupons');
    // Add Coupon
    Route::get('/admin/coupon/add',[AdminController::class,'add_coupon'])->name('admin.coupon.add');
    // Store Coupon
    Route::post('/admin/coupon/store',[AdminController::class,'add_coupon_store'])->name('admin.coupon.store');
    // Edit Coupon
    Route::get('/admin/coupon/{id}/edit',[AdminController::class,'edit_coupon'])->name('admin.coupon.edit');
    // Update Coupon
    Route::put('/admin/coupon/update',[AdminController::class,'update_coupon'])->name('admin.coupon.update');
    // Delete Coupon
    Route::delete('/admin/coupon/{id}/delete',[AdminController::class,'delete_coupon'])->name('admin.coupon.delete');


});

// User
// Route::middleware([AuthUser::class])->group(function(){
//     Route::get('/account-dashboard',[UserController::class,'account_dashboard'])->name('user.account.dashboard');
// });
