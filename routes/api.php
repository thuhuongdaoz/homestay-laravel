<?php


use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\HomestayController;
use App\Http\Controllers\Api\RoomController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

//Route::get('provinces',[ProvinceController::class,'index']);
//Route::get('districts',[DistrictController::class,'index']);
//Route::get('wards',[WardController::class,'index']);

Route::get('locations',[LocationController::class,'index']);
Route::get('locations/{location}',[LocationController::class,'show']);
Route::get('top-locations',[LocationController::class,'top']);


Route::post('upload-image',[FileController::class,'store']);
//Route::post('upload-multi-image',[FileController::class,'uploadMultiFile']);


Route::get('homestays',[HomestayController::class,'index']);
Route::get('homestays/{homestay}',[HomestayController::class,'show']);
Route::get('top-homestays',[HomestayController::class,'top']);
Route::get('search-homestays',[HomestayController::class,'search']);


Route::get('rooms', [RoomController::class,'index']);
Route::get('rooms/{room}', [RoomController::class,'show']);

Route::middleware('auth:api')->group(function () {
    Route::get('profile', [HomeController::class,'getProfile']);
    Route::put('profile', [HomeController::class,'updateProfile']);
//    Route::post('upload-avatar', [HomeController::class,'uploadAvatar']);
    Route::post('change-password', [HomeController::class,'changePassword']);

    Route::middleware('owner.role')->group(function (){
        Route::post('homestays',[HomestayController::class, 'store']);
        Route::put('homestays/{homestay}',[HomestayController::class, 'update']);
        Route::delete('homestays/{homestay}',[HomestayController::class, 'destroy']);

        Route::post('rooms', [RoomController::class,'store']);
        Route::put('rooms/{room}', [RoomController::class,'update']);
        Route::delete('rooms/{room}', [RoomController::class,'destroy']);
    });

    Route::middleware('admin.role')->group(function (){
        Route::apiResource('users', UserController::class);
        Route::prefix('users')->group(function (){
            Route::post('{user}/upload-avatar', [HomeController::class,'uploadAvatar']);
            Route::post('{user}/change-password', [HomeController::class,'changePassword']);
        });


        Route::post('locations',[LocationController::class,'store']);
        Route::match(['put', 'patch'],'locations/{location}',[LocationController::class,'update']);
        Route::delete('locations/{location}',[LocationController::class,'destroy']);

    });













    //        Route::get('users', [UserController::class, 'index'])->name('users.index');
//        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
//        Route::post('users', [UserController::class, 'store'])->name('users.store');
//        Route::match(['put', 'patch'], 'users/{user}', [UserController::class, 'update'])->name('users.update');
//        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');//Create API Resource






//    Route::middleware('client.role')->prefix('client')->group(function (){
//        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
//    });

//    Route::get('users', [UserController::class, 'index'])->name('users.index')->middleware('admin.role');

//    Route::prefix('client')->group(function(){
//
//        Route::post('upload-avatar', [UserController::class,'uploadAvatar']);
//        Route::post('change-password', [UserController::class,'changePassword']);
//    });
//
//
//    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');


});











