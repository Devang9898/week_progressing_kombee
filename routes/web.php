<?php

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Number;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\SocialiteController;

Route::get('/', function () {
    echo greet_user(name: 'Custom helper method called!'); // Output: Hello, Aaditya!
});

Route::get('/array-helpers', [HelperController::class, 'arrayHelpers']);
Route::get('/number-helpers', [HelperController::class, 'numberHelpers']);
Route::get('/url-helpers', [HelperController::class, 'urlHelpers']);
Route::get('/misc-helpers', [HelperController::class, 'miscellaneousHelpers']);
Route::get('/path-helpers', [HelperController::class, 'pathHelpers']);




Route::get('/throw/{id}',[StudentController::class,'show']);
Route::get('cache-test',[StudentController::class,'index']);



Route::get('mylogin',function()
{
return view('login');
});


Route::get('/home', function () {
    return view('home'); // The view for your dashboard
})->name('home'); // This makes the route named "home"


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/mylogin'); // Redirect after logout
})->name('logout');


Route::controller(SocialiteController::class)->group(function()
{
    Route::get('auth/google','googleLogin')->name('auth.google');
    Route::get('auth/google-callback','googleAuthentication')->name('auth.google-callback');

});