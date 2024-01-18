<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CourseCategoryController;
use App\Http\Controllers\DocController;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TutCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\VideoController;

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
    Route::get('/', [TutCategoryController::class, 'getAllTutCategories']);
    Route::get('/{id}', [TutCategoryController::class, 'getATutCat'])->middleware('admin');
    Route::post('/', [TutCategoryController::class, 'postTutorialCategory'])->middleware('admin');
    Route::put('/{id}', [TutCategoryController::class, 'editATutCat'])->middleware('admin');
    Route::delete('/{id}', [TutCategoryController::class, 'deleteATutCat'])->middleware('admin');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'tutorial'
], function ($router) {
    Route::get('/', [TutorialController::class, 'getAllTutorial']);
    Route::get('/{tutCatId}/{slug}', [TutorialController::class, 'getATutorial']);
    Route::post('/', [TutorialController::class, 'postTutorial'])->middleware('admin');
    Route::put('/{id}', [TutorialController::class, 'updateTutorial'])->middleware('admin');
    Route::delete('/{id}', [TutorialController::class, 'deleteTutorial'])->middleware('admin');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'newsletter'
], function ($router) {
    Route::post('/', [NewsLetterController::class, 'subscribe']);
    Route::delete('/{id}', [NewsLetterController::class, 'unsubscribe']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'review'
], function ($router) {
    Route::get('/', [ReviewController::class, 'getAllReview']);
    Route::post('/', [ReviewController::class, 'createReview']);
    Route::get('/{id}', [ReviewController::class, 'getAReview'])->middleware('admin');
    Route::put('/{id}', [ReviewController::class, 'updateReviewStatus'])->middleware('admin');
    Route::delete('/{id}', [ReviewController::class, 'deleteAReview'])->middleware('admin');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'video'
], function ($router) {
    Route::get('/', [VideoController::class, 'getAllVideos']);
    Route::post('/', [VideoController::class, 'postVideo'])->middleware('admin');
    Route::get('/{slug}', [VideoController::class, 'getVideo']);
    Route::post('/{id}', [VideoController::class, 'updateVideo'])->middleware('admin');
    Route::delete('/{id}', [VideoController::class, 'deleteVideo'])->middleware('admin');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'document'
], function ($router) {
    Route::post('/', [DocController::class, 'postDocument'])->middleware('admin');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'blog/category'
], function ($router) {
    Route::get('/', [BlogCategoryController::class, 'getAllBlogCategories']);
    Route::get('/{id}', [BlogCategoryController::class, 'getABlogCat'])->middleware('admin');
    Route::post('/', [BlogCategoryController::class, 'postBlogCategory'])->middleware('admin');
    Route::put('/{id}', [BlogCategoryController::class, 'editABlogCat'])->middleware('admin');
    Route::delete('/{id}', [BlogCategoryController::class, 'deleteABlogCat'])->middleware('admin');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'blog'
], function ($router) {
    Route::get('/', [BlogController::class, 'getAllBlog']);
    Route::get('/{blogCatId}/{slug}', [BlogController::class, 'getABlog']);
    Route::post('/', [BlogController::class, 'postBlog'])->middleware('admin');
    Route::put('/{id}', [BlogController::class, 'updateBlog'])->middleware('admin');
    Route::delete('/{id}', [BlogController::class, 'deleteBlog'])->middleware('admin');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'course/category'
], function ($router) {
    Route::get('/', [CourseCategoryController::class, 'getAllCourseCategories']);
    Route::get('/{id}', [CourseCategoryController::class, 'getACourseCat'])->middleware('roles');
    Route::post('/', [CourseCategoryController::class, 'postCourseCategory'])->middleware('roles');
    Route::put('/{id}', [CourseCategoryController::class, 'editACourseCat'])->middleware('roles');
    Route::delete('/{id}', [CourseCategoryController::class, 'deleteACourseCat'])->middleware('roles');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'course'
], function ($router) {
    Route::get('/', [CourseCategoryController::class, 'getAllCourseCategories']);
    Route::get('/{id}', [CourseCategoryController::class, 'getACourseCat'])->middleware('roles');
    Route::post('/', [CourseCategoryController::class, 'postCourseCategory'])->middleware('roles');
    Route::put('/{id}', [CourseCategoryController::class, 'editACourseCat'])->middleware('roles');
    Route::delete('/{id}', [CourseCategoryController::class, 'deleteACourseCat'])->middleware('roles');
});
