<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrizerController;
use App\Http\Controllers\TerminController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
// Svi frizeri
Route::get('/frizeri', [FrizerController::class, 'index'])->name('frizeri.index');

// Prikaz pojedinačnog frizera
Route::get('/frizeri/{id}', [FrizerController::class, 'show'])->name('frizeri.show');

// =======================
// ULOGOVANI KORISNICI
// =======================
Route::middleware('auth')->group(function () {

Route::get('/moj-profil', function () {
    return view('moj-profil');
})->name('moj.profil');

Route::post('/frizeri/{id}/review', [ReviewController::class, 'store'])->name('reviews.store');

    // Zakazivanje termina - korisnik
Route::post('/termini/{id}/zakazi', [TerminController::class, 'book'])->name('termini.book');

// Zahtevi za rezervaciju - frizer
Route::get('/moji-zahtevi', [TerminController::class, 'requests'])->name('termini.requests');
Route::post('/termini/{id}/approve', [TerminController::class, 'approve'])->name('termini.approve');
Route::post('/termini/{id}/reject', [TerminController::class, 'reject'])->name('termini.reject');

// Moji termini
Route::get('/moje-rezervacije', [TerminController::class, 'myBookings'])->name('termini.myBookings');
Route::get('/moji-prihvaceni-termini', [TerminController::class, 'myAccepted'])->name('termini.myAccepted');

// Dodavanje termina - frizer
Route::get('/termini/create', [TerminController::class, 'create'])->name('termini.create');
Route::post('/termini', [TerminController::class, 'store'])->name('termini.store');

Route::post('/frizeri/{id}/poruka', [MessageController::class, 'store'])->name('messages.store');
Route::get('/moje-poruke', [MessageController::class, 'sent'])->name('messages.sent');
Route::get('/primljene-poruke', [MessageController::class, 'inbox'])->name('messages.inbox');
Route::post('/messages/reply/{id}', [MessageController::class, 'reply'])->name('messages.reply');

    // Edit / update / delete frizera
    Route::get('/frizeri/{id}/edit', [FrizerController::class, 'edit'])->name('frizeri.edit');
    Route::put('/frizeri/{id}', [FrizerController::class, 'update'])->name('frizeri.update');
   

    // Profil
    Route::get('/moje-recenzije', [ReviewController::class, 'myReviews'])->name('reviews.my');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =======================
// ADMIN
// =======================
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::post('/admin/korisnici/{id}/warning', [FrizerController::class, 'sendWarning'])->name('admin.users.warning');
    Route::get('/admin/korisnici', [FrizerController::class, 'allUsers'])->name('admin.users');
Route::delete('/admin/korisnici/{id}', [FrizerController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/admin/recenzije', [ReviewController::class, 'index'])->name('admin.reviews');
    Route::get('/admin/frizeri', [FrizerController::class, 'requests'])->name('admin.frizeri');
    Route::post('/admin/frizeri/{id}/approve', [FrizerController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/frizeri/{id}/reject', [FrizerController::class, 'reject'])->name('admin.reject');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';