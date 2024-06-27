<?php

namespace App\Http\Controllers\AppApi;

use App\helper\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\BatchExamManagement\BatchExam;
use App\Models\Backend\BatchExamManagement\BatchExamResult;
use App\Models\Backend\Course\Course;
use App\Models\Backend\Course\CourseCategory;
use App\Models\Backend\Course\CourseExamResult;
use App\Models\Backend\Course\CourseSectionContent;
use App\Models\Backend\OrderManagement\ParentOrder;
use App\Models\Backend\ProductManagement\Product;
use App\Models\Backend\UserManagement\Student;
use App\Models\Backend\UserManagement\Teacher;
use App\Models\Frontend\AdditionalFeature\ContactMessage;
use App\Models\Backend\ExamManagement\AssignmentFile;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use function Nette\Utils\data;

class AppApiController extends Controller
{
    protected $course, $courses = [], $courseCategories = [], $courseCategory, $courseSections = [], $courseSectionContent, $courseSectionContents = [], $date = [];
    protected $comments = [], $exams = [], $loggedUser;

    public function placeProductOrder (Request $request)
    {
        try {
            foreach ($request->product_orders as $product_order)
            {
                ParentOrder::create([
                    'parent_model_id'           => $product_order['id'],
                    'user_id'                   => auth('sanctum')->id(),
                    'order_invoice_number'      => ParentOrder::generateOrderNumber(),
                    'ordered_for'               => 'product',
                    'payment_method'            => $product_order['payment_method'],
                    'vendor'                    => $product_order['vendor'] ?? null,
                    'paid_to'                   => $product_order['paid_to'] ?? '',
                    'paid_from'                 => $product_order['paid_from'] ?? '',
                    'txt_id'                    => $product_order['txt_id'] ?? '',
//            'paid_amount'   => $request->paid_amount,
                    'total_amount'              => $product_order['price'],
                    'status'                    => $product_order['payment_method'] == 'ssl' ? 'approved' : 'pending',
                    'shipping_address'          => $product_order['shipping_address'] ?? null,
                    'notes'                     => $product_order['notes'] ?? null,
                    'delivery_charge'           => $product_order['delivery_charge'] ?? 0,
                ]);
            }
            return response()->json(['success' => 'Product orders submitted successfully.']);
        } catch (\Exception $exception)
        {
            return response()->json($exception->getMessage());
        }
    }

    public function courseDetails($id, $slug = null)
    {
        $this->course = Course::whereId($id)
            ->select('id', 'title', 'sub_title', 'price', 'banner', 'description', 'starting_date_time', 'ending_date_time', 'discount_type', 'discount_amount', 'total_video', 'total_class', 'total_note', 'total_exam', 'is_paid', 'status', 'discount_start_date', 'discount_end_date', 'admission_last_date')->with([
            'teachers'   => function($teachers) {
                $teachers->select('id', 'user_id', 'subject', 'first_name', 'last_name', 'image')->with(['user' => function($user){
//                    $user->select('id', 'name', 'email')->first();
                }])->get();
            },
            'courseSections' => function($courseSections) {
                $courseSections->whereStatus(1)->select('id', 'course_id', 'title', 'available_at', 'is_paid', 'status')->get()->except(['created_at', 'updated_at']);
            }
        ])->first();
        $courseEnrollStatus = ViewHelper::checkIfCourseIsEnrolled($this->course);
        if (isset($this->course))
        {
            $this->comments = ContactMessage::where(['status' => 1, 'type' => 'course', 'parent_model_id' => $this->course->id, 'is_seen' => 1])->get();
        }
        return response()->json(['course' => $this->course, 'courseEnrollStatus' => $courseEnrollStatus, 'comments'  => $this->comments]);
    }

    public function allCourses()
    {
        $this->courseCategories = CourseCategory::whereStatus(1)->where('parent_id', 0)->select('id', 'name', 'slug')->with(['courses' => function($course){
            $course->whereStatus(1)->select('id','title','sub_title','price','banner', 'slug')->latest()->get();
        },
            'courseCategories' => function($courseCategories) {
                $courseCategories->select('id', 'parent_id', 'name', 'image', 'slug')->whereStatus(1)->get();
            }])->get();
        return response()->json(['courseCategories' => $this->courseCategories]);
    }

    public function allCoursesForNavTabs()
    {
        $this->courses = Course::whereStatus(1)->select('id','title','sub_title','price','banner', 'slug')->latest()->get();
        return response()->json(['courses' => $this->courses]);
    }

    public function courseCategoryResources($id, $slug = null)
    {
        $this->courseCategories = CourseCategory::where('parent_id', $id)->whereStatus(1)->select('id', 'parent_id', 'name', 'image')->get();
        foreach($this->courseCategories as $courseCategory)
        {
            $courseCategory->image = asset($courseCategory->image);
        }
        return response()->json(['courseCategories' => $this->courseCategories]);
    }

