<?php

use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/experience', [ExperienceController::class, 'index'])->name('experience.index');
Route::get('/education', [EducationController::class, 'index'])->name('education.index');

Route::get('/lang/{locale}', function (string $locale) {
    session(['locale' => in_array($locale, ['en', 'km'], true) ? $locale : 'en']);

    return back();
})->name('lang.switch');


//For Menu Routing
Route::get('/page/{slug}', [\App\Http\Controllers\PageController::class, 'show'])
    ->name('page.show');
