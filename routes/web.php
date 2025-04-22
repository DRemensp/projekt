<?php

use App\Http\Controllers\TeacherController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\KlasseController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamTableController; // Behalten, falls verwendet
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;


Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');
Route::view('profile', 'profile')->middleware(['auth'])->name('profile');

Route::delete('/klasses/{klasseId}', [KlasseController::class, 'destroy'])->name('klasses.destroy');
Route::post('/klasses', [KlasseController::class, 'store'])->name('klasses.store');

require __DIR__.'/auth.php';

Route::get('/', [HomeController::class, 'index'])
    ->name('welcome');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index'); // Auth hinzugefügt + Name korrigiert


Route::get('/teacher', [TeacherController::class, 'index'])
    ->name('teacher.index');

Route::post('/disciplines-teams', [TeamTableController::class, 'storeOrUpdate'])
    ->name('teamTable.storeOrUpdate');

Route::post('/ranking/recalculate', [RankingController::class, 'recalculateAllScores'])
    ->name('ranking.recalculate');

Route::get('/ranking', [RankingController::class, 'index'])
    ->name('ranking.index');

Route::resources([
    'schools'     => SchoolController::class,
    'teams'       => TeamController::class,
    'teachers'    => TeacherController::class,
    'disciplines' => DisciplineController::class,
    'teamTable'   => TeamTableController::class,
    'rankings'    => RankingController::class
]);
