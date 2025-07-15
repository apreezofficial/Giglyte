<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobsController;
use App\Models\Jobs;
Route::get('/', function () {
    return view('welcome');
});
Route::prefix('auth')->group(function(){
  
});
Route::prefix('jobs')->controller(JobsController::class)->group(function(){
  Route::get('all', 'all');
  Route::post('create', 'create');
});