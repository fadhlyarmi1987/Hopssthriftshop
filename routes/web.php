<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanPenghasilanController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Auth;
use Monolog\Handler\RotatingFileHandler;

// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
});
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/dashboard', [ProductController::class, 'index'])->name('dashboard');

// Product Routes
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/kaos', [ProductController::class, 'showKaos'])->name('products.kaos');
Route::get('/kemeja', [ProductController::class, 'showKemeja'])->name('products.kemeja');
Route::get('/jaket', [ProductController::class, 'showJaket'])->name('products.jaket');
Route::get('/search', [ProductController::class, 'search'])->name('search');

// Order Routes
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/transaksi', [OrderController::class, 'waitingOrders'])->name('transaksi');
Route::put('/orders/{order}/process', [OrderController::class, 'process'])->name('orders.process');
Route::delete('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

// Transaction Routes
Route::get('/riwayat-transaksi', [TransactionController::class, 'history'])->name('riwayat.transaksi');

// Laporan Routes
Route::get('/laporan-penghasilan', [LaporanPenghasilanController::class, 'index'])->name('laporan-penghasilan');
