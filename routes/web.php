<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Public pages
Route::get('/', fn() => view('home'))->name('home');
Route::get('/artworks', fn() => view('artworks'))->name('artworks');
Route::get('/artworks/detail', fn() => view('detail'))->name('detail');
Route::get('/saved', fn() => view('saved'))->name('saved');
Route::get('/cart', fn() => view('cart'))->name('cart');
Route::get('/cart/shipping', fn() => view('cart_shipping'))->name('cart.shipping');
Route::get('/cart/payment', fn() => view('cart_payment'))->name('cart.payment');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::get('/admin', fn() => view('admin_login'))->name('admin.login');
Route::get('/admin/artworks', fn() => view('admin_artworks'))->name('admin.artworks');
Route::get('/admin/add', fn() => view('admin_add'))->name('admin.add');
Route::get('/admin/detail', fn() => view('admin_detail'))->name('admin.detail');
