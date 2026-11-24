<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// FITUR TAMU
Route::get('/register', [GuestController::class, 'index'])->name('guest.index');
Route::post('/guest/store', [GuestController::class, 'store'])->name('guest.store');
Route::get('/guest/active/{id}', [GuestController::class, 'checkoutView'])->name('guest.checkout-view');
Route::post('/guest/checkout/{id}', [GuestController::class, 'processCheckout'])->name('guest.checkout-process');

// FITUR ADMIN
Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
Route::post('/login', [AdminController::class, 'authenticate'])->name('login.process');
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // 1. Halaman List Tamu
    Route::get('/visitors', [AdminController::class, 'visitors'])->name('admin.visitors');

    // 2. Halaman DETAIL (Baru)
    Route::get('/visitors/detail/{id}', [AdminController::class, 'show'])->name('admin.logbook.show');

    // 3. Hapus Data
    Route::delete('/visitors/{id}', [AdminController::class, 'destroy'])->name('admin.visitors.destroy');

    // 4. Export
    Route::get('/export', [AdminController::class, 'exportReport'])->name('admin.export');

    // 1. Tampilkan Form Ganti Password
    Route::get('/profile', [AdminController::class, 'showProfile'])->name('admin.profile');

    // 2. Proses Update Password
    Route::put('/profile/password', [AdminController::class, 'updatePassword'])->name('admin.profile.update');
});
