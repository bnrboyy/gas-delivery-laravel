<?php

namespace App\Http\Controllers\frontoffice;

use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/tankchange', [VendingAndCafeController::class, 'tankchangeOrdering']);
Route::get('/product-details/{product_id}', [VendingAndCafeController::class, 'productDetails']);
Route::get('/cart', [VendingAndCafeController::class, 'cartDetails']);


// Login system
Route::get('/', [ContentController::class, 'getPage']);
Route::get('/changeLanguage', [ContentController::class, 'changeLanguage']);
Route::get('/auth/auth-login', [ContentController::class, 'getPageLogin'])->name('login-member');
Route::get('/auth/{slug}', [ContentController::class, 'getPage']);

Route::get('/auth-reset', function () {
    return view('pages.auth.auth-reset-password');
});

// Content
Route::get('/content/{slug}', [ContentController::class, 'getContent']);

// Map system
Route::get('/map', [MapsController::class, 'getMap']);
Route::get('/test', [MapsController::class, 'test']);

// Wash&dry system
Route::get('/washing', [WashAndDryController::class, 'washOrdering'])->name('washing');
Route::get('/washing/wash', [WashAndDryController::class, 'washingContent']);
Route::get('/washing/dry', [WashAndDryController::class, 'dryingContent']);
Route::get('/washing/cart', [WashAndDryController::class, 'washingCart']);

// Vending&cafe system
Route::get('/foods', [VendingAndCafeController::class, 'foodsOrdering']);
Route::get('/foods/menu', [VendingAndCafeController::class, 'foodsMenu']);
Route::get('/foods/details/{food_id}', [VendingAndCafeController::class, 'foodsDetails']);
Route::get('/foods/cart', [VendingAndCafeController::class, 'foodsCart']);

/* Route middleware member */
Route::middleware('auth-member:member')->group(function () {
    Route::get('/washing/payment', [WashAndDryController::class, 'washingPayment']);
    Route::get('/foods/payment', [VendingAndCafeController::class, 'foodsPayment']);

    // Profile system
    Route::get('/profile', [ProfileController::class, 'profileContent']);
    Route::get('/profile/information', [ProfileController::class, 'informationContent']);
    Route::get('/profile/information/edit', [ProfileController::class, 'informationEditContent']);
    Route::get('/profile/orderhistory', [ProfileController::class, 'orderHistory']);
    Route::get('/profile/orderhistory/detail', [ProfileController::class, 'orderDetail']);
    Route::get('/profile/orderhistory/detail/receipt/{orders_number}', [ProfileController::class, 'orderReceipt']);
    Route::get('/profile/orderhistory/detail/evidence/{orders_number}', [ProfileController::class, 'orderEvidence']);
});
