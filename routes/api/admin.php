<?php
use App\Http\Controllers\PassportAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('admin/login',[\App\Http\Controllers\PassportAuthController::class,'adminLogin'])->name('adminLogin');

Route::group( ['prefix' => 'admin','middleware' => ['auth:admin-api','scopes:admin'] ],function(){

    Route::get('logout',[PassportAuthController::class,'adminlogout'])->name('adminLogout');
    Route::delete('delete/{id}', [\App\Http\Controllers\PassportAuthController::class, 'destroy']);

    //Show a specific user with his products
    Route::get('show_users/{id}', [\App\Http\Controllers\PassportAuthController::class, 'show']);

    //View All Users
    Route::get('index',[PassportAuthController::class,'index'])->name('index');

    //route for products

    // Route::delete('products/{id}',[\App\Http\Controllers\ProductController::class,'destroy']);

    // Route::get('products',[\App\Http\Controllers\ProductController::class,'index']);

    // Route::post('products',[\App\Http\Controllers\ProductController::class,'store']);




});
