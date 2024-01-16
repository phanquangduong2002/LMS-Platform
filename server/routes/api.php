<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsLetter;
use App\Http\Controllers\TutCategory;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Tutorial;

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
    'middleware' => 'api',
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
    'middleware' => 'api',
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


Route::group([
    'middleware' => 'api',
    'prefix' => 'tutorial/category'
], function ($router) {
    Route::get('/', [TutCategory::class, 'getAllTutCategories']);
    Route::get('/{id}', [TutCategory::class, 'getATutCat'])->middleware('admin');
    Route::post('/', [TutCategory::class, 'postTutorialCategory'])->middleware('admin');
    Route::put('/{id}', [TutCategory::class, 'editATutCat'])->middleware('admin');
    Route::delete('/{id}', [TutCategory::class, 'deleteATutCat'])->middleware('admin');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'tutorial'
], function ($router) {
    Route::get('/', [Tutorial::class, 'getAllTutorial']);
    Route::get('/{tutCatId}/{slug}', [Tutorial::class, 'getATutorial']);
    Route::post('/', [Tutorial::class, 'postTutorial'])->middleware('admin');
    Route::put('/{id}', [Tutorial::class, 'updateTutorial'])->middleware('admin');
    Route::delete('/{id}', [Tutorial::class, 'deleteTutorial'])->middleware('admin');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'newsletter'
], function ($router) {
    Route::post('/', [NewsLetter::class, 'subscribe']);
    Route::delete('/{id}', [NewsLetter::class, 'unsubscribe']);
});
