<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Controllers\frontoffice\OrderCartController;
use App\Http\Controllers\frontoffice\OrderDetailController;
use App\Http\Controllers\frontoffice\ProfileController;
use Illuminate\Support\Facades\Route;


/** Backoffice Route */
Route::prefix('backoffice/v1')->group(function () {
    Route::post('login', [AuthBackOfficeController::class, 'loginAccount']);
    Route::post('register', [AuthBackOfficeController::class, 'registerAccount']);
    Route::post('forget-password', [AuthBackOfficeController::class, 'onSubmitForgetPassword']);
    Route::post('reset-password', [AuthBackOfficeController::class, 'onResetPassword']);

    Route::middleware('auth:api')->group(function () {
        Route::post('account/settings', [AuthBackOfficeController::class, 'getAccountSettings']);
        Route::post('account/token/invoke/current', [AuthBackOfficeController::class, 'revokeCurrentToken']);
        Route::post('account/token/invoke/token_id', [AuthBackOfficeController::class, 'revokeTokenByID']);
        Route::post('account/token/invoke/all', [AuthBackOfficeController::class, 'revokeAllToken']);

        /*  Products  */
        Route::get('productAll', [ProductsController::class, 'getProducts']);
        Route::get('productOne', [ProductsController::class, 'getProductById']);
        Route::post('product/create', [ProductsController::class, 'createProduct']);
        Route::post('product/update/{id}', [ProductsController::class, 'updateProduct']);
        Route::delete('product/delete', [ProductsController::class, 'deleteProduct']);
        Route::get('products/capacity', [ProductsController::class, 'getCapacity']);

        /*  Product Categories  */
        Route::get('productcateAll', [ProductCategoriesController::class, 'getProductCategories']);
        Route::get('productcateOne', [ProductCategoriesController::class, 'getProductCategoryById']);
        Route::get('productcate/default', [ProductCategoriesController::class, 'getProductCategoryByDefaults']);
        Route::post('productcate/create', [ProductCategoriesController::class, 'createProductCate']);
        Route::post('productcate/update/{id}', [ProductCategoriesController::class, 'updateProductCate']);
        Route::delete('productcate/delete', [ProductCategoriesController::class, 'deleteProductCate']);

        /* Order Cart */
        Route::post('add/item/{id}', [OrderCartController::class, 'addTocart']);

        /* Order Items */
        Route::post('item/{id}', [OrderItemController::class, 'addItem']);

        /* Order */
        Route::get('order/data/pending', [OrderController::class, 'getOrderPending']);
        Route::delete('order/{orders_number}', [OrderController::class, 'deleteOrder']);
        Route::get('order/cancel/{orders_number}', [OrderController::class, 'onCancelOrder']);
        Route::get('order/data', [OrderController::class, 'getOrder']);
        Route::get('order/data/ordernum', [OrderController::class, 'getOrderByOrderNumber']);
        Route::patch('order/status', [OrderController::class, 'updateOrderStatus']);
        Route::post('order/approve', [OrderController::class, 'approveOrder']);
        Route::post('order/send', [OrderController::class, 'sendOrder']);
        Route::patch('order/payment/verified/{orders_number}', [OrderController::class, 'verifiedPayment']);
        Route::put('order/item/verified', [OrderController::class, 'verifiedOrderWashItem']);
        Route::post('order/product/update/{id}', [OrderController::class, 'updateProductList']);


        /* Member */
        Route::get('member', [MemberController::class, 'getMember']);
        Route::get('member/{id}', [MemberController::class, 'getMemberById']);
        Route::delete('member/{id}', [MemberController::class, 'onDeleteMember']);
        Route::patch('member/changestatus/{id}', [MemberController::class, 'onChangeStatusMember']);

        /** Employee */
        Route::get('employee', [EmployeeController::class, 'getEmployee']);
        Route::get('employee/{id}', [EmployeeController::class, 'getEmployeeById']);
        Route::delete('employee/{id}', [EmployeeController::class, 'onDeleteEmployee']);
        Route::post('employee/edit/{id}', [EmployeeController::class, 'onEditEmployee']);

        /* Slide Page */
        Route::get('slide/data', [SlideController::class, 'index']);
        Route::get('slide/data/{id}', [SlideController::class, 'getSlideById']);
        Route::post('slide/create', [SlideController::class, 'createSlide']);
        Route::post('slide/update/{id}', [SlideController::class, 'updateSlideById']);
        Route::delete('slide/{language}/{token}', [SlideController::class, 'deleteWebInfoByInfoId']);

        /* Infomation Page */
        Route::get('webinfo/data', [WebInfoController::class, 'index']);
        Route::post('webinfo/details', [WebInfoController::class, 'updateWebDetails']);
        Route::delete('webinfo/image/{language}/{position}', [WebInfoController::class, 'deleteImage']);
        Route::post('webinfo/create', [WebInfoController::class, 'createWebInfo']);
        Route::post('webinfo/token/{token}', [WebInfoController::class, 'addWebInfo']);
        Route::patch('webinfo/token/{token}', [WebInfoController::class, 'editWebInfo']);
        Route::patch('webinfo/display/toggle', [WebInfoController::class, 'toggleDisplayByToken']);
        Route::patch('webinfo/update/{id}', [WebInfoController::class, 'updateWebinfo']);
        Route::delete('webinfo/{language}/{token}', [WebInfoController::class, 'deleteWebInfoByInfoId']);

        /* Category Page */
        Route::get('category/data', [CategoryController::class, 'index']);
        Route::post('category/create', [CategoryController::class, 'createCategory']);
        Route::post('category/update/{id}', [CategoryController::class, 'updateCategory']);
        Route::delete('category/{language}/{token}', [CategoryController::class, 'deleteCategory']);
        Route::get('category/menu', [CategoryController::class, 'getCateMenu']);
        Route::get('category/type/product', [CategoryController::class, 'getTypeProduct']);

        /* Content Page */
        Route::get('content/data', [PostController::class, 'index']);
        Route::post('content/create', [PostController::class, 'createContent']);
        Route::post('content/update/{id}', [PostController::class, 'updateContent']);
        Route::delete('content/{language}/{token}', [PostController::class, 'deleteContent']);

        /* Admin Page */
        Route::get('admin/data', [AdminController::class, 'index']);
        Route::post('admin/edit', [AdminController::class, 'editAdminAccount']);
        Route::delete('admin/{language}/{token}', [AdminController::class, 'deleteAdminAccount']);

        /* Language Config Page */
        Route::get('language/data', [LanguageConfigController::class, 'index']);
        Route::post('language/create', [LanguageConfigController::class, 'createLanguage']);
        Route::patch('language/edit', [LanguageConfigController::class, 'editLanguage']);
        Route::delete('language/delete/{param}', [LanguageConfigController::class, 'deleteLanguage']);

        /* Configuaration Page */
        Route::get('config/data', [ConfigController::class, 'index']);
        Route::delete('config/language/token/{token}', [ConfigController::class, 'deleteConfigLanguage']);
        Route::post('config/language/create', [ConfigController::class, 'createLanguage']);
        Route::post('config/data_type/create', [ConfigController::class, 'createDataType']);
        Route::delete('config/data_type/token/{token}', [ConfigController::class, 'deleteConfigDataType']);
        Route::post('config/ad_type/create', [ConfigController::class, 'createAdType']);
        Route::patch('config/ad_type/edit', [ConfigController::class, 'editAdType']);
        Route::delete('config/ad_type/token/{token}', [ConfigController::class, 'deleteConfigAdType']);

        /* Bank */

        Route::get('bank/data', [ConfigController::class, 'getBank']);
        Route::get('get/bank/{id}', [BankController::class, 'getBankById']);
        Route::post('bank/create', [BankController::class, 'createBank']);
        Route::post('bank/update/{id}', [BankController::class, 'updateBank']);
        Route::delete('bank/delete/{id}', [BankController::class, 'deleteBank']);
        Route::put('bank/update/display/{id}', [BankController::class, 'updateDisplayBank']);








        Route::post('config/upload/manual', [ConfigController::class, 'uploadManual']);

        /* Utility */
        Route::post('ckeditor/upload/image', [UtilController::class, 'ckeditorUploadImage']);
    });
  });
