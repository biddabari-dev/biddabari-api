<?php

namespace App\Http\Controllers\Frontend\Pages;

use App\helper\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\AdditionalFeatureManagement\Advertisement;
use App\Models\Backend\AdditionalFeatureManagement\NumberCounter\NumberCounter;
use App\Models\Backend\AdditionalFeatureManagement\OurService\OurService;
use App\Models\Backend\AdditionalFeatureManagement\OurTeam\OurTeam;
use App\Models\Backend\AdditionalFeatureManagement\PopupNotification;
use App\Models\Backend\AdditionalFeatureManagement\StudentOpinion\StudentOpinion;
use App\Models\Backend\BatchExamManagement\BatchExam;
use App\Models\Backend\BatchExamManagement\BatchExamSubscription;
use App\Models\Backend\BlogManagement\Blog;
use App\Models\Backend\BlogManagement\BlogCategory;
use App\Models\Backend\CircularManagement\Circular;
use App\Models\Backend\Course\CategoryWIseAssignVideo;
use App\Models\Backend\Course\Course;
use App\Models\Backend\Course\CourseCategory;
use App\Models\Backend\Course\CourseCoupon;
use App\Models\Backend\ExamManagement\Exam;
use App\Models\Backend\ExamManagement\ExamCategory;
use App\Models\Backend\Gallery\Gallery;
use App\Models\Backend\Gallery\GalleryImage;
use App\Models\Backend\NoticeManagement\Notice;
use App\Models\Backend\OrderManagement\ParentOrder;
use App\Models\Backend\ProductManagement\Product;
use App\Models\Backend\UserManagement\Teacher;
use App\Models\Frontend\AdditionalFeature\ContactMessage;
use App\Models\Frontend\CourseOrder\CourseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BasicViewController extends Controller
{
    protected $courseCategories, $courseCategory, $courses, $course, $courseCoupon, $courseCoupons = [], $teachers = [], $blogs = [], $blogCategories = [], $blog, $blogCategory;
    protected $message, $status, $notices = [], $notice, $products = [], $product, $data, $exams = [], $examCategories = [], $homeSliderCourses = [];
    protected $comments = [], $galleries = [], $galleryImage, $batchExams = [];
    public function home ()
    {

        // $this->batchExams  = BatchExam::where(['status' => 1, 'is_master_exam' => 0, 'is_paid' => 1])->select('id', 'title', 'banner', 'slug')->take(6)->get();
        $this->courseCategories = CourseCategory::whereStatus(1)->where('parent_id', 0)->orderBy('order', 'ASC')->select('id', 'name', 'image', 'slug', 'icon', 'order', 'status')->take(8)->get();
        $this->courses = Course::whereStatus(1)->where(['is_featured' => 1])->latest()->select('id', 'title', 'sub_title', 'price', 'banner', 'total_video', 'total_audio', 'total_pdf', 'total_exam', 'total_note', 'total_zip', 'total_live', 'total_link','total_file','total_written_exam', 'slug', 'discount_type', 'discount_amount', 'starting_date_time','admission_last_date','alt_text','banner_title')->take(9)->get();
        foreach ($this->courses as $course)
        {
            $course->order_status = ViewHelper::checkIfCourseIsEnrolled($course);
        }
        $this->products = Product::whereStatus(1)->latest()->select('id', 'title', 'image', 'slug', 'description','stock_amount','price', 'slug')->take(8)->get();
//        $this->homeSliderCourses = Course::where('show_home_slider', 1)->select('id', 'slug', 'title', 'banner', 'description')->get();
        $this->homeSliderCourses = Advertisement::whereStatus(1)->whereContentType('course')->select('id', 'title', 'content_type', 'description','link','image')->take(6)->get();
        $this->data = [
            'courseCategories'  => $this->courseCategories,
            'courses'           => $this->courses,
            'products'          => $this->products,
            'homeSliderCourses' => $this->homeSliderCourses,
            // 'batchExams'        => $this->batchExams,
            'numberCounters'    => NumberCounter::whereStatus(1)->select('id', 'label', 'icon_code', 'total_number','image')->get(),
            'ourServices'       => OurService::whereStatus(1)->select('id', 'icon_code', 'image', 'title','content')->get(),
            'ourTeams'          => OurTeam::whereStatus(1)->where(['content_show_type' => 'home_page'])->select('id', 'name', 'designation', 'image','content_show_type','video_link','video_file')->get(),
            'studentOpinions'   => StudentOpinion::whereStatus(1)->select('id', 'show_type', 'name', 'image','comment')->get(),
            'poppup'            => PopupNotification::where('status', 1)->first(),
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.home.home');
    }
    public function appHome ()
    {
        $this->courseCategories = CourseCategory::whereStatus(1)->where('parent_id', 0)->latest()->orderBy('order', 'ASC')->select('id', 'name', 'image', 'slug')->get();
        $this->courses = Course::whereStatus(1)->latest()->select('id', 'title', 'sub_title', 'price', 'banner','alt_text','banner_title')->take(8)->get();
        $this->products = Product::whereStatus(1)->latest()->select('id', 'title', 'image', 'price')->take(8)->get();
        $this->notices = Notice::whereStatus(1)->whereType('scroll')->latest()->select('id', 'title', 'image', 'body')->get();
        $this->homeSliderCourses = Advertisement::whereStatus(1)->whereContentType('course')->take(5)->select('id', 'title', 'image', 'link', 'description')->get();
        $this->data = [
            'courseCategories'  => $this->courseCategories,
            'courses'           => $this->courses,
            'products'          => $this->products,
            'homeSliderCourses' => $this->homeSliderCourses,
            'scrollNotices'     => $this->notices
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.home.home');
    }

    public function appHomeCourseCategories ()
    {
        $data = CourseCategory::whereStatus(1)->where('parent_id', 0)->orderBy('order', 'ASC')->select('id', 'name', 'image', 'slug')->get();
        foreach ($data as $datum)
        {
            $datum->image = asset($datum->image);
        }
        return response()->json(['courseCategories' => $data]);
    }

    public function appHomeCourses ()
    {
        $data = Course::whereStatus(1)->where('is_featured', 1)->latest()->select('id', 'title', 'sub_title', 'price', 'banner', 'discount_type', 'discount_amount', 'discount_start_date', 'discount_end_date','alt_text','banner_title')->take(8)->get();
        foreach ($data as $datum)
        {
            $datum->banner = asset($datum->banner);
            $datum->order_status = ViewHelper::checkIfCourseIsEnrolled($datum);
        }
        return response()->json(['courses' => $data]);
    }

    public function appHomeProducts ()
    {
        $data = Product::whereStatus(1)->latest()->select('id', 'title', 'image', 'price', 'stock_amount','slug')->get();
        foreach ($data as $datum)
        {
            $datum->image = asset($datum->image);
        }
        return response()->json(['products' => $data]);
    }

    public function appHomeNotices ()
    {
        $data = Notice::whereStatus(1)->whereType('scroll')->latest()->select('id', 'title', 'image', 'body')->get();
        foreach ($data as $datum)
        {
            $datum->image = asset($datum->image);
            $datum->body    = strip_tags($datum->body);
        }
        return response()->json([
            'notices' => $data,
            'poppup'  => PopupNotification::where('status', 1)->first(),
        ]);
    }

    public function appHomeSliderCourses()
    {
        $data = Advertisement::whereStatus(1)
            ->whereContentType('course')
            ->take(5)
            ->select('id', 'title', 'content_type', 'image', 'link', 'description')
            ->get();

        foreach ($data as $datum) {
            $datum->image = asset($datum->image);

            if ($datum->content_type == 'course') {
                $path = parse_url($datum->link, PHP_URL_PATH);
                $slug = basename($path);
                $course = Course::where('slug', $slug)->first();
                $datum->parent_model_id = $course->id ?? null;
            } elseif ($datum->content_type == 'book') {
                $path = parse_url($datum->link, PHP_URL_PATH);
                $slug = basename($path);
                $book = Product::where('slug', $slug)->first();
                $datum->parent_model_id = $book->id ?? null;
            }
        }

        return response()->json(['sliderCourses' => $data]);
    }


    public function appHomePopupNotification()
    {
        $this->data = PopupNotification::where('status', 1)->first();
        return response()->json(['popupNotification' => $this->data]);
    }

    public function allCourses (Request $request)
    {
       // Fetch the required course categories and their first course
        $this->courseCategories  = CourseCategory::whereStatus(1)->where('parent_id', 0)->orderBy('order', 'ASC')->select('id', 'name', 'image', 'slug', 'icon', 'order', 'status')->take(8)->get();

        // Fetch the featured courses directly without looping, using only necessary fields
        $courses = Course::where('status', 1)
            ->where('is_featured', 1)
            ->select('id', 'title', 'sub_title', 'price', 'banner', 'total_video', 'total_audio', 'total_pdf', 'total_exam', 'total_note', 'total_zip', 'total_live', 'total_link', 'total_file', 'total_written_exam', 'slug', 'discount_type', 'discount_amount', 'starting_date_time', 'admission_last_date', 'alt_text', 'banner_title', 'discount_start_date', 'discount_end_date')
            ->orderBy('id','DESC')
            ->paginate(12);

        $this->homeSliderCourses = Advertisement::whereStatus(1)->whereContentType('course')->select('id', 'title', 'content_type', 'description','link','image')->take(6)->get();

        return response()->json([
            'courseCategories' => $this->courseCategories,
            'courses' => $courses,
            'course_sliders' => $this->homeSliderCourses,
        ],200);
    }

    public function categoryCourses ($slug)
    {
        $this->courseCategory = CourseCategory::whereSlug($slug)->select('id','name', 'parent_id', 'image', 'icon', 'slug', 'status')->with(['courses' => function($course){
            $course->whereStatus(1)->latest()->select('id','title','price','banner','total_pdf','total_exam','total_live','discount_amount','discount_type', 'admission_last_date', 'slug','alt_text','banner_title')->get()->makeHidden('updated_at');
        },
            'courseCategories' => function($courseCategories){
                $courseCategories->whereStatus(1)->orderBy('order','ASC')->select('id', 'parent_id','name', 'image', 'icon', 'slug', 'status')->get();
            }])->first();
        foreach ($this->courseCategory->courses as $course)
        {
            $course->order_status = ViewHelper::checkIfCourseIsEnrolled($course);
        }
        $this->data = ['courseCategory' => $this->courseCategory];
        return ViewHelper::checkViewForApi($this->data, 'frontend.courses.course-category', 'Category Not Found');
    }


    public function courseDetails($id)
    {
        $course = Course::where('id', $id)->select('id', 'slug')->first();
        if (!$course) {
            return response()->json([
                'status'   => false,
                'message'   => "Data not found!",
            ], 404);
        }

        $courseEnrollStatus = ViewHelper::checkIfCourseIsEnrolled($course);

        if ($courseEnrollStatus === 'true') {
            return redirect()->route('front.student.course-contents', ['course_id' => $course->id, 'slug' => $course->slug]);
        }
        $this->course = Course::where('id', $id)
            ->with([
                'teachers:id,user_id,subject,first_name,last_name,description,image,teacher_intro_video,github',
                'courseRoutines' => function ($courseRoutines) {
                    $courseRoutines->whereStatus(1)->get();
                }
            ])->first();

        if ($this->course) {
            $this->comments = ContactMessage::where(['status' => 1, 'type' => 'course', 'parent_model_id' => $this->course->id, 'is_seen' => 1])->get();
        }

        if (!empty($this->course->discount_start_date) && !empty($this->course->discount_end_date))
        {
            if (Carbon::now()->between(dateTimeFormatYmdHi($this->course->discount_start_date), dateTimeFormatYmdHi($this->course->discount_end_date)))
            {
                $this->course->has_discount_validity = 'true';
            } else {
                $this->course->has_discount_validity = 'false';
            }
        } else {

            $this->course->has_discount_validity = 'false';
        }
        $totalStudentEnrollments = DB::table('batch_exam_student')->where('batch_exam_id', $course->id)->count('student_id');

        $courseSec = Course::whereId($course->id)
            ->select('id', 'title', 'slug', 'status')
            ->with(['courseSections' => function($courseSections){
               $courseSections->whereStatus(1)
                   ->where('available_at', '<=', currentDateTimeYmdHi())
                   ->orderBy('order', 'ASC')
                   ->select('id', 'course_id', 'title', 'available_at', 'is_paid')
                   ->with(['courseSectionContents' => function($courseSectionContents){
                      $courseSectionContents->where('available_at_timestamp', '<=', strtotime(currentDateTimeYmdHi()))
                          ->where('content_type', 'video')
                          ->whereStatus(1)
                          ->orderBy('order', 'ASC')
                          ->get();
            }]);
        }])->first();

        return response()->json([
            'course' => $this->course,
            'courseEnrollStatus' => $courseEnrollStatus,
            'reviews' => $this->comments,
            'courseSec' => $courseSec,
            'totalStudentEnrollments' => $totalStudentEnrollments
        ],200);

    }

    public function checkout (Request $request, $type = 'course',  $slug = null)
    {
        if ($type == 'course')
        {
            $this->course = Course::whereSlug($slug)->select('id', 'title', 'price','discount_amount', 'discount_type', 'discount_end_date_timestamp')->first();
        } elseif ($type == 'batch_exam')
        {
            $this->course = BatchExam::whereSlug($slug)->select('id', 'title')->first();
        }

        if (auth()->check())
        {
            if ($type == 'course')
            {
                $existUser = ParentOrder::where(['user_id' => ViewHelper::loggedUser()->id, 'ordered_for' => 'course', 'parent_model_id' => $this->course->id])->where('status', '!=', 'canceled')->first();

            } elseif ($type == 'batch_exam')
            {
                $existUser = ParentOrder::where(['user_id' => ViewHelper::loggedUser()->id, 'ordered_for' => 'batch_exam', 'parent_model_id' => $this->course->id])->where('status', '!=', 'canceled')->first();
            }
            if (!empty($existUser))
            {
                if (str()->contains(url()->current(), '/api/'))
                {
                    return response()->json('Sorry. You already enrolled this course.', 400);
                }
                return back()->with('error', 'Sorry. You already enrolled this course.');
            }

        }
//        for course
        if (!empty($this->course))
        {
            if ($type == 'course')
            {
                if ($this->course->discount_end_date_timestamp > strtotime(currentDateTimeYmdHi()))
                {
                    if ($this->course->discount_type == 1)
                    {
                        $this->course->total_amount_after_discount = $this->course->price - $this->course->discount_amount;
                    } elseif ($this->course->discount_type == 2)
                    {
                        $this->course->total_amount_after_discount = $this->course->price - (($this->course->price * $this->course->discount_amount)/100);
                    }
                } else {
                    $this->course->total_amount_after_discount  = $this->course->price;
                }
            } elseif ($type == 'batch_exam')
            {
                if (empty($request->si))
                {
                    return ViewHelper::returEexceptionError('Please Select a Package First');
                }
                $batchExamSubscription = BatchExamSubscription::find($request->si);
                if ($batchExamSubscription->discount_end_date_timestamp > strtotime(currentDateTimeYmdHi()))
                {
                    if ($batchExamSubscription->discount_type == 1)
                    {
                        $batchExamSubscription->total_amount_after_discount = $batchExamSubscription->price - $batchExamSubscription->discount_amount;
                    } elseif ($batchExamSubscription->discount_type == 2)
                    {
                        $batchExamSubscription->total_amount_after_discount = $batchExamSubscription->price - (($batchExamSubscription->price * $batchExamSubscription->discount_amount)/100);
                    }
                } else {
                    $batchExamSubscription->total_amount_after_discount  = $batchExamSubscription->price;
                }
                $this->course->total_amount_after_discount  = $batchExamSubscription->total_amount_after_discount;
            }

            $this->data = [
                'reqFor'  => $type,
                'course'    => $this->course,
                'batch_exam_subscription_id'    => $request->si
//                    'discountStatus'   => dateTimeFormatYmdHi($this->course->discount_start_date) < currentDateTimeYmdHi() && dateTimeFormatYmdHi($this->course->discount_end_date) > currentDateTimeYmdHi() ? 'valid' : 'not-valid'
//                'discountStatus'   => isset($this->course->discount_start_date) && !empty($this->course->discount_start_date) ? (dateTimeFormatYmdHi($this->course->discount_start_date) < currentDateTimeYmdHi() && dateTimeFormatYmdHi($this->course->discount_end_date) > currentDateTimeYmdHi() ? 'valid' : 'not-valid') : 'not-valid'
            ];
            return ViewHelper::checkViewForApi($this->data, 'frontend.courses.checkout');
        } else {
            if (str()->contains(url()->current(), '/api/'))
            {
                return response()->json($type.' Not Found', 400);
            } else {
                return back()->with('error', $type.' Not Found');
            }
        }


        return redirect()->back()->with('Something went wrong. Please try agian.');
    }


    public function allNotices ()
    {
        $this->notices = Notice::whereStatus(1)->whereType('normal')->latest()->select('id', 'notice_category_id','title', 'image', 'type', 'body', 'created_at', 'updated_at')->take(6)->get();
        foreach ($this->notices as $notice)
        {
            $notice->image = asset($notice->image);
        }
        $this->data = [
            'notices'    => $this->notices,
//            'singleNotice'  => isset($_GET['notice-id']) ? Notice::find($_GET['notice-id']) : ''
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.notice.notice');
    }

    public function noticeDetails($id, $slug = null)
    {
        $this->notice = Notice::find($id);
        if (str()->contains(url()->current(), '/api/'))
        {
            $this->notice->image = asset($this->notice->image);
        }
        return response()->json($this->notice);
    }

    public function freeCourses ()
    {
        $this->courseCategories = CourseCategory::where('parent_id', 0)->where('name', '!=', 'Free Course')->select('id', 'name', 'slug','image','second_image')->get();

        $this->data = [
            'freeCategories'     => $this->courseCategories,
        ];
        return ViewHelper::checkViewForApi($this->data);
    }

    public function popularCourse(){
        $this->courses = Course::whereStatus(1)->where(['is_popular' => 1])->latest()->select('id', 'title', 'sub_title', 'price', 'banner', 'total_video', 'total_audio', 'total_pdf', 'total_exam', 'total_note', 'total_zip', 'total_live', 'total_link','total_file','total_written_exam', 'slug', 'discount_type', 'discount_amount', 'starting_date_time','admission_last_date','alt_text','banner_title')->take(12)->get();
        return response()->json([
            'popular_courses' => $this->courses,
        ],200);
    }

    public function freeCourseVideo($slug){

        $category = CourseCategory::where('slug',$slug)->first();
        $results = CategoryWIseAssignVideo::with('categoryVideo:id,title,video_link')->where('category_id', $category->id)->where('type','video')->get();
        $exams = CategoryWIseAssignVideo::with('categoryExam')->where('category_id', $category->id)->where('type','exam')->get();
        $this->data = [
            'free_class'   => $results,
            'free_exams'   => $exams
        ];
        return ViewHelper::checkViewForApi($this->data);
    }

    public function checkCoupon (Request $request)
    {
        try {
            $this->courseCoupons = CourseCoupon::whereCourseId($request->course_id)->select('id','course_id','code','type','percentage_value','discount_amount','flat_discount','note','expire_date_time','expire_date_time_timestamp','available_from','avaliable_from_timestamp','avaliable_to','avaliable_to_timestamp')->get();
            if (count($this->courseCoupons) > 0)
            {
                foreach ($this->courseCoupons as $courseCoupon)
                {
//                    return response()->json(Carbon::parse($courseCoupon->available_from)->format('d-m-Y H:i'));
//                    return response()->json(Carbon::now()->format('d-m-Y H:i'));
                    if ($courseCoupon->code == $request->coupon_code)
                    {
//                        if (session()->has('valid_used_coupon'))
//                        {
//                            if (session()->get('valid_used_coupon') == $request->coupon_code)
//                            {
//                                return response()->json([
//                                    'status'     => 'false',
//                                    'message'    => 'code already used for this course',
//                                ]);
//                            }
//                        }
//                        if (Carbon::parse($courseCoupon->available_from)->format('Y-m-d H:i') < Carbon::now()->format('Y-m-d H:i') && Carbon::parse($courseCoupon->expire_date_time)->format('d-m-Y H:i') > Carbon::now()->format('d-m-Y H:i'))
                        if (dateTimeFormatYmdHi($courseCoupon->available_from) < currentDateTimeYmdHi() && dateTimeFormatYmdHi($courseCoupon->expire_date_time) > currentDateTimeYmdHi())
                        {
                            $this->status = 'true';
                            $this->message = 'Thanks for using coupon code.';
//                            $couponAmount = $courseCoupon->discount_amount;
                            $currentTotal = $request->current_total - $courseCoupon->discount_amount;
//                            session()->put('valid_used_coupon', $courseCoupon->code);
                            return response()->json([
                                'status'    => $this->status,
                                'message'    => $this->message,
                                'coupon'    => $courseCoupon,
                                'currentTotal'  => $currentTotal
//                            'coupon_amount' => $couponAmount
                            ]);
                        } else {
                            $this->status = 'false';
                            $this->message = 'Sorry!! Coupon Expired.';
                            return response()->json([
                                'status'    => $this->status,
                                'message'    => $this->message,
                            ]);
                        }
                    } else {
                        $this->status = 'false';
                        $this->message = 'Sorry!! Coupon Mismatched.';
                        return response()->json([
                            'status'    => $this->status,
                            'message'    => $this->message,
                        ]);
                    }
                }
            } else {
                $this->status = 'false';
                $this->message = 'Sorry!! Coupon not found.';
                return response()->json([
                    'status'    => $this->status,
                    'message'    => $this->message,
                ]);
            }
        } catch (\Exception $exception)
        {
            return response()->json($exception->getMessage());
        }

    }

    public function contact ()
    {
        return view('frontend.basic-pages.contact');
    }


    public function aboutUs ()
    {
        return view('frontend.basic-pages.about', [
            'ourTeams'   => OurTeam::where(['content_show_type' => 'about_us_page', 'status' => 1])->get(['id', 'name', 'designation', 'image']),
        ]);
    }

    public function termsConditions ()
    {
        return view('frontend.basic-pages.terms-conditions');
    }

    public function privacy ()
    {
        return view('frontend.basic-pages.privacy');
    }

    public function searchContentHome(Request $request)
    {

        $this->courses  = Course::where("title", "LIKE", "%".$request->search_content."%")->whereStatus(1)->select('id', 'title', 'sub_title', 'price', 'banner', 'total_video', 'total_audio', 'total_pdf', 'total_exam', 'total_note', 'total_zip', 'total_live', 'total_link','total_file','total_written_exam', 'slug', 'discount_type', 'discount_amount', 'starting_date_time','alt_text','banner_title')->get();
        $this->exams = $this->batchExams  = BatchExam::where("title", "LIKE", "%".$request->search_content."%")->where(['status' => 1, 'is_master_exam' => 0])->select('id', 'title', 'banner', 'slug')->get();
        $this->products = Product::where("title", "LIKE", "%".$request->search_content."%")->whereStatus(1)->select('id','product_author_id', 'stock_amount','title','image','price', 'discount_amount', 'discount_start_date', 'discount_end_date', 'slug')->get();
        return response()->json([
            'courses'       => $this->courses,
            'batchExams'    => $this->exams,
            'products'    => $this->products,
        ], 200);

    }

    public function freeService(){
        $this->courseCategories = CourseCategory::where('parent_id', 0)->where('name', '!=', 'Free Course')->select('id', 'name', 'slug','second_image')->get();
        return response()->json([
            'courseCategories'     => $this->courseCategories,
        ], 200);
    }

    public function freeServiceContent($slug){

        $category = CourseCategory::where('slug',$slug)->first();
        $free_class_videos = CategoryWIseAssignVideo::with('categoryVideo:id,title,video_link')->where('category_id', $category->id)->where('type','video')->get();
        $free_exams = CategoryWIseAssignVideo::with('categoryExam')->where('category_id', $category->id)->where('type','exam')->get();

        return response()->json([
            'free_class_videos' => $free_class_videos,
            'free_exams'        => $free_exams,
        ], 200);

    }
}
