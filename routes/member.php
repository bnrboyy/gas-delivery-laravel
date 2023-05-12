<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Controllers\frontoffice\OrderCartController;
use App\Http\Controllers\frontoffice\OrderDetailController;
use App\Http\Controllers\frontoffice\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('language/{lang}', [MemberController::class, 'changeLanguage']);

/* Member */
Route::get('/member/data', [MemberController::class, 'getMember']);
Route::post('/member/login', [MemberController::class, 'memberLogin']);
Route::post('/member/register', [MemberController::class, 'memberRegister']);
Route::post('/member/forget-password', [MemberController::class, 'onSubmitForgetPassword']);
Route::post('/member/reset-password', [MemberController::class, 'onResetPassword']);
Route::get('/member/logout', [MemberController::class, 'onLogout']);

Route::post('order/confirm', [OrderCartController::class, 'onConfirmOrder']);
Route::get('order/changebranch', [OrderCartController::class, 'onChangeBranch']);

/* Route middleware */
Route::middleware('auth:member')->group(function () {
    /* Order Details */
    Route::get('order/detail/{id}', [OrderDetailController::class, 'orderDetailList']);
    Route::get('order/washanddry/detail/{id}', [OrderDetailController::class, 'washAndDryDetail']);
    Route::get('order/vendingandcafe/detail/{id}', [OrderDetailController::class, 'vendingAndCafeDetail']);

    Route::post('profile/update/{id}', [ProfileController::class, 'onUpdateProfile']);
    Route::post('profile/password/update/{id}', [ProfileController::class, 'onUpdatePassword']);
});

/** Route for frontend */
Route::post('order/temp', [OrderDetailController::class, 'onCreateOrderTemp']);
Route::post('orderWash/temp', [OrderDetailController::class, 'onCreateOrderWashTemp']);
Route::post('orderDry/temp', [OrderDetailController::class, 'onCreateOrderDryTemp']);
Route::post('order/temp/delete', [OrderDetailController::class, 'onDeleteOrderTemp']);
Route::post('order/temp/food/delete', [OrderDetailController::class, 'onDeleteOrderFoodsTemp']);
Route::post('order/temp/confirm', [OrderDetailController::class, 'onConfirmCart']);
Route::post('order/confirm', [OrderDetailController::class, 'onConfirmOrder']);

Route::get('product/{id}', [ProductsController::class, 'getProductById']);

/* Order Temp */
Route::post('order/foodtemp', [OrderCartController::class, 'onCreateOrderTempFood']);
Route::post('order/foodcart', [OrderCartController::class, 'onCreateOrderCartTempFood']);
Route::post('order/foodtemp/confirm', [OrderCartController::class, 'onConfirmCart']);
Route::post('order/foodorder/confirm', [OrderCartController::class, 'onConfirmOrder']);
Route::post('order/food/updatecart', [OrderCartController::class, 'onUpdateCartItem']);
