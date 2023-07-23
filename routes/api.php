<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\AccountHeadController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'auth'], function() {
    Route::post('registration', [AuthController::class, 'registration']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot/password', [AuthController::class, 'forget']);
    Route::post('reset/password', [AuthController::class, 'passwordReset']);
});
Route::group(['middleware' => 'auth:api'], function() {
    Route::group(['prefix' => 'category'], function() {
        Route::post('save', [CategoryController::class, 'save']);
        Route::post('list', [CategoryController::class, 'list']);
        Route::post('single', [CategoryController::class, 'single']);
        Route::post('update', [CategoryController::class, 'update']);
        Route::post('delete', [CategoryController::class, 'delete']);
    });
});
