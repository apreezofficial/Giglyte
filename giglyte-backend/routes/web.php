<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Models\Job;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/users', function(){
return Jobs::all();
});
