<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\MyMarksController;
use App\Http\Controllers\MarkController;
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
    Route::post('updateUser/{id}',[EmployeeController::class,'updateUser'])->name('updateUser');
    Route::get('showUser/{id}',[EmployeeController::class,'showUser'])->name('showUser');
    Route::post('destroyUser/{id}',[EmployeeController::class,'destroyUser'])->name('destroyUser');
   // Route::get('Complaint/{id}', [\App\Http\Controllers\ComplaintController::class, 'show']);


   Route::prefix("MyMarks")->group(function (){
    Route::get('/',[\App\Http\Controllers\MyMarksController::class,'index']);
    Route::get('indexFor1User/{id}',[\App\Http\Controllers\MyMarksController::class,'indexFor1User']);
    Route::get('/{id}',[\App\Http\Controllers\MyMarksController::class,'show']);
    Route::post('all' ,[\App\Http\Controllers\MyMarksController::class,'storeAll']);
    Route::post('/',[\App\Http\Controllers\MyMarksController::class,'store']);
    Route::post('update/{id}',[\App\Http\Controllers\MyMarksController::class,'update']);
    Route::post('delete/{id}',[\App\Http\Controllers\MyMarksController::class,'destroy']);
    });


    Route::prefix("schedules")->group(function (){
        Route::get('/',[\App\Http\Controllers\ScheduleController::class,'index']);
        Route::get('/{id}',[\App\Http\Controllers\ScheduleController::class,'show']);
        Route::post('/',[\App\Http\Controllers\ScheduleController::class,'store']);
      //  Route::post('update/{id}',[\App\Http\Controllers\ScheduleController::class,'update']);
        Route::post('delete/{id}',[\App\Http\Controllers\ScheduleController::class,'destroy']);


    });

    Route::prefix("marks")->group(function (){
        Route::get('/',[\App\Http\Controllers\MarkController::class,'index']);
        Route::get('/{id}',[\App\Http\Controllers\MarkController::class,'show']);
        Route::post('/',[\App\Http\Controllers\MarkController::class,'store']);
      //  Route::post('update/{id}',[\App\Http\Controllers\MarkController::class,'update']);
        Route::post('delete/{id}',[\App\Http\Controllers\MarkController::class,'destroy']);


});
 });