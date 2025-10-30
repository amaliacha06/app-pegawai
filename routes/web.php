<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DepartemensController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController; //impor Controller
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SalariesController;
use App\Models\Department;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('employees',EmployeeController::class); // mendaftarkan resource route
Route::resource('departments', DepartemensController::class);
Route::resource('positions', PositionController::class);
Route::resource('attendance', AttendanceController::class);
Route::resource('salaries', SalariesController::class);