<?php

use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MyMarksController;
use App\Http\Controllers\ComplaintController;
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



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});





Route::post('user/register', [PassportAuthController::class, 'register'])->name('register');
Route::post('user/login', [PassportAuthController::class, 'userLogin'])->name('userLogin');

Route::group( ['prefix' =>'user','middleware' => ['auth:user-api','scopes:user'] ],function(){
    Route::get('logout',[PassportAuthController::class,'logout'])->name('Logout');
    Route::get('userInfo',[PassportAuthController::class,'userInfo'])->name('userInfo');
//    Route::get('show/{id}',[PassportAuthController::class,'show'])->name('show_information');

    Route::post('update/{id}',[\App\Http\Controllers\PassportAuthController::class,'update_informations_user']);
    Route::post('change/{id}',[\App\Http\Controllers\PassportAuthController::class,'change_password']);





///complaints
Route::prefix("complaints")->group(function (){
    Route::get('/',[\App\Http\Controllers\ComplaintController::class,'indexfor1User']);
    Route::post('/',[\App\Http\Controllers\ComplaintController::class,'store']);
    Route::post('update/{id}',[\App\Http\Controllers\ComplaintController::class,'update']);
    Route::post('delete/{id}',[\App\Http\Controllers\ComplaintController::class,'destroy_user']);

    //comment complaints
    Route::prefix("/{id}/comments")->group(function (){
        Route::post('/', [CommentController::class, 'store']);
        Route::post('/update/{comment}', [CommentController::class, 'update']);
        Route::post('/{comment}', [CommentController::class, 'destroy']);
    });


    // likes  complaints routes
    Route::prefix("/{id}/likes")->group(function (){
      //  Route::get('/', [LikeController::class, 'index']);
        Route::post('/', [LikeController::class, 'store']);
        Route::post('delete', [LikeController::class, 'dislike']);
    });


    });



    Route::prefix("DetectingMark")->group(function (){

        Route::get('/',[\App\Http\Controllers\DetectingMarkController::class,'indexfor1User']);
        Route::post('/',[\App\Http\Controllers\DetectingMarkController::class,'store']);
        Route::post('update/{id}',[\App\Http\Controllers\DetectingMarkController::class,'update_user']);
        Route::post('delete/{id}',[\App\Http\Controllers\DetectingMarkController::class,'destroy_user']);


    });
    //RePractical
    Route::prefix("RePractical")->group(function (){
        Route::post('/',[\App\Http\Controllers\RePracticalController::class,'store']);
        Route::get('/',[\App\Http\Controllers\RePracticalController::class,'indexfor1User']);
        Route::post('update/{id}',[\App\Http\Controllers\RePracticalController::class,'update_user']);
        Route::post('delete/{id}',[\App\Http\Controllers\RePracticalController::class,'destroy_user']);
    });

 ///objection
 Route::prefix("objection")->group(function (){
    Route::get('/',[\App\Http\Controllers\ObjectionController::class,'indexfor1User']);
    Route::post('/',[\App\Http\Controllers\ObjectionController::class,'store']);
    Route::post('update/{id}',[\App\Http\Controllers\ObjectionController::class,'update_user']);
    Route::post('delete/{id}',[\App\Http\Controllers\ObjectionController::class,'destroy_user']);
});



Route::get('AverageForAllYears',[\App\Http\Controllers\MyMarksController::class,'calculateAverageForAllYears']);

Route::prefix("MyMarks")->group(function (){
   Route::get('indexFor1Userbyuser/{id}',[\App\Http\Controllers\MyMarksController::class,'indexfor1Userbyuser']);
    Route::get('/{id}',[\App\Http\Controllers\MyMarksController::class,'show']);
    Route::get('calculateAverageForYear/{year}',[\App\Http\Controllers\MyMarksController::class,'calculateAverageForYear']);


    });

});

