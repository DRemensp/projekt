<?php

use App\Http\Controllers\TeacherController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\KlasseController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamTableController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

// Dashboard & Profile
Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');
Route::view('profile', 'profile')->middleware(['auth'])->name('profile');

// In web.php (ersetze Route::resources für klasses)
Route::delete('/klasses/{klasseId}', [KlasseController::class, 'destroy'])->name('klasses.destroy');
Route::post('/klasses', [KlasseController::class, 'store'])->name('klasses.store');

// Auth-Routen
require __DIR__.'/auth.php';

// Startseite
Route::get('/', [HomeController::class, 'index'])
    ->name('welcome');


// Admin Dashboard Route
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

// Spezielle POST-Routen
Route::post('/disciplines-teams', [TeamTableController::class, 'storeOrUpdate'])
    ->name('teamTable.storeOrUpdate');

Route::post('/ranking/recalculate', [RankingController::class, 'recalculateAllScores'])
    ->name('ranking.recalculate');

// Rangliste-Übersicht
Route::get('/ranking', [RankingController::class, 'index'])
    ->name('ranking.index');

// Resource-Routen
Route::resources([
    'schools'     => SchoolController::class,
    'teams'       => TeamController::class,
    'disciplines' => DisciplineController::class,
    'teamTable'   => TeamTableController::class,
    'rankings'    => RankingController::class
]);
