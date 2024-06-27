<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\CustomAuth\CustomAuthController;
use App\Http\Controllers\PaymentController;
use League\Flysystem\Filesystem;
use Obs\ObsClient;
use Zing\Flysystem\Obs\ObsAdapter;
use Illuminate\Http\Request;
use App\Models\Backend\Course\Course;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Backend\AdditionalFeatureManagement\Advertisement;
use Illuminate\Http\File;
use App\Models\Backend\ExamManagement\AssignmentFile;
use App\Models\Backend\BatchExamManagement\BatchExam;
use App\Models\Backend\BatchExamManagement\BatchExamCategory;
use App\Models\Backend\BatchExamManagement\BatchExamSectionContent;
use App\Models\Backend\BlogManagement\Blog;
use App\Models\Backend\BlogManagement\BlogCategory;
use App\Models\Backend\CircularManagement\Circular;
use App\Models\Backend\CircularManagement\CircularCategory;
use App\Models\Backend\Course\CourseCategory;
use App\Models\Backend\ExamManagement\Exam;
use App\Models\Backend\ExamManagement\ExamCategory;
use App\Models\Backend\Gallery\Gallery;
use App\Models\Backend\Gallery\GalleryImage;
use App\Models\Learner;
use App\Models\Backend\ModelTestManagement\ModelTest;
use App\Models\Backend\ModelTestManagement\ModelTestCategory;
use App\Models\Backend\NoticeManagement\Notice;
use App\Models\Backend\NoticeManagement\NoticeCategory;
use App\Models\Backend\AdditionalFeatureManagement\NumberCounter\NumberCounter;
use App\Models\Backend\AdditionalFeatureManagement\OurService\OurService;
use App\Models\Backend\AdditionalFeatureManagement\OurTeam\OurTeam;
use App\Models\Backend\PdfManagement\PdfStore;
// use DB;
use App\Models\Backend\AdditionalFeatureManagement\PopupNotification;
use App\Models\Backend\ProductManagement\Product;
use App\Models\Backend\ProductManagement\ProductAuthor;
use App\Models\Backend\ProductManagement\ProductCategory;
use App\Models\Backend\ProductManagement\ProductDeliveryOption;
use App\Models\Backend\QuestionManagement\QuestionStore;
use App\Models\Backend\AdditionalFeatureManagement\SiteSetting;
use App\Models\Backend\UserManagement\Student;
use App\Models\Backend\AdditionalFeatureManagement\StudentOpinion\StudentOpinion;
use App\Models\Backend\UserManagement\Teacher;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/ttt', function(){
    $prefix = '';
    $config = [
        'key' => '7NBPYLX5IMJMXEVUAMJR',
        'secret' => 'k8PDyRPK94ZXjtoZExxCqqEXD8HI4jN63qCtJW0Z',
        'bucket' => 'biddabari-bucket',
        'endpoint' => 'obs.as-south-208.rcloud.reddotdigitalit.com',
    ];

    $config['options'] = [
        'url' => '',
        'endpoint' => $config['endpoint'],
        'bucket_endpoint' => 'https://biddabari-bucket.obs.as-south-208.rcloud.reddotdigitalit.com',
        'temporary_url' => '',
    ];

    $data = User::all();

    // dd($data[23]);

    foreach ($data as $key => $value) {
        # code...
        $client = new ObsClient($config);
        $adapter = new ObsAdapter($client, $config['bucket'], $prefix, null, null, $config['options']);
        $flysystem = new Filesystem($adapter);

        // $f = asset($value->image);
        if ($value->profile_photo_path != null) {
            # code...

        if (file_exists($value->profile_photo_path)) {
            $result = $client->putObject([
            'Bucket' => env('OBS_BUCKET'),
            'Key' => $value->profile_photo_path,
            'SourceFile' => $value->profile_photo_path,
            ]);
            }
        }


            // return response()->json(['url' => $result['ObjectURL']]);


        }



});

Route::post('/register', [CustomAuthController::class, 'register'])->name('register');
Route::post('/login', [CustomAuthController::class, 'login'])->name('login');
Route::get('/login', function (){
    return view('backend.auth.admin-login');
})->name('custom-login');
Route::get('/register-page', function (){
    return view('backend.auth.admin-register');
})->name('custom-register');
Route::get('/forgot-user-password', [CustomAuthController::class, 'forgotPassword'])->name('forgot-user-password');
Route::post('/send-password-reset-otp', [CustomAuthController::class, 'passResetOtp'])->name('send-password-reset-otp');
Route::get('/password-reset-otp', [CustomAuthController::class, 'passwordResetOtp'])->name('password-reset-otp');
Route::post('/verify-pass-reset-otp', [CustomAuthController::class, 'verifyPassResetOtp'])->name('verify-pass-reset-otp');


//Route::post('sslcommerz/success',[PaymentController::class, 'success'])->name('payment.success');
//Route::post('sslcommerz/failure',[PaymentController::class, 'failure'])->name('payment.failure');
//Route::post('sslcommerz/cancel',[PaymentController::class, 'cancel'])->name('payment.cancel');
//Route::post('sslcommerz/ipn',[PaymentController::class, 'ipn'])->name('payment.ipn');

Route::get('form',[PaymentController::class, 'form'])->name('form');
Route::post('form-order',[PaymentController::class, 'order'])->name('form-order');


/**
 * @return void
 */

/* clear all cache */
Route::get('/clear-all', function () {
    Artisan::call('optimize:clear');
    echo Artisan::output();
});
Route::get('/clear-all-cache', function () {
    Artisan::call('optimize:clear');
    return redirect()->back()->with('success', 'Cache cleared successfully' );
})->name('clear-all-cache');
//example one
Route::get('/a', function () {
    shell_exec('convert '. public_path('backend/assets/uploaded-files/course-xm-temp-file-upload/tmp--1711188856692.jpg').' '.public_path('backend/assets/uploaded-files/course-xm-temp-file-upload/tmp-1709199042765.jpg').' '.public_path('backend/assets/uploaded-files/course-written-xm-ans-files/dd.pdf'));
//   shell_exec('php artisan make:model A');
   echo 'a';
});
/* migration */
Route::get('/migrate',function(){
    Artisan::call('migrate');
    echo Artisan::output();
});

Route::get('/migrate-seed',function(){
    Artisan::call('migrate --seed');
    echo Artisan::output();
});

Route::get('/migrate-fresh-seed',function(){
    Artisan::call('migrate:fresh --seed');
    echo Artisan::output();
});

/* migration rollback */
Route::get('/migrate-rollback',function(){
    Artisan::call('migrate:rollback');
    echo Artisan::output();
});

/* create symbolic link */
Route::get('/symlink', function () {
    Artisan::call('storage:link');
    echo Artisan::output();
});
/* Optimize files */
Route::get('/optimize', function () {
    Artisan::call('optimize');
    echo Artisan::output();
});
/* clear view cache */
Route::get('/clear-view-cache', function () {
    Artisan::call('view:clear');
    return 'View Cache Cleared';
});
/* clear route cache */
Route::get('/clear-route-cache', function () {
    Artisan::call('route:clear');
    return 'Route Cache Cleared';
});
/* Only db seed */
Route::get('/only-db-seed', function () {
    Artisan::call('db:seed');
    return 'DB Seed successful';
});

Route::get('/phpinfo', function () {
    phpinfo();
});



