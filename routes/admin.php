<?php

use App\Http\Controllers\Backend\Service\ServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\RolePermissionManagement\Permission\PermissionCategoryController;
use App\Http\Controllers\Backend\ViewControllers\AdminViewController;
use App\Http\Controllers\Backend\RolePermissionManagement\Permission\PermissionController;
use App\Http\Controllers\Backend\RolePermissionManagement\Role\RoleController;
use App\Http\Controllers\Backend\UserManagement\RegularUser\UserController;
use App\Http\Controllers\Backend\CourseManagement\Course\CourseCategoryController;
use App\Http\Controllers\Backend\CourseManagement\Course\CourseController;
use App\Http\Controllers\Backend\CourseManagement\Course\CourseRoutineController;
use App\Http\Controllers\Backend\CourseManagement\Course\CourseCouponController;
use App\Http\Controllers\Backend\CourseManagement\Course\CourseSectionController;
use App\Http\Controllers\Backend\CourseManagement\Course\CourseSectionContentController;
use App\Http\Controllers\Backend\PdfManagement\PdfStoreCategoryController;
use App\Http\Controllers\Backend\PdfManagement\PdfStoreController;
use App\Http\Controllers\Backend\CourseManagement\Question\QuestionTopicController;
use App\Http\Controllers\Backend\CourseManagement\Question\QuestionStoreController;
use App\Http\Controllers\Backend\BlogManagement\BlogCategoryController;
use App\Http\Controllers\Backend\BlogManagement\BlogController;
use App\Http\Controllers\Backend\JobCircularManagement\JobCircularCategoryController;
use App\Http\Controllers\Backend\JobCircularManagement\JobCircularController;
use App\Http\Controllers\Backend\AdditionalFeatureManagement\PopupNotification\PopupNotificationsController;
use App\Http\Controllers\Backend\AdditionalFeatureManagement\Advertisement\AdvertisementController;
use App\Http\Controllers\Backend\NoticeManagement\NoticeCategoryController;
use App\Http\Controllers\Backend\NoticeManagement\NoticeController;
use App\Http\Controllers\Backend\ModelTestManagement\ModelTestCategoryController;
use App\Http\Controllers\Backend\ModelTestManagement\ModelTestController;
use App\Http\Controllers\Backend\ProductManagement\ProductController;
use App\Http\Controllers\Backend\ProductManagement\ProductAuthorsController;
use App\Http\Controllers\Backend\ProductManagement\ProductCategoryController;
use App\Http\Controllers\Backend\ExamManagement\ExamCategoryController;
use App\Http\Controllers\Backend\ExamManagement\ExamController;
use App\Http\Controllers\Backend\BatchExamManagement\BatchExamCategoryController;
use App\Http\Controllers\Backend\BatchExamManagement\BatchExamController;
use App\Http\Controllers\Backend\BatchExamManagement\BatchExamRoutineController;
use App\Http\Controllers\Backend\BatchExamManagement\BatchExamSectionController;
use App\Http\Controllers\Backend\BatchExamManagement\BatchExamSectionContentController;
use App\Http\Controllers\Backend\AdditionalFeatureManagement\Gallery\GalleryController;
use App\Http\Controllers\Backend\AdditionalFeatureManagement\Contact\ContactController;
use App\Http\Controllers\Backend\OrderManagement\PaymentController;
use App\Http\Controllers\Backend\OrderManagement\AllOrdersController;
use App\Http\Controllers\Backend\OrderManagement\CourseOrderController;
use App\Http\Controllers\Backend\OrderManagement\ExamOrderController;
use App\Http\Controllers\Backend\OrderManagement\ExamSubscriptionPackageOrderController;
use App\Http\Controllers\Backend\OrderManagement\ProductOrderController;
use App\Http\Controllers\Backend\ExamManagement\ExamSubscriptionPackageController;
use App\Http\Controllers\Backend\OrderManagement\DeliveryOptionController;
use App\Http\Controllers\Backend\AdditionalFeatureManagement\SiteSettings\SiteSettingsController;
use App\Http\Controllers\Backend\AdditionalFeatureManagement\Affiliation\AffiliationController;
use App\Http\Controllers\Backend\AdditionalFeatureManagement\NumberCounter\NumberCounterController;
use App\Http\Controllers\Backend\AdditionalFeatureManagement\OurTeam\OurTeamController;
use App\Http\Controllers\Backend\AdditionalFeatureManagement\OurServices\OurServicesController;
use App\Http\Controllers\Backend\AdditionalFeatureManagement\StudentOpinion\StudentOpinionController;
use App\Http\Controllers\Backend\SEO\SeoController;
use App\Http\Controllers\Backend\AppVarsion\AppVarsionController;
use App\Http\Controllers\Backend\BkashController;
use App\Http\Controllers\Backend\UserManagement\TeacherProfileController;