    public function CategoryCoursesResources($id, $slug = null)
    {
        $this->courseCategory = CourseCategory::where('id', $id)->whereStatus(1)->select('id','name')->with(['courses' => function($courses){
            $courses->select('id', 'title', 'sub_title', 'banner', 'price')->whereStatus(1)->get();
        }])->first();

            foreach($this->courseCategory->courses as $course)
            {
                $course->banner = asset($course->banner);
            }
        return response()->json(['courses' => $this->courseCategory->courses]);
    }

    public function getCourseSections ($courseId)
    {
        $this->course = Course::whereId($courseId)->select('id', 'title', 'slug', 'status')->with(['courseSections' => function($courseSections){
            $courseSections->whereStatus(1)->where('available_at', '<=', Carbon::now()->format('Y-m-d H:i'))->select('id', 'course_id', 'title', 'available_at', 'is_paid')->get();
        }])->first();
        return response()->json(['courseSections' => $this->course]);
    }

    public function getCourseSectionContents($courseSectionId)
    {
        $this->courseSectionContents = CourseSectionContent::where(['course_section_id' => $courseSectionId, 'status' => 1])->select('id', 'course_section_id', 'title', 'is_paid', 'has_class_xm')->get();
        return response()->json(['courseSectionContents' => $this->courseSectionContents]);
    }

    public function appCourseSectionContentDetails($contentId)
    {
        $this->courseSectionContent = CourseSectionContent::find($contentId);
        $this->courseSectionContent->note_content = strip_tags($this->courseSectionContent->note_content);
        $this->courseSectionContent->pdf_file = asset($this->courseSectionContent->pdf_file);
        return response()->json(['courseSectionContentDetails' => $this->courseSectionContent]);
    }

    public function showBatchDetailsWithSections ($batchExamId)
    {
            $this->exam = BatchExam::whereId($batchExamId)->select('id', 'title', 'slug', 'status')->with(['batchExamSections' => function($batchExamSections){
                $batchExamSections->where('available_at', '<=', Carbon::now()->format('Y-m-d H:i'))->whereStatus(1)->select('id', 'batch_exam_id', 'title', 'available_at', 'is_paid')->get();
            }])->first();

            $this->data = [
                'batchExam'    => $this->exam
            ];
            return response()->json($this->data);
    }

    public function getUserInfo()
    {
        $isStudent = false;
        $isTeacher = false;
        $user = auth()->user();
        if (!empty($user->roles))
        {
            foreach ($user->roles as $role)
            {
                if ($role->id == 4)
                {
                    $isStudent = true;
                } elseif ($role->id == 3)
                {
                    $isTeacher = true;
                }
            }
        }
        try {
            if ($isStudent)
            {
                $this->data = [
                    'student'   => Student::whereUserId($user->id)->first(),
                    'user'      => $user
                ];
            } elseif ($isTeacher)
            {
                $this->data = [
                    'teacher'   => Teacher::whereUserId($user->id)->first(),
                    'user'      => $user
                ];
            }
            if (!empty($this->data))
            {
                return response()->json($this->data);
            } else {
                return response()->json(['error' => 'Nothing found! Please Try Again.']);
            }
        } catch (\Exception $exception)
        {
            return response()->json(['error' => 'Login as a student or teacher to update Profile Info in this page.']);
        }
    }

    public function getComments($modelId, $type = 'course')
    {
        $this->comments = ContactMessage::where(['parent_model_id' => $modelId, 'type' => $type, 'is_seen' => 1])->select('id', 'user_id', 'parent_model_id', 'type', 'name', 'message', 'is_seen', 'status', 'created_at')->with(['user' => function($user) {
            $user->select('id','name','profile_photo_path')->get();
        },
            'contactMessages' => function($contactMessages){
            $contactMessages->select('id', 'user_id', 'parent_model_id', 'type', 'name', 'message', 'is_seen', 'status', 'created_at')->get();
            }])->get();
        return response()->json(['comments' => $this->comments]);
    }

    public function getAllBatchDetails()
    {
        $this->loggedUser = ViewHelper::loggedUser();

        $batchExams = BatchExam::where('status', 1)->get();
        $finalArray = [];
        $i = 0;
        foreach ($batchExams as $key => $item)
        {
            if ($item->is_master_exam != "1")
            {
                $finalArray[$i]['batch_exam'] = [];
                $finalArray[$i]['welcome'] = $i;
                $item->has_validity = ViewHelper::checkIfBatchExamIsEnrollmentAndHasValidity($this->loggedUser, $item);
                $item->order_status = ViewHelper::checkUserBatchExamIsEnrollment($this->loggedUser, $item);
                $finalArray[$i]['batch_exam']    = $item;
                $i++;
            }
        }

        $this->data = [
            'exams' => $finalArray
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.student.my-pages.exams');
    }
    
    
}
