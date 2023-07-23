<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DeliveryFeeController;
use App\Http\Controllers\SlideController;

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
/*admin api*/
Route::group(['middleware' => 'auth:api'], function() {
    Route::group(['prefix' => 'category'], function() {
        Route::post('save', [CategoryController::class, 'save']);
        Route::post('list', [CategoryController::class, 'list']);
        Route::post('single', [CategoryController::class, 'single']);
        Route::post('update', [CategoryController::class, 'update']);
        Route::post('delete', [CategoryController::class, 'delete']);
    });
    Route::group(['prefix' => 'delivery'], function() {
        Route::post('save', [DeliveryFeeController::class, 'save']);
        Route::post('list', [DeliveryFeeController::class, 'list']);
        Route::post('single', [DeliveryFeeController::class, 'single']);
        Route::post('update', [DeliveryFeeController::class, 'update']);
        Route::post('delete', [DeliveryFeeController::class, 'delete']);
    });
    Route::group(['prefix' => 'slide'], function() {
        Route::post('save', [SlideController::class, 'save']);
        Route::post('list', [SlideController::class, 'list']);
        Route::post('single', [SlideController::class, 'single']);
        Route::post('update', [SlideController::class, 'update']);
        Route::post('delete', [SlideController::class, 'delete']);
    });
});
