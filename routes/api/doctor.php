<?php
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LectureController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('doctor/register', [PassportAuthController::class, 'registerDoctor'])->name('registerDoctor');
Route::post('doctor/login', [PassportAuthController::class, 'LoginDoctor'])->name('LoginDoctor');

Route::group( ['prefix' =>'doctor','middleware' => ['auth:doctor-api','scopes:doctor'] ],function(){
    Route::get('logout',[PassportAuthController::class,'logoutDoctor'])->name('logoutDoctor');
    Route::get('Info',[PassportAuthController::class,'doctorInfo'])->name('doctorInfo');



    Route::prefix("/{id1}/Lecture")->group(function (){
        Route::get('/',[\App\Http\Controllers\LectureController::class,'index']);
        Route::get('/{id}',[\App\Http\Controllers\LectureController::class,'show']);
        Route::post('/',[\App\Http\Controllers\LectureController::class,'store']);
        Route::post('update/{id}',[\App\Http\Controllers\LectureController::class,'update']);
        Route::post('delete/{id}',[\App\Http\Controllers\LectureController::class,'destroy']);


    });


    
});

