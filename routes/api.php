<?php

use App\Http\Controllers\API\LoginAPIController;
use App\Http\Controllers\StudentController;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\AuthorizationController;
use Laravel\Passport\Http\Controllers\PersonalAccessTokenController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

// Route::post('oauth/token', [AccessTokenController::class, 'issueToken']);
// Route::post('oauth/authorize', [AuthorizationController::class, 'authorize']);
// Route::post('oauth/personal-access-tokens', [PersonalAccessTokenController::class, 'store']);


Route::post('login', [LoginAPIController::class, 'login']);


// Route::get('students',[StudentController::class,'list']);
// Route::post('add-student',[StudentController::class,'addStudent']);
// Route::put('update-student',[StudentController::class,'updateStudent']);
// Route::delete('delete-student/{id}',[StudentController::class,'deleteStudent']);


// Route::middleware('auth:api')->group(function () {
//     Route::get('students', [StudentController::class, 'list']);
//     Route::post('add-student', [StudentController::class, 'addStudent']);
//     Route::put('update-student', [StudentController::class, 'updateStudent']);
//     Route::delete('delete-student/{id}', [StudentController::class, 'deleteStudent']);
// });





Route::middleware(['auth:api', 'throttle:5,1'])->group(function () {
    Route::get('students', [StudentController::class, 'list'])->name('student_list');
    Route::post('add-student', [StudentController::class, 'addStudent']);
    Route::put('update-student', [StudentController::class, 'updateStudent']);
    Route::delete('delete-student/{id}', [StudentController::class, 'deleteStudent']);
});


Route::view('/test','test');
Route::get('/log-info', function () {
    Log::info('This is an informational message from the /log-info route.');
    return 'Check the log file to see the message.';
});