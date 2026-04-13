<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminArtworkController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\ArtworkController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SavedController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

//Artworks
Route::get('/artworks', [ArtworkController::class, 'index'])->name('artworks');
Route::get('/artworks/{artwork}', [ArtworkController::class, 'show'])->name('detail');

// Saved / Wishlist
Route::get('/saved', [SavedController::class, 'index'])->name('saved');
Route::post('/saved/{artwork}/toggle', [SavedController::class, 'toggle'])->name('saved.toggle');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/{artwork}/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/{id}/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout
Route::get('/cart/shipping',[OrderController::class, 'shipping'])->name('cart.shipping');
Route::post('/cart/shipping',[OrderController::class, 'payment'])->name('cart.payment.show');
Route::get('/cart/payment', fn () => redirect()->route('cart.shipping'))->name('cart.payment');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

// Auth
Route::get('/login',[AuthController::class, 'showLogin'])->name('login');
Route::post('/login',[AuthController::class, 'login']);
Route::get('/register',[AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Customer account
Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::put('/account', [AccountController::class, 'update'])->name('account.update');
    Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('account.password');
});

// Admin auth
Route::get('/admin', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login',[AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout',[AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin panel
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

    // Artworks CRUD
    Route::get('/artworks', [AdminArtworkController::class, 'index'])->name('artworks');
    Route::get('/artworks/create', [AdminArtworkController::class, 'create'])->name('add');
    Route::post('/artworks', [AdminArtworkController::class, 'store'])->name('store');
    Route::get('/artworks/{artwork}', [AdminArtworkController::class, 'edit'])->name('detail');
    Route::put('/artworks/{artwork}', [AdminArtworkController::class, 'update'])->name('update');
    Route::delete('/artworks/{artwork}', [AdminArtworkController::class, 'destroy'])->name('destroy');

    // Orders management
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
});
