<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UserController;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);
Route::middleware('auth:api')->group( function () {
    Route::post('upload-avatar', [UserController::class,'uploadAvatar']);
    Route::post('change-password', [UserController::class,'changePassword']);

});

Route::apiResource('users', UserController::class);


//Route::get('users', [UserController::class, 'index'])->name('users.index');
//Route::post('users', [UserController::class, 'store'])->name('users.store');
//Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
//Route::match(['put', 'patch'], 'users/{user}', [UserController::class, 'update'])->name('users.update');
//Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');//Create API Resource



