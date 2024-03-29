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
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PagesFrontController;

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
        Route::post('update/variant', [ProductController::class, 'updateVariant']);
        Route::post('delete/variant', [ProductController::class, 'deleteVariant']);
    });
    Route::group(['prefix' => 'order'], function() {
        Route::post('get', [OrderAdminController::class, 'getOrder']);
        Route::post('update/status', [OrderAdminController::class, 'updateStatus']);
        Route::post('single', [OrderAdminController::class, 'single']);
    });
    Route::group(['prefix' => 'state'], function() {
        Route::post('save', [StateController::class, 'save']);
        Route::post('list', [StateController::class, 'list']);
        Route::post('single', [StateController::class, 'single']);
        Route::post('update', [StateController::class, 'update']);
        Route::post('delete', [StateController::class, 'delete']);
    });
    Route::group(['prefix' => 'city'], function() {
        Route::post('save', [CityController::class, 'save']);
        Route::post('list', [CityController::class, 'list']);
        Route::post('single', [CityController::class, 'single']);
        Route::post('update', [CityController::class, 'update']);
        Route::post('delete', [CityController::class, 'delete']);
    });
    Route::group(['prefix' => 'pages'], function() {
        Route::post('save', [PagesController::class, 'save']);
        Route::post('list', [PagesController::class, 'list']);
        Route::post('single', [PagesController::class, 'single']);
        Route::post('update', [PagesController::class, 'update']);
        Route::post('delete', [PagesController::class, 'delete']);
    });
});

/*front api*/

Route::post('website/get', [WebsiteSettingController::class, 'get']);
Route::group(['prefix' => 'product'], function() {
    Route::post('get/latest', [ProductFrontController::class, 'latest']);
    Route::post('get/tranding', [ProductFrontController::class, 'tranding']);
    Route::post('get/upcoming', [ProductFrontController::class, 'upcoming']);
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
    Route::post('single', [OrderAdminController::class, 'single']);
});
Route::group(['prefix' => 'deliveryFee'], function () {
    Route::post('get', [DeliveryFeeFrontController::class, 'list']);
});
Route::group(['prefix' => 'state'], function () {
    Route::post('get', [DeliveryFeeFrontController::class, 'getState']);
});

Route::group(['prefix' => 'city'], function () {
    Route::post('get', [DeliveryFeeFrontController::class, 'getCity']);
});
Route::group(['prefix' => 'pages'], function () {
    Route::post('get/single', [PagesFrontController::class, 'getPageSingle']);
});
