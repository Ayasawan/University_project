<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\EmployeeController;
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

// Route::post('employee/login',[PassportAuthController::class, 'employeeLogin'])->name('employeeLogin');
// Route::group( ['prefix' => 'employee','middleware' => ['auth:employee-api','scopes:employee'] ],function(){
//    // authenticated staff routes here 
//    Route::get('logout',[PassportAuthController::class,'logout'])->name('Logout');
// });

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('employee/login',[\App\Http\Controllers\PassportAuthController::class,'employeeLogin'])->name('employeeLogin');

Route::group( ['prefix' => 'employee','middleware' => ['auth:employee-api','scopes:employee'] ],function(){

    Route::get('logout',[PassportAuthController::class,'employeelogout'])->name('employeeLogout');
    Route::post('addUser',[EmployeeController::class,'AddUser'])->name('AddUser');

}); 