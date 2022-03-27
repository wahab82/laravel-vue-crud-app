<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

// Company Controller Routes
Route::group(['prefix' => 'companies', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [CompanyController::class, 'index']);
    Route::post('store', [CompanyController::class, 'store']);
    Route::get('show/{id}', [CompanyController::class, 'show']);
    Route::get('edit/{id}', [CompanyController::class, 'edit']);
    Route::post('update/{id}', [CompanyController::class, 'update']);
    Route::delete('delete/{id}', [CompanyController::class, 'delete']);
    Route::get('all_companies', [CompanyController::class, 'allCompanies']);
});

// Employee Controller Routes
Route::group(['prefix' => 'employees', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [EmployeeController::class, 'index']);
    Route::post('store', [EmployeeController::class, 'store']);
    Route::get('show/{id}', [EmployeeController::class, 'show']);
    Route::get('edit/{id}', [EmployeeController::class, 'edit']);
    Route::post('update/{id}', [EmployeeController::class, 'update']);
    Route::delete('delete/{id}', [EmployeeController::class, 'delete']);
});
