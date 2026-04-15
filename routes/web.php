<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// ── HOMEPAGE ──
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/cari-kost', [App\Http\Controllers\KostDetailController::class, 'index'])->name('kost.cari');
// ── DETAIL KOST PUBLIK ──
Route::get('/kost/{kost}', [App\Http\Controllers\KostDetailController::class, 'show'])->name('kost.show');

// ── LANDING PEMILIK KOST ──
Route::get('/panduan-pemilik-kost', [App\Http\Controllers\OwnerLandingController::class, 'index'])->name('owner.landing');
Route::view('/Panduan', 'panduan')->name('panduan');

// ── DASHBOARD USER ──
Route::middleware(['auth', 'role.user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [ProfileController::class, 'index'])->name('profil');
    Route::get('/edit-profil', fn() => view('user.edit-profil'))->name('profil.edit');
    Route::patch('/edit-profil', [App\Http\Controllers\User\ProfilController::class, 'update'])->name('profil.update');
    Route::patch('/pengaturan/privasi', [App\Http\Controllers\User\PengaturanController::class, 'updatePrivasi'])->name('pengaturan.privasi');
    Route::patch('/pengaturan/notifikasi', [App\Http\Controllers\User\PengaturanController::class, 'updateNotifikasi'])->name('pengaturan.notifikasi');
    Route::patch('/verifikasi/email', [App\Http\Controllers\User\VerifikasiController::class, 'updateEmail'])->name('verifikasi.email');
    Route::patch('/verifikasi/hp', [App\Http\Controllers\User\VerifikasiController::class, 'updateHp'])->name('verifikasi.hp');
    Route::patch('/verifikasi/identitas', [App\Http\Controllers\User\VerifikasiController::class, 'updateIdentitas'])->name('verifikasi.identitas');
    Route::get('/favorit', fn() => view('user.favorit'))->name('favorit');
    Route::get('/booking', [App\Http\Controllers\User\BookingController::class, 'index'])->name('booking.index');
    Route::post('/booking', [App\Http\Controllers\User\BookingController::class, 'store'])->name('booking.store');
    Route::patch('/booking/{id}/cancel', [App\Http\Controllers\User\BookingController::class, 'cancel'])->name('booking.cancel');
    Route::get('/booking/{id}/pembayaran', [App\Http\Controllers\User\BookingController::class, 'pembayaran'])->name('booking.pembayaran');
    Route::post('/booking/{id}/bayar', [App\Http\Controllers\User\BookingController::class, 'bayar'])->name('booking.bayar');
    Route::post('/favorit/toggle', [App\Http\Controllers\User\FavoritController::class, 'toggle'])->name('favorit.toggle');
    Route::delete('/favorit/{id}', [App\Http\Controllers\User\FavoritController::class, 'destroy'])->name('favorit.destroy');
    Route::post('/review', [App\Http\Controllers\User\ReviewController::class, 'store'])->name('review.store');
});

