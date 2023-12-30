<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', \App\Http\Controllers\PageHomeController::class)
    ->name('pages.home');

Route::get('courses/{course:slug}', \App\Http\Controllers\PageCourseDetailsController::class)
    ->name('pages.course-details');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', \App\Http\Controllers\PageDashboardController::class)
        ->name('pages.dashboard');
    Route::get('videos/{course:slug}/{video:slug?}', \App\Http\Controllers\PageVideoController::class)
        ->name('page.course-videos');

});
