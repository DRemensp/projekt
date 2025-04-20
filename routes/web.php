<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\KlasseController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamTableController;
use Illuminate\Support\Facades\Route;


// Dashboard & Profile
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Auth-Routen
require __DIR__.'/auth.php';

// Nur eine Route für "/"
Route::get('/', [HomeController::class, 'index'])
    ->name('welcome');

// Verschiedene Views
Route::get('/teacher', function () {
    return view('teacher');
});

Route::get('/admin', function () {
    return view('admin');
});

Route::get('/admin', [AdminController::class, 'index'])
    ->name('index');


Route::post('/disciplines-teams', [TeamTableController::class, 'storeOrUpdate'])
    ->name('teamTable.storeOrUpdate');


// Resource-Routen
Route::resources([
    'schools'     => SchoolController::class,
    'klasses'     => KlasseController::class,
    'teams'       => TeamController::class,
    'disciplines' => DisciplineController::class,
    'teamTable'   => TeamTableController::class,
    'comments'    => CommentController::class,
]);
