<?php

use App\Http\Controllers\PassportAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::post('user/register', [PassportAuthController::class, 'register'])->name('register');
Route::post('user/login', [PassportAuthController::class, 'userLogin'])->name('userLogin');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group( ['prefix' =>'user','middleware' => ['auth:user-api','scopes:user'] ],function(){
    Route::get('logout',[PassportAuthController::class,'logout'])->name('Logout');
    Route::get('userInfo',[PassportAuthController::class,'userInfo'])->name('userInfo');


    Route::post('update/{id}',[\App\Http\Controllers\PassportAuthController::class,'update_informations_user']);
    Route::post('change/{id}',[\App\Http\Controllers\PassportAuthController::class,'change_password']);


    // Show a particular user with its products
    Route::get('product',[\App\Http\Controllers\ProductController::class,'us_index']);




});




