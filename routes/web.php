<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobsController;
use App\Models\Jobs;
use App\Http\Controllers\JobApplicationController;

Route::get('/', function () {
    return 'Welcome to Giglyte!';
});

Route::prefix('user')->controller(UserController::class)->group(function () {
    Route::get('all', 'index');
    Route::post('create', 'create')->name('user.create');
    Route::post('verify', 'verify')->name('user.verify');
    Route::post('login', 'login')->name('user.login');
    Route::post('final', 'final')->name('user.final');
Route::get('edit', [UserController::class, 'editForm'])->name('profile.edit');
Route::post('update', [UserController::class, 'updateProfile'])->name('profile.update');
Route::get('/dashboard', [UserController::class, 'dashboard']);
    Route::get('verify', fn () => view('verify'));
    Route::get('register', fn () => view('register'));
    Route::get('login', fn () => view('login'));
    Route::get('final', fn () => view('final'));
});

Route::prefix('jobs')->controller(JobsController::class)->group(function () {
    Route::get('all', 'all');
    Route::post('create', 'create')->name('jobs.create');

    // View routes
    Route::get('create', fn () => view('create-job'));
    Route::get('new', fn () => view('new_job'));
});
Route::post('/apply', [JobApplicationController::class, 'apply']);
Route::get('/job/{job_id}/applications', [JobApplicationController::class, 'jobApplications']);
Route::put('/application/{id}/status', [JobApplicationController::class, 'updateStatus']);