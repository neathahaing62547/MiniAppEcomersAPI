<?php

use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminSearchController;
use App\Http\Controllers\SearchProductController;
use Illuminate\Http\Request;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthControlller;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\wishlistsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthControlller::class, 'login'])->name('login');
Route::post('/rigister', [AuthControlller::class, 'rigister'])->name('rigister');


Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    Route::delete('/admin/user/delete/{id}', [UserController::class, 'DeleteUser'])->name('DeleteUser');

    Route::post('/admin/user/creatstaff', [UserController::class, 'CreateStaff'])->name('CreateStaff');

    Route::put('/admin/user/updateuser/{id}', [UserController::class, 'UpdateUser'])->name('updateuser');

    Route::post('/admin/category/store', [AdminCategoryController::class, 'store'])->name('store');

    Route::put('/admin/category/update/{id}', [AdminCategoryController::class, 'update'])->name('update');

    Route::delete('/admin/category/delete/{id}', [AdminCategoryController::class, 'delete'])->name('delete');

    Route::post('/admin/product/store', [AdminProductController::class, 'store'])->name('store');

    Route::post('/admin/product/update/{id}', [AdminProductController::class, 'update'])->name('update');

    Route::delete('/admin/product/delete/{id}', [AdminProductController::class, 'delete'])->name('delete');

    Route::delete('/payment/delete/{id}', [PaymentController::class, 'delete'])->name('delete');

    Route::get('/admin/showall/report', [ReportController::class, 'show'])->name('showallreport');

    Route::get('/admin/fillter/report', [ReportController::class, 'adminfillterreport'])->name('adminfillterreport');
});

Route::middleware(['auth:sanctum', 'role:admin,staff'])->group(function () {

    Route::get('/admin/user', [UserController::class, 'ShowUser'])->name('GetUser');

    Route::get('/admin/user/search/', [UserController::class, 'SearchUser'])->name('SearchUser');

    Route::get('/admin/category', [AdminCategoryController::class, 'index'])->name('index');

    Route::get('/admin/product', [AdminProductController::class, 'index'])->name('index');

    Route::get('/admin/category/search', [AdminSearchController::class, 'search'])->name('search');

    Route::get('/payment', [PaymentController::class, 'payment'])->name('payment');

    Route::get('/showall/report/staff', [ReportController::class, 'showreportstaff'])->name('showreportstaff');
});


Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthControlller::class, 'logout'])->name('logout');

    Route::get('/category', [CategoryController::class, 'index'])->name('index');
    Route::get('/filterproductbycategory/{id}', [SearchProductController::class, 'filterproductbycategory'])->name('filterproductbycategory');

    Route::get('/product', [ProductController::class, 'index'])->name('index');

    Route::get('/product/detail/{id}', [ProductController::class, 'productdetail'])->name('productdetail');

    Route::get('/product/search', [SearchProductController::class, 'SearchProduct'])->name('searchproduct');

    Route::post('/addtocart', [CartController::class, 'AddToCart'])->name('addtocart');

    Route::get('/getcarts', [CartController::class, 'getcart_item'])->name('getcarts');

    Route::delete('/removefromcart/{id}', [CartController::class, 'removefromcart'])->name('removefromcart');

    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');

    Route::get('/paymentdetail', [PaymentController::class, 'getdetailpayment'])->name('payment');

    Route::post('/addtofavorith/{id}' , [wishlistsController::class, 'store'])->name('addtofavorith');
     
    Route::get('/favorith' , [wishlistsController::class, 'index'])->name('Favorith');

    Route::delete('removefromfavorith/{id}' , [wishlistsController::class, 'removefromfavorith'])->name('removefromfavorith');
    
}); 
