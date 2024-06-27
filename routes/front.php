<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\Pages\BasicViewController;
use App\Http\Controllers\Frontend\Pages\FrontendViewController;
use App\Http\Controllers\Frontend\Pages\FrontViewTwoController;

use App\Http\Controllers\Frontend\Checkout\CheckoutController;
use App\Http\Controllers\Frontend\Student\StudentController;
use App\Http\Controllers\CustomAuth\CustomAuthController;
use App\Http\Controllers\Frontend\FrontExam\FrontExamController;
use App\Http\Controllers\Backend\ExamManagement\ExamSubscriptionPackageController;
use App\Http\Controllers\Backend\UserManagement\RegularUser\UserController;
use App\Http\Controllers\Backend\CourseManagement\Course\CourseController;

use App\Http\Controllers\Backend\AdditionalFeatureManagement\Affiliation\AffiliationController;

use App\Http\Controllers\SqlScriptController;

route::get('/assign-role',[CourseController::class,'assign_role']);


Route::get('import', function(){
    return view('import');
});

Route::post('imports',[CourseController::class,'import']);


//sarowar sql script start
Route::get('/sqluser',[SqlScriptController::class,'script'])->name('sqlscript');
Route::get('/sqlbatchstudent/{id}',[SqlScriptController::class,'getbatchstudent'])->name('getbatchstudent');
Route::get('/sqlcours_section',[SqlScriptController::class,'sqlcours_section'])->name('sqlcours_section');
Route::get('/course_section_data',[SqlScriptController::class,'course_section_data'])->name('course_section_data');
Route::get('/studentdelete',[SqlScriptController::class,'studentdelete'])->name('studentdelete');
Route::get('/coursecreate',[SqlScriptController::class,'coursecreate'])->name('coursecreate');
Route::get('/course_content_delete/{id?}',[SqlScriptController::class,'course_content_delete'])->name('course_content_delete');
//sarowar sql script end

Route::post('/search-content-home', [BasicViewController::class, 'searchContentHome'])->name('search-content-home');
Route::get('/exam-test', [FrontExamController::class, 'xmTestForDev'])->name('exm-test-for-dev');
Route::get('/pdf-view-test', [FrontExamController::class, 'pdfViewTest'])->name('pdf-view-test');

//payment gateway routes
Route::post('sslcommerz/success',[CheckoutController::class, 'paymentSuccess'])->name('payment.success');
Route::post('sslcommerz/failure',[CheckoutController::class, 'paymentFailure'])->name('payment.failure');
Route::post('sslcommerz/cancel',[CheckoutController::class, 'paymentCancel'])->name('payment.cancel');
Route::post('sslcommerz/ipn',[CheckoutController::class, 'ipn'])->name('payment.ipn');

