<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


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


Route::group([
    'middleware' => 'auth',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/send-verify-mail/{email}', [AuthController::class, 'sendVerifyMail']);
    Route::post('/forget-password', [AuthController::class, 'forgetPassword']);
});

Route::group([
    'middleware' => 'auth',
    'prefix' => 'user'
], function ($router) {
    Route::get('', [UserController::class, 'getAllUser'])->middleware('admin');
    Route::get('/{id}', [UserController::class, 'getUser']);
    Route::put('/update', [UserController::class, 'updateUser']);
    Route::delete('/{id}', [UserController::class, 'deleteUser'])->middleware('admin');
    Route::put('/block/{id}', [UserController::class, 'blockUser'])->middleware('admin');
    Route::put('/unblock/{id}', [UserController::class, 'unblockUser'])->middleware('admin');
    Route::put('/update-password', [UserController::class, 'updatePassword']);
});