Route::post('create/bkash',[BkashController::class,'createPayment'])->name('bkash-create-payment');
Route::get('/bkash/pay',[BkashController::class,'callBack'])->name('excute_payment');
//Route::post('/bkash/callback', [App\Http\Controllers\BkashTokenizePaymentController::class,'callBack'])->name('bkash-callBack');

Route::get('/test', function (){
    return \App\Models\Backend\Course\Course::find(795)->students;
    return view('bkash-temp');

    exec('convert '.public_path('backend/e.jpg').' '.public_path('backend/e.pdf'));
    exit();
    return bcrypt('superadmin');
    return view('backend.single-view.dashboard.dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'single.device'
])->group(function () {
    Route::get('/dashboard', [AdminViewController::class, 'dashboard'])->name('dashboard');

    //    App Varsion Management
    Route::resource('app-varsions',AppVarsionController::class);

//    Role Management
    Route::resources([
        'permission-categories' => PermissionCategoryController::class,
        'permissions' => PermissionController::class,
        'roles' => RoleController::class,
        'users' => UserController::class,
    ]);


    //    User Profile Management
    Route::get('/view-profile', [UserController::class, 'viewProfile'])->name('view-profile');
    Route::get('/all-users-page', [UserController::class, 'allUsersPage'])->name('all-users-page');

    //    Seo Management
    Route::resource('seos',SeoController::class);
    Route::get('/select_seofor/{seofor}',[SeoController::class,'select_seofor'])->name('select_seofor');

//    Course Management
    Route::resources([
        'course-categories' => CourseCategoryController::class,
        'courses' => CourseController::class,
        'course-routines'   => CourseRoutineController::class,
        'course-coupons'   => CourseCouponController::class,
        'course-sections'   => CourseSectionController::class,
        'course-section-contents'   => CourseSectionContentController::class,
    ]);

    Route::resource('teachers_profile', TeacherProfileController::class);

    Route::resource('my_services',ServiceController::class);
    Route::get('my_service', [ServiceController::class, 'myService'])->name('my_service');

    Route::post('/course-categories/update/{id}', [CourseCategoryController::class, 'update'])->name('course-categories.update');
    Route::post('course-categories/save-nested-categories', [CourseCategoryController::class, 'saveNestedCategories'])->name('courseCategories.saveNestedCategories');
    Route::post('courses/save-nested-categories', [CourseController::class, 'saveNestedCourses'])->name('courses.saveNestedCategories');
    Route::post('course-sections-contents/save-nested-categories', [CourseController::class, 'saveNestedSectionsAndContents'])->name('course.saveNestedSectionsAndContents');
    Route::get('/get-content-for-add-question', [CourseSectionContentController::class, 'getContentForAddQuestion'])->name('get-content-for-add-question');
    Route::get('/get-content-for-add-class-question', [CourseSectionContentController::class, 'getContentForAddClassQuestion'])->name('get-content-for-add-class-question');
    Route::get('/get-ques-by-topic', [CourseSectionContentController::class, 'getQuesByTopic'])->name('get-ques-by-topic');
    Route::post('/assign-question-to-content', [CourseSectionContentController::class, 'assignQuestionToContent'])->name('assign-question-to-content');
    Route::post('/assign-question-to-class-content', [CourseSectionContentController::class, 'assignQuestionToClassContent'])->name('assign-question-to-class-content');
    Route::get('/detach-question-from-course-content', [CourseSectionContentController::class, 'detachQuestionFromCourseContent'])->name('detach-question-from-course-content');
    Route::get('/detach-question-from-course-class-content', [CourseSectionContentController::class, 'detachQuestionFromCourseClassContent'])->name('detach-question-from-course-class-content');
    Route::get('/get-xm-participants/{xm_model}/{model_id}', [CourseSectionContentController::class, 'getXmParticipants'])->name('get-xm-participants');

    Route::get('/get-xm-for-add-question', [ExamController::class, 'getXmForAddQuestion'])->name('get-xm-for-add-question');
    Route::post('/assign-question-to-exam', [ExamController::class, 'assignQuestionToExam'])->name('assign-question-to-exam');

    Route::get('/export-course-json/{model}/{model_id}', [CourseController::class, 'exportCourseJson'])->name('export-course-json');
    Route::post('/import-model-json/{model}', [CourseController::class, 'importModelJson'])->name('import-model-json');

    Route::get('/content-exam-ranking-download-page/{req_from}/{content_id}', [ExamController::class, 'contentExamRankingDownloadPage'])->name('content-exam-ranking-download-page');
    Route::get('/show-xm-attendance/{req_from}/{content_id}', [ExamController::class, 'showXmAttendance'])->name('show-xm-attendance');

    //    Assign Teacher student to course
    Route::get('assign-teacher-to-course/{course_id}/{title?}', [CourseController::class, 'assignTeacherToCourse'])->name('assign-teacher-to-course');
    Route::post('assign-teacher/{course_id}', [CourseController::class, 'assignTeacher'])->name('assign-teacher');
    Route::post('detach-teacher/{course_id}', [CourseController::class, 'detachTeacher'])->name('detach-teacher');
//    Assign student to course
    Route::get('assign-student-to-course/{course_id}/{title?}', [CourseController::class, 'assignStudentToCourse'])->name('assign-student-to-course');
    Route::post('transfer-student/{course_transfer_to_id}', [CourseController::class, 'assignStudent'])->name('transfer-student');
    Route::post('assign-new-student/{course_id}', [CourseController::class, 'assignNewStudent'])->name('assign-new-student');
    Route::post('detach-student/{course_id}', [CourseController::class, 'detachStudent'])->name('detach-student');


    Route::get('search-student-ajax', [CourseController::class, 'searchStudentAjax'])->name('search-student-ajax');



//    Batch Exam Management
    Route::resources([
        'batch-exam-categories' => BatchExamCategoryController::class,
        'batch-exams' => BatchExamController::class,
        'batch-exam-routines' => BatchExamRoutineController::class,
        'batch-exam-sections' => BatchExamSectionController::class,
        'batch-exam-section-contents' => BatchExamSectionContentController::class,
    ]);
    Route::get('show-master-exam', [BatchExamController::class, 'showMasterExam'])->name('show-master-exam');
    Route::post('batch-exam-categories/save-nested-categories', [BatchExamCategoryController::class, 'saveNestedCategories'])->name('batchExamCategories.saveNestedCategories');
    Route::post('/batch-exam-categories/update/{id}', [BatchExamCategoryController::class, 'update'])->name('batch-exam-categories.update');
    Route::get('/get-batch-exam-content-for-add-question', [BatchExamSectionContentController::class, 'getContentForAddQuestion'])->name('get-batch-exam-content-for-add-question');
    Route::get('/detach-question-from-content', [BatchExamSectionContentController::class, 'detachQuestionFromContent'])->name('detach-question-from-content');
    Route::post('/assign-question-to-batch-exam-content', [BatchExamSectionContentController::class, 'assignQuestionToContent'])->name('assign-question-to-batch-exam-content');

    //    Assign Teacher student to Batch Exams
    Route::get('assign-teacher-to-batch-exam/{batch_exam_id}', [BatchExamController::class, 'assignTeacherToBatchExam'])->name('assign-teacher-to-batch-exam');
    Route::post('assign-batch-exam-teacher/{batch_exam_id}', [BatchExamController::class, 'assignTeacher'])->name('assign-batch-exam-teacher');
    Route::post('detach-batch-exam-teacher/{batch_exam_id}', [BatchExamController::class, 'detachTeacher'])->name('detach-batch-exam-teacher');
//    Assign student to Batch Exams
    Route::get('assign-student-to-batch-exam/{batch_exam_id}', [BatchExamController::class, 'assignStudentToBatchExam'])->name('assign-student-to-batch-exam');
    Route::post('assign-batch-exam-student/{batch_exam_id}', [BatchExamController::class, 'assignStudent'])->name('assign-batch-exam-student');
    Route::post('assign-batch-exam-new-student/{batch_exam_id}', [BatchExamController::class, 'assignNewStudent'])->name('assign-batch-exam-new-student');
    Route::post('detach-batch-exam-student/{batch_exam_id}', [BatchExamController::class, 'detachStudent'])->name('detach-batch-exam-student');

//    PDF Management
    Route::resources([
        'pdf-store-categories'    => PdfStoreCategoryController::class,
        'pdf-stores'    => PdfStoreController::class,
    ]);
    Route::post('/pdf-store-categories/update/{id}', [PdfStoreCategoryController::class, 'update'])->name('pdf-store-categories.update');
    Route::post('pdf-store-categories/save-nested-categories', [PdfStoreCategoryController::class, 'saveNestedCategories'])->name('pdfCategories.saveNestedCategories');
    Route::get('get-pdf-by-cat/{id}', [PdfStoreCategoryController::class, 'getCatWisePdf'])->name('get-pdf-by-cat');
    Route::get('get-pdf-store-file/{id}', [PdfStoreController::class, 'getPdfStoreFile'])->name('get-pdf-store-file');

//    order management
    Route::resources([
        'all-orders' => AllOrdersController::class,
        'course-orders' => CourseOrderController::class,
        'exam-orders' => ExamOrderController::class,
        'product-orders' => ProductOrderController::class,
        'subscription-orders' => ExamSubscriptionPackageOrderController::class,
        'payments' => PaymentController::class,
        'delivery-options' => DeliveryOptionController::class,
    ]);
    Route::post('/get-course-orders', [CourseOrderController::class, 'getCourseOrders'])->name('get-course-orders');
    Route::get('/get-course-order-details/{id}', [CourseOrderController::class, 'getCourseOrderDetails'])->name('get-course-order-details');
    Route::post('/course-orders/status/{id}', [CourseOrderController::class, 'changeContactStatus'])->name('course-orders-status-update');
    Route::post('/exam-orders/status/{id}', [ExamOrderController::class, 'changeContactStatus'])->name('exam-orders-status-update');
    Route::get('/get-order-details/{id}', [AllOrdersController::class, 'getCourseOrderDetails'])->name('get-order-details');

    Route::resources([
        'question-topics' => QuestionTopicController::class,
        'question-stores' => QuestionStoreController::class,
    ]);
    Route::post('/question-import/{topic_id}/{type}', [QuestionStoreController::class, 'questionImport'])->name('question-import');
    Route::get('/export-questions/{topic_id}/{type}', [QuestionStoreController::class, 'questionExport'])->name('export-questions');

    Route::resources([
        'blog-categories'   => BlogCategoryController::class,
        'blogs'             => BlogController::class,
    ]);
    Route::post('/blog-categories/update/{id}', [BlogCategoryController::class, 'update'])->name('blog-categories.update');
    Route::post('blog-categories/save-nested-categories', [BlogCategoryController::class, 'saveNestedCategories'])->name('blogCategories.saveNestedCategories');

    Route::resources([
        'circular-categories'   => JobCircularCategoryController::class,
        'circulars'             => JobCircularController::class,
    ]);
    Route::post('/circular-categories/update/{id}', [JobCircularCategoryController::class, 'update'])->name('circular-categories.update');
    Route::post('circular-categories/save-nested-categories', [JobCircularCategoryController::class, 'saveNestedCategories'])->name('circularCategories.saveNestedCategories');

    Route::resources([
        'popup-notifications'   => PopupNotificationsController::class,
        'advertisements'   => AdvertisementController::class,
        'site-settings'   => SiteSettingsController::class,
        'number-counters'   => NumberCounterController::class,
        'our-teams'   => OurTeamController::class,
        'our-services'   => OurServicesController::class,
        'student-opinions'   => StudentOpinionController::class,
    ]);

    //    Notice Management -- done By Riad --need check
    Route::resources([
        'notice-categories'   => NoticeCategoryController::class,
        'notices'             => NoticeController::class,
    ]);
    Route::post('notice-categories/update/{id}', [NoticeCategoryController::class, 'update'])->name('notice-category.update');
    Route::get('notice-categories/add-sub-categories/{id}', [NoticeCategoryController::class, 'addSubCategory'])->name('notice-sub-category.add');
    Route::post('notices/update/{id}', [NoticeController::class, 'update'])->name('notice.update');

    //    Model Test Management -- done by riad -- need check
    Route::resources([
        'model-test-categories'   => ModelTestCategoryController::class,
        'model-tests'             => ModelTestController::class,
    ]);
    Route::post('model-test-categories/update/{id}', [ModelTestCategoryController::class, 'update'])->name('model-test-category.update');
    Route::get('model-test-categories/add-sub-category/{id}', [ModelTestCategoryController::class, 'addSubCategory'])->name('model-test-sub-category.add');
    Route::post('model-tests/update/{id}', [ModelTestController::class, 'update'])->name('model-test.update');

    //    Product Management -- done by foysal vai
    Route::resources([
        'product-categories'   => ProductCategoryController::class,
        'product-authors'   => ProductAuthorsController::class,
        'products'   => ProductController::class,
    ]);

//    exam-management section
    Route::resources([
        'exam-categories'   => ExamCategoryController::class,
        'exams'   => ExamController::class,
        'exam-subscriptions'   => ExamSubscriptionPackageController::class,
    ]);
    Route::get('/get-exams-by-category/{id}', [ExamController::class, 'getExamsByCategory'])->name('get-exams-by-category');
    Route::get('/get-courses-by-category/{id}', [CourseController::class, 'getCoursesByCategory'])->name('get-courses-by-category');
    Route::get('/show-exam-sheet', [ExamController::class, 'showExamSheet'])->name('show-exam-sheet');
    Route::get('/get-course-or-batch-exam-names/{xmOf}', [ExamController::class, 'getCourseOrExamNames'])->name('get-course-or-batch-exam-names');
    Route::get('/get-exam-names/{xmOf}/{typeId}', [ExamController::class, 'getExamNames'])->name('get-exam-names');
    Route::get('/get-written-section-contents/{xmOf}/{sectionId}/{sectionContentType}', [ExamController::class, 'getWrittenSectionContents'])->name('get-written-section-contents');
    Route::get('/get-exam-sheet-data/{id}', [ExamController::class, 'getExamSheet'])->name('get-exam-sheet');
    Route::get('/check-xm-paper/{id}/{typeOf?}/{sectionContentType?}', [ExamController::class, 'checkExamPaper'])->name('check-xm-paper');
    Route::post('/update-exam-result/{id}/{examOf?}/{sectionContentType?}', [ExamController::class, 'updateWrittenExamResult'])->name('update-written-xm-result');
    Route::post('/update-exam-sheet', [ExamController::class, 'updateExamResult'])->name('update-xm-result');
    Route::post('/exam-categories/update/{id}', [ExamCategoryController::class, 'update'])->name('exam-categories.update');
    Route::post('exam-categories/save-nested-categories', [ExamCategoryController::class, 'saveNestedCategories'])->name('examCategories.saveNestedCategories');
    Route::post('exams/get-questions-for-exam', [ExamController::class, 'getQuestionsForExam'])->name('get-questions-for-exam');
    Route::post('change-status', [AdminViewController::class, 'changeStatus'])->name('change-status');

    Route::resources([
        'galleries' =>  GalleryController::class,
        'contacts' =>  ContactController::class,
    ]);
    Route::post('/gallery-add-images', [GalleryController::class, 'addImages'])->name('galleries.add-images');
    Route::get('/galleries/get-images/{id}', [GalleryController::class, 'getImages'])->name('galleries.get-images');
    Route::get('/galleries/delete-image/{id}', [GalleryController::class, 'deleteImage'])->name('galleries.delete-image');
    Route::get('/change-order-number/{model_name?}/{model_id?}/{order?}', [BatchExamSectionController::class, 'changeOrderNumber'])->name('change-order-number');

    Route::get('/show-affiliate-users', [AffiliationController::class, 'showAffiliationHistory'])->name('show-affiliation-registrations');
    Route::get('/show-affiliate-history/{id}', [AffiliationController::class, 'showAffiliateHistory'])->name('show-affiliate-history');
});
