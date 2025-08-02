<?php

use App\Http\Controllers\ScoresystemController;
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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaufzettelController;


Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('admin')) {
        return redirect('/admin');}
    elseif ($user->hasRole('teacher')) {
        return redirect('/teacher');}
    return app(DashboardController::class)->index();
})->middleware(['auth', 'verified'])->name('dashboard');


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


Route::delete('/klasses/{klasseId}', [KlasseController::class, 'destroy'])
    ->name('klasses.destroy');
Route::post('/klasses', [KlasseController::class, 'store'])
    ->name('klasses.store');


require __DIR__.'/auth.php';


Route::get('/', [HomeController::class, 'index'])
    ->name('welcome');

Route::get('/teacher', function () {
    $user = auth()->user();
    if (!$user->hasRole('admin') && !$user->hasRole('teacher')) {
        return redirect('/');}
    return app(TeacherController::class)->index();
})->middleware(['auth'])->name('teacher.index');


Route::get('/admin', function () {
    if (!auth()->user()->hasRole('admin')) {
        return redirect('/');}
    return app(AdminController::class)->index();
})->middleware(['auth'])->name('admin.index');


Route::post('/disciplines-teams', [TeamTableController::class, 'storeOrUpdate'])
    ->name('teamTable.storeOrUpdate');


Route::post('/ranking/recalculate', [RankingController::class, 'recalculateAllScores'])
    ->name('ranking.recalculate');
Route::get('/ranking', [RankingController::class, 'index'])
    ->name('ranking.index');


Route::get('/laufzettel', [LaufzettelController::class, 'index'])
    ->name('laufzettel.index');
Route::get('/laufzettel/{team}', [LaufzettelController::class, 'show'])
    ->name('laufzettel.show');


Route::get('/archive', [App\Http\Controllers\ArchiveController::class, 'index'])
    ->name('archive.index');

Route::get('/archive/{archive}', [App\Http\Controllers\ArchiveController::class, 'show'])
    ->name('archive.show');

Route::post('/archive', [App\Http\Controllers\ArchiveController::class, 'store'])
    ->middleware(['auth'])
    ->name('archive.store');

Route::delete('/archive/{archive}', [App\Http\Controllers\ArchiveController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('archive.destroy');

Route::post('/scoresystem', [ScoresystemController::class, 'store'])->name('scoresystem.store');

// Füge diese Route zu deiner routes/web.php hinzu:
Route::post('/team/{team}/toggle-bonus', [LaufzettelController::class, 'toggleBonus'])->name('team.toggle-bonus');

//nicht wundern wenn manche Index nicht in Ressourcen angezeigt wird, hatte ganz komischen bug und fehler nicht gefunden,
//also einfach sepperat gemacht

Route::resources([
    'schools'     => SchoolController::class,
    'teams'       => TeamController::class,
    'teachers'    => TeacherController::class,
    'disciplines' => DisciplineController::class,
    'teamTable'   => TeamTableController::class,
    'rankings'    => RankingController::class
]);
