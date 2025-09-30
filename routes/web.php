<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController; //impor Controller

Route::get('/', function () {
    return view('welcome');
});

Route::resource('employees',EmployeeController::class); // mendaftarkan resource route
