<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomAuth\CustomAuthController;
use App\Http\Controllers\Frontend\Pages\BasicViewController;
use App\Http\Controllers\AppApi\AppApiController;
use App\Http\Controllers\AppApi\AppApiControllerTwo;

use App\Http\Controllers\Frontend\Checkout\CheckoutController;
use App\Http\Controllers\Frontend\Student\StudentController;

use App\Http\Controllers\Frontend\FrontExam\FrontExamController;
use App\Http\Controllers\Backend\CourseManagement\Question\QuestionStoreController;
use App\Http\Controllers\Backend\AppVarsion\AppVarsionController;

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

Route::prefix('v1')->name('api.')->group(function (){


    Route::get('app-course-details/{id}/{slug?}', [AppApiController::class, 'courseDetails']);
    Route::get('app-course-category-resources/{id}/{slug?}', [AppApiController::class, 'courseCategoryResources']);
    Route::get('app-category-wise-courses/{id}/{slug?}', [AppApiController::class, 'CategoryCoursesResources']);
    Route::get('app-all-courses', [AppApiController::class, 'allCourses']);
    Route::get('app-all-courses-for-nav-tabs', [AppApiController::class, 'allCoursesForNavTabs']);

    Route::get('batch-exam-details/{xm_id}', [AppApiController::class, 'showBatchDetailsWithSections']);
    Route::post('place-app-product-order', [AppApiController::class, 'placeProductOrder']);

    Route::get('get-all-batch-exams', [AppApiController::class, 'getAllBatchDetails']);

    Route::post('/send-password-reset-otp', [CustomAuthController::class, 'passResetOtp'])->name('send-password-reset-otp');
    Route::post('/verify-pass-reset-otp', [CustomAuthController::class, 'verifyPassResetOtp'])->name('verify-pass-reset-otp');
    Route::get('/check-app-version', [AppVarsionController::class, 'checkVersion']);

    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function (){
        Route::get('app-get-course-sections/{id}', [AppApiController::class, 'getCourseSections']);
        Route::get('app-get-course-section-contents/{id}', [AppApiController::class, 'getCourseSectionContents']);
        Route::get('app-get-course-section-content-details/{id}', [AppApiController::class, 'appCourseSectionContentDetails']);

        Route::get('show-course-exam-ranking/{content_id}/{slug?}', [FrontExamController::class, 'showCourseExamRanking']);
        Route::get('show-batch-exam-ranking/{content_id}/{slug?}', [FrontExamController::class, 'showBatchExamRanking']);


        Route::get('app-get-user-info', [AppApiController::class, 'getUserInfo']);
        Route::get('get-comments/{model_id}/{type}', [AppApiController::class, 'getComments']);

        Route::get('start-course-exam/{content_id}/{slug?}', [AppApiControllerTwo::class, 'startcourseExam']);
        Route::get('start-batch-exam/{content_id}/{slug?}', [AppApiControllerTwo::class, 'startBatchExam']);
        Route::get('start-class-exam/{content_id}/{slug?}', [AppApiControllerTwo::class, 'startClassExam']);
        Route::get('exist-assignment-status/{content_id}', [AppApiControllerTwo::class, 'checkIfAssignmentExist']);

    });

});
