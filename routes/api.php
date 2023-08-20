<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DeliveryFeeController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\WebsiteSettingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductFrontController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderAdminController;
use App\Http\Controllers\DeliveryFeeFrontController;

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
    Route::post('login/user', [AuthController::class, 'loginUser']);
    Route::post('logout/user', [AuthController::class, 'logoutUser']);
    Route::post('forgot/password', [AuthController::class, 'forget']);
    Route::post('reset/password', [AuthController::class, 'passwordReset']);
    Route::post('guest/create', [GuestController::class, 'createGuest']);
    Route::post('guest/get', [GuestController::class, 'getGuest']);
    Route::post('user/get', [AuthController::class, 'profile']);
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
    Route::group(['prefix' => 'website'], function() {
        Route::post('save', [WebsiteController::class, 'save']);
        Route::post('single', [WebsiteController::class, 'single']);
        Route::post('update', [WebsiteController::class, 'update']);
    });
    Route::group(['prefix' => 'product'], function() {
        Route::post('save', [ProductController::class, 'save']);
        Route::post('list', [ProductController::class, 'list']);
        Route::post('single', [ProductController::class, 'single']);
        Route::post('update', [ProductController::class, 'update']);
        Route::post('delete', [ProductController::class, 'delete']);
        Route::post('delete/image', [ProductController::class, 'deleteProductImage']);
        Route::post('delete/video', [ProductController::class, 'deleteProductVideo']);
    });
    Route::group(['prefix' => 'order'], function() {
        Route::post('get', [OrderAdminController::class, 'getOrder']);
        Route::post('update/status', [OrderAdminController::class, 'updateStatus']);
        Route::post('single', [OrderAdminController::class, 'single']);
    });
});

/*front api*/

Route::post('website/get', [WebsiteSettingController::class, 'get']);
Route::group(['prefix' => 'product'], function() {
    Route::post('get/latest', [ProductFrontController::class, 'latest']);
    Route::post('by/category', [ProductFrontController::class, 'byCategory']);
    Route::post('get/all', [ProductFrontController::class, 'getAll']);
    Route::post('get/single', [ProductFrontController::class, 'getSingle']);
});
Route::group(['prefix' => 'cart'], function () {
    Route::post('add', [CartController::class, 'addCart']);
    Route::post('get', [CartController::class, 'getCart']);
    Route::post('delete', [CartController::class, 'deleteCart']);
});
Route::group(['prefix' => 'order/user'], function () {
    Route::post('create', [OrderController::class, 'addOrder']);
    Route::post('get', [OrderController::class, 'getOrder']);
    Route::post('get/guest', [OrderController::class, 'getOrderGuest']);
    Route::post('cancel', [OrderController::class, 'cancelOrder']);
    Route::post('get/guest', [OrderController::class, 'getOrderGuest']);
});
Route::group(['prefix' => 'deliveryFee'], function () {
    Route::post('get', [DeliveryFeeFrontController::class, 'list']);
});