Route::as('front.')->group(function (){


Route::middleware('previousUrlMiddleware')->group(function (){
        Route::get('/', [BasicViewController::class, 'home'])->name('home');
        Route::get('/course', [BasicViewController::class, 'allCourses'])->name('all-courses');
        Route::get('/details/{slug}', [BasicViewController::class, 'courseDetails'])->name('course-details');
        Route::get('/checkout/{type}/{slug}', [BasicViewController::class, 'checkout'])->name('checkout');

        Route::get('/category/{slug}', [BasicViewController::class, 'categoryCourses'])->name('category-courses');
        Route::get('/notice', [BasicViewController::class, 'allNotices'])->name('notices');


        Route::get('/free-course', [BasicViewController::class, 'freeCourses'])->name('free-courses');
        Route::get('/exam', [FrontExamController::class, 'showAllExams'])->name('all-exams');
        Route::get('/view-exam-details/{xm_id}/{slug?}', [FrontExamController::class, 'viewExamDetails'])->name('view-exam');

        Route::get('/subscription-details/{id}/{slug?}', [ExamSubscriptionPackageController::class, 'details'])->name('subscription-details');

        Route::get('/blog', [FrontendViewController::class, 'allBLogs'])->name('all-blogs');
        Route::get('/category-blogs/{id}/{slug?}', [FrontendViewController::class, 'categoryBlogs'])->name('category-blogs');
        Route::get('/blog-details/{id}/{slug?}', [FrontendViewController::class, 'blogDetails'])->name('blog-details');
        Route::get('/product', [FrontendViewController::class, 'allProducts'])->name('all-products');

        Route::get('/view-cart', [FrontendViewController::class, 'viewCart'])->name('view-cart');

        Route::get('/remove-from-cart/{id}', [FrontendViewController::class, 'removeFromCart'])->name('remove-from-cart');
        Route::get('/job-circular', [FrontendViewController::class, 'allJobCirculars'])->name('all-job-circulars');
        Route::get('/job-circular-details/{id}/{slug?}', [FrontendViewController::class, 'jobCircularDetail'])->name('job-circular-details');
        Route::get('/instructor', [FrontendViewController::class, 'instructors'])->name('instructors');
        Route::get('/instructor-details/{id}/{slug?}', [FrontendViewController::class, 'instructorDetails'])->name('instructor-details');

        //    basic page routes
        Route::get('/about-us', [BasicViewController::class, 'aboutUs'])->name('about-us');
        Route::get('/terms-and-conditions', [BasicViewController::class, 'termsConditions'])->name('terms-conditions');
        Route::get('/privacy-policy', [BasicViewController::class, 'privacy'])->name('privacy-policy');
        Route::get('/contact-us', [BasicViewController::class, 'contact'])->name('contact-us');
        Route::get('/guideline', [FrontViewTwoController::class, 'guideline'])->name('guideline');
        Route::get('/gallery', [FrontViewTwoController::class, 'GalleryImageView'])->name('all-gallery-images');
        Route::get('/gallery-images/{id}/{title?}', [FrontViewTwoController::class, 'GalleryImages'])->name('show-gallery-images');

        Route::get('/product-details/{id}/{slug?}', [FrontendViewController::class, 'productDetails'])->name('product-details');
    });

    Route::get('/check-coupon', [BasicViewController::class, 'checkCoupon'])->name('check-coupon');
    Route::get('/category-exams/{xm_cat_id}/{name?}', [FrontExamController::class, 'categoryExams'])->name('category-exams');

    Route::post('/send-otp', [CustomAuthController::class, 'sendOtp'])->name('send-otp');
    Route::post('/verify-otp', [CustomAuthController::class, 'verifyOtp'])->name('verify-otp');

    Route::post('/place-product-order', [FrontendViewController::class, 'placeProductOrder'])->name('place-product-order');


    Route::post('/add-to-cart', [FrontendViewController::class, 'addToCart'])->name('add-to-cart');
     Route::post('/add-to-cart-home', [FrontendViewController::class, 'addToCarthome'])->name('add-to-cart-home');




    Route::post('/new-comment', [FrontendViewController::class, 'newComment'])->middleware('auth')->name('new-comment');

    Route::get('show-product-pdf/{content_id}', [StudentController::class, 'showProductPdf'])->name('show-product-pdf');
    Route::get('get-video-comments/{content_id}/{type?}', [StudentController::class, 'getVideoComments'])->name('get-video-comments');

    Route::post('/common-order/{model_id}', [CheckoutController::class, 'commonOrder'])->name('common-order');




    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
//        'single.device'
    ])->group(function (){
        Route::post('/place-course-order/{course_id}', [CheckoutController::class, 'placeCourseOrder'])->name('place-course-order');
        Route::post('/place-free-course-order/{course_id}', [CheckoutController::class, 'placeFreeCourseOrder'])->name('place-free-course-order');
        Route::post('/contact', [FrontendViewController::class, 'newContact'])->name('contact');
        Route::prefix('student')->name('student.')->group(function (){
            Route::get('dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
            Route::get('my-courses', [StudentController::class, 'myCourses'])->name('my-courses');
            Route::get('my-exams', [StudentController::class, 'myExams'])->name('my-exams');
            Route::get('my-orders', [StudentController::class, 'myOrders'])->name('my-orders');
            Route::get('my_service', [StudentController::class, 'myService'])->name('my_service');
            Route::get('my-products', [StudentController::class, 'myProducts'])->name('my-products');
            Route::get('view-profile', [StudentController::class, 'viewProfile'])->name('view-profile');
            Route::get('change-password', [StudentController::class, 'studentChangePassword'])->name('change-password');
            Route::get('show-pdf/{content_id}/{type?}', [StudentController::class, 'showPdf'])->name('show-pdf');
            Route::get('batch-exam-show-pdf/{content_id}', [StudentController::class, 'batchExamShowPdf'])->name('batch-exam-show-pdf');
            Route::get('show-batch-exam-pdf/{content_id}', [StudentController::class, 'showBatchExamPdf'])->name('show-batch-exam-pdf');
            Route::get('course-contents/{course_id}/{slug?}', [StudentController::class, 'showCourseContents'])->name('course-contents');
            Route::get('batch-exam-contents/{xm_id}/{master?}/{slug?}', [StudentController::class, 'showBatchExamContents'])->name('batch-exam-contents');
            Route::post('profile-update', [StudentController::class, 'profileUpdate'])->name('profile-update');
            Route::get('get-text-type-content', [StudentController::class, 'getTextTypeContent'])->name('get-text-type-content');
            Route::get('show-class-exam-ajax', [StudentController::class, 'showClassXmAjax'])->name('show-class-exam-ajax');
            Route::get('get-batch-exam-text-type-content', [StudentController::class, 'getBatchExamTextTypeContent'])->name('get-batch-exam-text-type-content');

            Route::post('change-password/{id}', [UserController::class, 'studentChangePassword'])->name('change-student-password');

            Route::get('start-exam/{xm_id}/{slug?}', [FrontExamController::class, 'startExam'])->name('start-exam');
            Route::get('start-course-exam/{content_id}/{slug?}', [FrontExamController::class, 'startcourseExam'])->name('start-course-exam');
            Route::get('start-batch-exam/{content_id}/{slug?}', [FrontExamController::class, 'startBatchExam'])->name('start-batch-exam');
            Route::get('start-class-exam/{content_id}/{slug?}', [FrontExamController::class, 'startClassExam'])->name('start-class-exam');
            Route::post('get-exam-result/{xm_id}/{slug?}', [FrontExamController::class, 'getExamResult'])->name('get-exam-result');
            Route::post('get-course-exam-result/{content_id}/{slug?}', [FrontExamController::class, 'getCourseExamResult'])->name('get-course-exam-result');
            Route::post('get-course-class-exam-result/{content_id}/{slug?}', [FrontExamController::class, 'getCourseClassExamResult'])->name('get-course-class-exam-result');
            Route::post('get-batch-exam-result/{content_id}/{slug?}', [FrontExamController::class, 'getBatchExamResult'])->name('get-batch-exam-result');
            Route::get('show-exam-result/{xm_id}/{xm_result_id?}', [FrontExamController::class, 'showExamResult'])->name('show-exam-result');
            Route::get('show-course-exam-result/{xm_id}/{xm_result_id?}', [FrontExamController::class, 'showCourseExamResult'])->name('show-course-exam-result');
            Route::get('show-course-class-exam-result/{xm_id}/{xm_result_id?}', [FrontExamController::class, 'showCourseClassExamResult'])->name('show-course-class-exam-result');
            Route::get('show-batch-exam-result/{xm_id}/{xm_result_id?}', [FrontExamController::class, 'showBatchExamResult'])->name('show-batch-exam-result');
            Route::post('order-exam/{xm_cat_id}', [FrontExamController::class, 'orderXm'])->name('order-exam');
            Route::post('order-subscription/{id}', [ExamSubscriptionPackageController::class, 'orderSubscription'])->name('order-subscription');
            Route::get('show-course-exam-answers/{content_id}/{slug?}', [FrontExamController::class, 'showCourseExamAnswers'])->name('show-course-exam-answers');
            Route::get('show-batch-exam-answers/{content_id}/{slug?}', [FrontExamController::class, 'showBatchExamAnswers'])->name('show-batch-exam-answers');
            Route::get('show-course-exam-ranking/{content_id}/{slug?}', [FrontExamController::class, 'showCourseExamRanking'])->name('show-course-exam-ranking');
            Route::get('show-batch-exam-ranking/{content_id}/{slug?}', [FrontExamController::class, 'showBatchExamRanking'])->name('show-batch-exam-ranking');
            Route::post('upload-assignment-files', [FrontExamController::class, 'uploadAssignmentFiles'])->name('upload-assignment-files');

            Route::get('today-classes', [FrontViewTwoController::class, 'todayClasses'])->name('today-classes');
            Route::get('today-exams', [FrontViewTwoController::class, 'todayExams'])->name('today-exams');
//            student affiliation
            Route::get('my-affiliation', [StudentController::class, 'myAffiliation'])->name('my-affiliation');
            Route::get('generate-user-affiliate-code', [AffiliationController::class, 'generateAffiliateCode'])->name('generate-user-affiliate-code');

            Route::get('student-notices', [StudentController::class, 'studentNotices'])->name('student-notices');

            Route::post('set-xm-start-status-to-server', [FrontExamController::class, 'setXmStartStatus'])->name('set-xm-start-status-to-server');
            Route::post('check-if-user-tries-to-reload', [FrontExamController::class, 'setXmDataToSession'])->name('check-if-user-tries-to-reload');
        });
    });
});

