<?php

use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\ForumsController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmissionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CompanyProfileController::class, 'index'])->name('beranda');
Route::get('/sejarah', function () {
    return view('company.sejarah');
})->name('sejarah');
Route::get('/visi&misi', function () {
    return view('company.visi');
})->name('visi');
Route::get('/struktur-organisasi', function () {
    return view('company.struktur');
})->name('struktur');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/informasi', [CompanyProfileController::class, 'information'])->name('informasi');

Route::get('/anggota', [CompanyProfileController::class, 'anggota'])->name('anggota');


Route::get('/informasi/{informasi}', [CompanyProfileController::class, 'show'])->name('informasi.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::patch('/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
});

Route::prefix('informations')->name('informations.')->group(function () {
    Route::get('/', [InformationController::class, 'index'])->name('index');
    Route::post('/', [InformationController::class, 'store'])->name('store');
    Route::patch('/{information}', [InformationController::class, 'update'])->name('update');
    Route::delete('/{information}', [InformationController::class, 'destroy'])->name('destroy');
});
Route::prefix('forums')->name('forums.')->group(function () {
    Route::get('/', [ForumsController::class, 'index'])->name('index');
    Route::post('/', [ForumsController::class, 'store'])->name('store');
    Route::get('/{forum}', [ForumsController::class, 'show'])->name('show');
    Route::post('/{forum}/comments', [ForumsController::class, 'storeComments'])->name('store.comments');
    Route::patch('/{forum}', [ForumsController::class, 'update'])->name('update');
    Route::delete('/{forum}', [ForumsController::class, 'destroy'])->name('destroy');
});

Route::prefix('submissions')->name('submissions.')->group(function () {
    Route::get('/', [SubmissionsController::class, 'index'])->name('index');
    Route::post('/', [SubmissionsController::class, 'store'])->name('store');
    Route::get('/{submission}', [SubmissionsController::class, 'show'])->name('show');
    Route::put('/{submission}/status', [SubmissionsController::class, 'update'])->name('updateStatus');
});


require __DIR__.'/auth.php';
