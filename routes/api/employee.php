<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\MyMarksController;
use App\Http\Controllers\SubjectController;

use App\Http\Controllers\MarkController;
use App\Http\Controllers\AdvertisementController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });



// routes for all users and doctors and employees
// Route::group(['middleware' => ['auth:doctor-api,user-api,employee-api', 'scopes:doctor,user,employee']], function () {
//       //doctor
//       Route::get('indexDoctor',[EmployeeController::class,'indexDoctor'])->name('indexDoctor');
//       Route::get('showDoctor/{id}',[EmployeeController::class,'showDoctor'])->name('showDoctor');
// });

Route::group(['middleware' => ['auth:doctor-api,user-api,employee-api']], function () { 
    Route::get('indexDoctor', [EmployeeController::class, 'indexDoctor'])->name('indexDoctor');
    Route::get('showDoctor/{id}', [EmployeeController::class, 'showDoctor'])->name('showDoctor');

    Route::prefix("Advertisement")->group(function (){
      Route::get('/',[\App\Http\Controllers\AdvertisementController::class,'index']);
      Route::get('/{id}',[\App\Http\Controllers\AdvertisementController::class,'show']);
      
      });  });

// Route::middleware('auth:api')->group(function () {
//   Route::get('indexDoctor', [EmployeeController::class, 'indexDoctor'])->middleware('scope:employee,doctor,user');
// });

Route::post('employee/login',[\App\Http\Controllers\PassportAuthController::class,'employeeLogin'])->name('employeeLogin');

Route::group( ['prefix' => 'employee','middleware' => ['auth:employee-api','scopes:employee'] ],function(){

    Route::get('logout',[PassportAuthController::class,'employeelogout'])->name('employeeLogout');
    //user
    Route::get('index',[EmployeeController::class,'index'])->name('index');
    Route::post('addUser',[EmployeeController::class,'AddUser'])->name('AddUser');
    Route::post('updateUser/{id}',[EmployeeController::class,'updateUser'])->name('updateUser');
    Route::get('showUser/{id}',[EmployeeController::class,'showUser'])->name('showUser');
    Route::post('destroyUser/{id}',[EmployeeController::class,'destroyUser'])->name('destroyUser');
   
//doctor
  // Route::get('indexDoctor',[EmployeeController::class,'indexDoctor'])->name('indexDoctor');
   Route::post('AddDoctor',[EmployeeController::class,'AddDoctor'])->name('AddDoctor');
   Route::post('updateDoctor/{id}',[EmployeeController::class,'updateDocdor'])->name('updateDocdor');
   Route::get('showDoctor/{id}',[EmployeeController::class,'showDoctor'])->name('showDoctor');
   Route::post('destroyDoctor/{id}',[EmployeeController::class,'destroyDoctor'])->name('destroyDoctor');



   //subjects
   Route::prefix("Subject")->group(function (){
    Route::get('/',[\App\Http\Controllers\SubjectController::class,'index']);
    Route::get('/{id}',[\App\Http\Controllers\SubjectController::class,'show']);
    Route::post('/',[\App\Http\Controllers\SubjectController::class,'store']);
    Route::post('update/{id}',[\App\Http\Controllers\SubjectController::class,'update']);
    Route::post('delete/{id}',[\App\Http\Controllers\SubjectController::class,'destroy']);

    });

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
        Route::get('download/{id}',[\App\Http\Controllers\MarkController::class,'downloadPDF']);
        Route::post('/',[\App\Http\Controllers\MarkController::class,'store']);
      //  Route::post('update/{id}',[\App\Http\Controllers\MarkController::class,'update']);
        Route::post('delete/{id}',[\App\Http\Controllers\MarkController::class,'destroy']);

});

//Advertisement
Route::prefix("Advertisement")->group(function (){

  Route::post('/',[\App\Http\Controllers\AdvertisementController::class,'store']);
  Route::post('update/{id}',[\App\Http\Controllers\AdvertisementController::class,'update']);
  Route::post('delete/{id}',[\App\Http\Controllers\AdvertisementController::class,'destroy']);

  });

 });