// ── DASHBOARD ADMIN ──
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role.admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // ================= USER =================
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    Route::patch('/users/{user}/verify', [AdminController::class, 'verifyUser'])->name('users.verify');
    Route::patch('/users/{user}/reject', [AdminController::class, 'rejectUser'])->name('users.reject');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // ================= OWNER =================
    Route::get('/owners', [AdminController::class, 'owners'])->name('owners');
    Route::get('/owners/{owner}', [AdminController::class, 'showOwner'])->name('owners.show');
    Route::patch('/owners/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('owners.toggle-status');
    Route::delete('/owners/{user}', [AdminController::class, 'destroyUser'])->name('owners.destroy');
    Route::patch('/owners/{owner}/verify-identity', [AdminController::class, 'verifyOwner'])->name('owners.verify-identity');
    Route::patch('/owners/{owner}/reject-identity', [AdminController::class, 'rejectOwner'])->name('owners.reject-identity');

    // ================= KOST =================
    Route::get('/kosts', [AdminController::class, 'kosts'])->name('kosts');
    Route::get('/kosts/{kost}', [AdminController::class, 'showKost'])->name('kosts.show');
    Route::patch('/kosts/{kost}/verify', [AdminController::class, 'verifyKost'])->name('kosts.verify');
    Route::patch('/kosts/{kost}/toggle-status', [AdminController::class, 'toggleKostStatus'])->name('kosts.toggle-status');
    Route::delete('/kosts/{kost}', [AdminController::class, 'destroyKost'])->name('kosts.destroy');

    // ================= BOOKING =================
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');

    // ================= ULASAN OWNER ================= ✅
    Route::get('/ulasan', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::patch('/ulasan/{id}/approve', [App\Http\Controllers\Admin\ReviewController::class, 'approve'])->name('reviews.approve');
    Route::patch('/ulasan/{id}/reject', [App\Http\Controllers\Admin\ReviewController::class, 'reject'])->name('reviews.reject');

    // ================= PROMO =================
    Route::get('/promos', [App\Http\Controllers\Admin\PromoController::class, 'index'])->name('promos.index');
    Route::post('/promos', [App\Http\Controllers\Admin\PromoController::class, 'store'])->name('promos.store');
    Route::patch('/promos/{promo}', [App\Http\Controllers\Admin\PromoController::class, 'update'])->name('promos.update');
    Route::delete('/promos/{promo}', [App\Http\Controllers\Admin\PromoController::class, 'destroy'])->name('promos.destroy');
    Route::patch('/promos/{promo}/toggle', [App\Http\Controllers\Admin\PromoController::class, 'toggleStatus'])->name('promos.toggle');

    // ================= REPORT =================
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/reports/export/csv', [AdminController::class, 'exportReportsCsv'])->name('reports.export.csv');
    Route::get('/reports/export/pdf', [AdminController::class, 'exportReportsPdf'])->name('reports.export.pdf');
    Route::get('/reports/export/word', [AdminController::class, 'exportReportsWord'])->name('reports.export.word');

    // ================= ACTIVITY =================
    Route::get('/activities', [AdminController::class, 'activities'])->name('activities');

    // ================= SETTINGS =================
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

    // ================= NOTIFIKASI =================
    Route::get('/notifications/read-all', [AdminController::class, 'readAllNotifications'])->name('notifications.readAll');
    Route::get('/notifications/{id}/read', [AdminController::class, 'readNotification'])->name('notifications.read');
});

// ── PROFILE ──
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ── OWNER ROUTES ──
Route::prefix('owner')->name('owner.')->middleware(['auth', 'role.owner'])->group(function () {
    Route::get('/search', [App\Http\Controllers\Owner\DashboardController::class, 'search'])->name('search');
    Route::get('/dashboard', [App\Http\Controllers\Owner\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('kost', App\Http\Controllers\Owner\KostController::class);
    Route::resource('kamar', App\Http\Controllers\Owner\KamarController::class);

    // Booking
    Route::get('/booking', [App\Http\Controllers\Owner\BookingController::class, 'index'])->name('booking.index');
    Route::patch('/booking/{booking}/terima', [App\Http\Controllers\Owner\BookingController::class, 'terima'])->name('booking.terima');
    Route::patch('/booking/{booking}/tolak', [App\Http\Controllers\Owner\BookingController::class, 'tolak'])->name('booking.tolak');
    Route::patch('/booking/{booking}/selesai', [App\Http\Controllers\Owner\BookingController::class, 'selesai'])->name('booking.selesai');

    // Statistik
    Route::get('/statistik', [App\Http\Controllers\Owner\StatistikController::class, 'index'])->name('statistik');

    // Pengaturan
    Route::get('/pengaturan', [App\Http\Controllers\Owner\PengaturanController::class, 'index'])->name('pengaturan');
    Route::patch('/pengaturan', [App\Http\Controllers\Owner\PengaturanController::class, 'update'])->name('pengaturan.update');
    Route::patch('/pengaturan/password', [App\Http\Controllers\Owner\PengaturanController::class, 'updatePassword'])->name('pengaturan.password');
    Route::patch('/pengaturan/notifikasi', [App\Http\Controllers\Owner\PengaturanController::class, 'updateNotifikasi'])->name('pengaturan.notifikasi');
    Route::delete('/pengaturan/akun', [App\Http\Controllers\Owner\PengaturanController::class, 'hapusAkun'])->name('akun.hapus');

    // ================= ULASAN ================= ✅
    Route::get('/ulasan', [App\Http\Controllers\Owner\ReviewController::class, 'index'])->name('review.index');
    Route::post('/ulasan', [App\Http\Controllers\Owner\ReviewController::class, 'store'])->name('review.store');
});

require __DIR__.'/auth.php';