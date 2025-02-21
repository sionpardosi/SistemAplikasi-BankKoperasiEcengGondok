<?php

use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

// Auth
Auth::routes();

// index Home Pengunjung
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/produk', [HomeController::class, 'produk'])->name('produk');


// User
Route::middleware(['auth'])->group(function(){
    Route::get('/account-dashboard',[UserController::class,'index'])->name('user.index');
});

//  Admin
Route::middleware(['auth',AuthAdmin::class])->group(function(){

    // Halaman Index
    Route::get('/admin',[AdminController::class,'index'])->name('admin.index');

    // Halaman Brands
    Route::get('/admin/brands',[AdminController::class,'brands'])->name('admin.brands');
    Route::get('/admin/brand/add',[AdminController::class,'add_brand'])->name('admin.brand.add');
    Route::post('/admin/brand/store',[AdminController::class,'add_brand_store'])->name('admin.brand.store');
    Route::get('/admin/brand/edit/{id}',[AdminController::class,'brand_edit'])->name('admin.brand.edit');
    Route::put('/admin/brand/update',[AdminController::class,'update_brand'])->name('admin.brand.update');
    Route::delete('/admin/brand/{id}/delete',[AdminController::class,'delete_brand'])->name('admin.brand.delete');

    // Halaman Categories
    Route::get('/admin/categories',[AdminController::class,'categories'])->name('admin.categories');

});

// User
// Route::middleware([AuthUser::class])->group(function(){
//     Route::get('/account-dashboard',[UserController::class,'account_dashboard'])->name('user.account.dashboard');
// });
