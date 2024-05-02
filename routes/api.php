<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// authentications routes
Route::post('/login',[\App\Http\Controllers\Api\AuthController::class,'login']);
Route::post('/register',[\App\Http\Controllers\Api\AuthController::class,'register']);

// protected routes with sanctum
Route::group(['middleware' => ['auth:sanctum']],function () {
    Route::post('/logout',[\App\Http\Controllers\Api\AuthController::class,'logout']);
    Route::get("/refresh", [\App\Http\Controllers\Api\AuthController::class, 'refresh']);
    Route::delete('/user/delete/{id}',[\App\Http\Controllers\Api\AuthController::class,'delete']);

    Route::group(['prefix' => 'course'],function () {
        Route::get('/',[\App\Http\Controllers\Api\CourseController::class,'index']);
        Route::post("/store", [\App\Http\Controllers\Api\CourseController::class, 'store']);
        Route::get('/find/{id}',[\App\Http\Controllers\Api\CourseController::class,'show']);
        Route::put('/update/{id}',[\App\Http\Controllers\Api\CourseController::class,'update']);
        Route::delete('/delete/{id}',[\App\Http\Controllers\Api\CourseController::class,'delete']);
    });

    Route::group(['prefix' => 'student'],function () {
        Route::get('/',[\App\Http\Controllers\Api\StudentController::class,'index']);
        Route::post("/store", [\App\Http\Controllers\Api\StudentController::class, 'store']);
        Route::get('/find/{id}',[\App\Http\Controllers\Api\StudentController::class,'show']);
        Route::put('/update/{id}',[\App\Http\Controllers\Api\StudentController::class,'update']);
        Route::delete('/delete/{id}',[\App\Http\Controllers\Api\StudentController::class,'delete']);
    });

    Route::group(['prefix' => 'enrollment'],function () {
        Route::get('/',[\App\Http\Controllers\Api\EnrollmentController::class,'index']);
        Route::post("/store", [\App\Http\Controllers\Api\EnrollmentController::class, 'store']);
        Route::get('/find/{id}',[\App\Http\Controllers\Api\EnrollmentController::class,'show']);
        Route::put('/update/{id}',[\App\Http\Controllers\Api\EnrollmentController::class,'update']);
        Route::delete('/delete/{id}',[\App\Http\Controllers\Api\EnrollmentController::class,'delete']);
        Route::post('/check',[\App\Http\Controllers\Api\EnrollmentController::class,'check']);
        Route::post('/enrolled',[\App\Http\Controllers\Api\EnrollmentController::class,'enrolled']);
    });
});
