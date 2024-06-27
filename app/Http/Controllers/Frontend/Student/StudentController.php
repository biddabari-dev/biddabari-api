<?php

namespace App\Http\Controllers\Frontend\Student;

use App\helper\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\AdditionalFeatureManagement\Affiliation\AffiliationHistory;
use App\Models\Backend\AdditionalFeatureManagement\Affiliation\AffiliationRegistration;
use App\Models\Backend\BatchExamManagement\BatchExam;
use App\Models\Backend\BatchExamManagement\BatchExamSectionContent;
use App\Models\Backend\BatchExamManagement\BatchExamSubscription;
use App\Models\Backend\Course\Course;
use App\Models\Backend\Course\CourseSection;
use App\Models\Backend\Course\CourseSectionContent;
use App\Models\Backend\ExamManagement\AssignmentFile;
use App\Models\Backend\ExamManagement\Exam;
use App\Models\Backend\ExamManagement\ExamCategory;
use App\Models\Backend\ExamManagement\ExamOrder;
use App\Models\Backend\NoticeManagement\Notice;
use App\Models\Backend\OrderManagement\ParentOrder;
use App\Models\Backend\ProductManagement\Product;
use App\Models\Backend\ProductManagement\ProductDeliveryOption;
use App\Models\Backend\UserManagement\Student;
use App\Models\Frontend\AdditionalFeature\ContactMessage;
use App\Models\Frontend\CourseOrder\CourseOrder;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    protected $data = [], $courseOrders = [], $myCourses = [], $myProfile, $myPayments = [], $loggedUser, $course, $courses = [], $courseSections, $notices = [];
    protected $hasValidSubscription, $exam, $exams = [], $tempExamArray = [], $examOrders = [], $order, $orders = [], $products = [], $product, $affiliateRegister;
    public function dashboard ()
    {
//        $isStudent = false;
        foreach (auth()->user()->roles as $role)
        {
            if ($role->id != 4)
            {
                return redirect('/')->with('error', 'You don\'t have student access.');
//                $isStudent = true;
            }
        }
//        if ($isStudent == false)
//        {
//            return redirect()->route('dashboard')->with('success', 'You logged in successfully.');
////            return back()->with('error', 'You don\'t have permission to view this page.');
//        }
        $this->orders = ParentOrder::whereUserId(auth()->id())->latest()->get();
        $totalEnrolledCourse = 0;
        $totalEnrolledExams = 0;
        $totalPurchasedProducts = 0;
        $totalPendingOrders = 0;
        foreach ($this->orders as $order)
        {
            if ($order->ordered_for == 'course' && $order->status == 'approved')
            {
                $totalEnrolledCourse++;
            }
            if ($order->ordered_for == 'batch_exam' && $order->status == 'approved')
            {
                $totalEnrolledExams++;
            }
            if ($order->ordered_for == 'product' && $order->status == 'approved')
            {
                $totalPurchasedProducts++;
            }
            if ($order->status == 'pending')
            {
                $totalPendingOrders++;
            }
        }
        $this->data = [
            'orders'    => $this->orders,
            'totalEnrolledCourse'    => $totalEnrolledCourse,
            'totalEnrolledExams'    => $totalEnrolledExams,
            'totalPurchasedProducts'    => $totalPurchasedProducts,
            'totalPendingOrders'    => $totalPendingOrders,
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.student.dashboard.dashboard');
    }

    public function myCourses ()
    {
        $this->courseOrders = ParentOrder::where(['user_id'=> auth()->id(), 'ordered_for' => 'course'])->where('status', '!=', 'canceled')->select('id', 'parent_model_id', 'user_id', 'status')->with('course:id,title,price,banner,slug,status')->get();
        $this->data = [
            'courseOrders'  => $this->courseOrders
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.student.course.courses');
    }

    public function showCourseContents ($courseId)
    {
        $this->course = Course::whereId($courseId)->select('id', 'title', 'slug', 'status')->with(['courseSections' => function($courseSections){
            $courseSections->whereStatus(1)->orderBy('order', 'ASC')->where('available_at', '<=', currentDateTimeYmdHi())->select('id', 'course_id', 'title', 'available_at', 'is_paid')->with(['courseSectionContents' => function($courseSectionContents){
                $courseSectionContents->where('available_at_timestamp', '<=', strtotime(currentDateTimeYmdHi()))->whereStatus(1)->orderBy('order', 'ASC')->get();
            }])->get();
        }])->first();

        foreach ($this->course->courseSections as $courseSection)
        {
            foreach ($courseSection->courseSectionContents as $courseSectionContent)
            {
                if ($courseSectionContent->has_class_xm == 1)
                {
                    $courseSectionContent->classXmStatus = ViewHelper::checkClassXmStatus($courseSectionContent);
                } else {
                    $courseSectionContent->classXmStatus = '0';
                }
            }
        }
        $this->data = [
            'course'    => $this->course
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.student.course.contents');
    }

    public function showBatchExamContents ($batchExamId, $isMaster , $slug = null)
    {
        if (base64_decode($isMaster) == 1)
        {
            $this->exams    = BatchExam::where('is_master_exam', 0)->whereStatus(1)->select('id', 'title', 'banner', 'slug', 'sub_title', 'is_paid', 'is_featured', 'is_approved', 'status', 'is_master_exam')->get();
            $this->data = [
                'allExams'  => $this->exams,
            ];
        } else {
            $this->exam = BatchExam::whereId($batchExamId)->select('id', 'title', 'slug', 'status')->with(['batchExamSections' => function($batchExamSections){
                $batchExamSections->orderBy('order', 'ASC')->where('available_at', '<=', currentDateTimeYmdHi())->whereStatus(1)->select('id', 'batch_exam_id', 'title', 'available_at', 'is_paid')->with(['batchExamSectionContents' => function($batchExamSectionContents){
                    $batchExamSectionContents->where('available_at_timestamp', '<=', strtotime(currentDateTimeYmdHi()))->whereStatus(1)->orderBy('order', 'ASC')->whereIsPaid(1)->get();
                }])->get();
            }])->first();

            $this->data = [
                'batchExam'    => $this->exam
            ];
        }

        return ViewHelper::checkViewForApi($this->data, 'frontend.student.batch-exam.contents');
    }

    public function myExams ()
    {
        $this->loggedUser = ViewHelper::loggedUser();
        $this->exams   = ParentOrder::where(['ordered_for' => 'batch_exam', 'user_id' => $this->loggedUser->id])->where('status', '!=', 'canceled')->with([
            'batchExam' => function($batchExam) {
                $batchExam->whereStatus(1)->select('id', 'title', 'banner', 'slug', 'sub_title', 'is_paid', 'is_featured', 'is_approved', 'status', 'is_master_exam')->get();
            }
        ])->select('id', 'user_id', 'parent_model_id', 'batch_exam_subscription_id', 'ordered_for', 'status')->get();
        foreach ($this->exams as $exam)
        {
            $exam->has_validity = ViewHelper::checkIfBatchExamIsEnrollmentAndHasValidity($this->loggedUser, $exam->batchExam);
            $exam->order_status = ViewHelper::checkUserBatchExamIsEnrollment($this->loggedUser, $exam->batchExam);
        }
        $this->data = [
            'exams' => $this->exams
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.student.my-pages.exams');
    }

    public function myProducts ()
    {
        $this->loggedUser = ViewHelper::loggedUser();
        $this->products   = ParentOrder::where(['ordered_for' => 'product', 'user_id' => $this->loggedUser->id])->with([
            'product' => function($product) {
                $product->whereStatus(1)->select('id', 'product_author_id', 'title', 'image', 'slug', 'featured_pdf', 'pdf')->with('productAuthor')->get();
            }
        ])->select('id', 'user_id', 'parent_model_id', 'batch_exam_subscription_id', 'ordered_for', 'status')->get();
        foreach ($this->products as $product)
        {
            $product->image = asset($product->image);
        }
        $this->data = [
            'products' => $this->products
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.student.my-pages.products');
    }

    protected function getNestedCategoryExams($examCategory)
    {
        if (!empty($examCategory))
        {
            if (!empty($examCategory->customExamCategories))
            {
                foreach ($examCategory->customExamCategories as $customExamCategory)
                {
                    foreach ($customExamCategory->exams as $exam)
                    {
                        array_push($this->exams, $exam);
                    }
                    $this->getNestedCategoryExams($customExamCategory);
                }
            }
        }
    }

    public function myOrders ()
    {
//        $this->courseOrders = CourseOrder::where('user_id', auth()->id())->select('id', 'course_id', 'user_id', 'status')->with('course:id,title,price')->get();
        $this->courseOrders = ParentOrder::where(['user_id' => auth()->id()])->select('id', 'parent_model_id', 'user_id', 'order_invoice_number', 'ordered_for', 'total_amount', 'paid_amount', 'payment_status', 'status')->with('course:id,title,price', 'batchExam:id,title,price','product:id,title,price')->get();
        $this->data = [
            'orders'  => $this->courseOrders
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.student.my-pages.orders');
    }

    public function myService(Request $request)
    {
        $user=[];
        $orders=[];
        $courses=[];
        $exams=[];
        $products=[];
        if (isset($request->search)){
            $user=User::where('mobile',$request->search)->first();
            $orders=ParentOrder::where('user_id',$user->id)->get();
            $courses=ParentOrder::where('user_id',$user->id)->where('ordered_for','course')->get();
            $exams=ParentOrder::where('user_id',$user->id)->where('ordered_for','batch_exam')->get();
            $products=ParentOrder::where('user_id',$user->id)->where('ordered_for','product')->get();
        }else{
            $user=[];
            $orders=[];
            $courses=[];
            $exams=[];
            $products=[];
        }

        return view('frontend.student.service.service',[
            'user'=>$user,
            'orders'=>$orders,
            'courses'=>$courses,
            'exams'=>$exams,
            'products'=>$products,
        ]);

    }

    public function viewProfile ()
    {
        $isStudent = false;
        $isTeacher = false;
        $isStuff = false;
        $user = auth()->user();
        if (!empty($user->roles))
        {
            foreach ($user->roles as $role)
            {
                if ($role->id == 4)
                {
                    $isStudent = true;
                }
            }
        }
        if (isset($isStudent) && $isStudent != true)
        {
            return redirect()->route('view-profile');
        }
        if ($isStudent)
        {
            $this->data = [
                'student'   => Student::whereUserId($user->id)->first(),
                'user'      => $user
            ];
            return ViewHelper::checkViewForApi($this->data, 'frontend.student.my-pages.profile');
        } else {
            if (str()->contains(url()->current(), '/api/'))
            {
                return response()->json(['error' => 'Login as a student to view this page']);
            }
            return back()->with('error', 'Login as a student to view this page');
        }

    }

    public function profileUpdate (Request $request)
    {
        $isStudent = false;
        $user = auth()->user();
        if (!empty($user->roles))
        {
            foreach ($user->roles as $role)
            {
                if ($role->id == 4)
                {
                    $isStudent = true;
                }
            }
        }
        if ($isStudent)
        {
            Student::createOrUpdateStudent($request, $user, Student::where('user_id', $user->id)->first()->id);
            User::updateStudent($request, auth()->id());
            if (str()->contains(url()->current(), '/api/'))
            {
                return response()->json(['success' => 'Profile Updated successfully.']);
            }
            return back()->with('success', 'Profile Updated successfully.');
        } else {
            return back()->with('error', 'Login as a student to update from this page');
        }
    }

    public function showPdf($contentId, $type = null)
    {
//        return $type;

        if (isset($type))
        {
            if ($type == 'assignment')
            {
                $sectionContent = AssignmentFile::where(['course_section_content_id' => $contentId, 'user_id' => ViewHelper::loggedUser()->id])->first();
                if (isset($sectionContent->file)){
                $sectionContent['featured_pdf'] = $sectionContent->file;
                }else{
                   return redirect()->back()->with('error','your file does not uploaded');
               }
            }
        } else {
            $sectionContent = CourseSectionContent::whereId($contentId)->select('id', 'course_section_id', 'content_type', 'title', 'pdf_link', 'pdf_file', 'status', 'can_download_pdf')->first();
        }
        $this->data = [
            'sectionContent'  => $sectionContent,
        ];
        if (\request()->ajax())
        {
            return response()->json($this->data);
        }
        return ViewHelper::checkViewForApi($this->data, 'frontend.student.course.contents.pdf');
    }
    public function showProductPdf($contentId)
    {
//        $this->data = [
//            'sectionContent'  => CourseSectionContent::whereId($contentId)->select('id', 'course_section_id', 'content_type', 'title', 'pdf_link', 'pdf_file', 'status')->first(),
//        ];
         $this->data = [
            'product'  => Product::whereId($contentId)->select('id', 'featured_pdf', 'status')->first(),
        ];
        if (\request()->ajax())
        {
            return response()->json($this->data);
        }
        return ViewHelper::checkViewForApi($this->data, 'frontend.student.course.contents.pdf');
    }

    public function getVideoComments($contentId, $type = null)
    {

        return view('frontend.student.course.contents.comment-div', [
            'comments'  => ContactMessage::where(['user_id' => auth()->id(), 'parent_model_id' => $contentId, 'is_seen' => 1])->get(),
            'contentId' => $contentId,
            'type'      => $type
        ]);
    }

    public function batchExamShowPdf($contentId)
    {
        $this->data = [
            'sectionContent'  => BatchExamSectionContent::whereId($contentId)->select('id', 'batch_exam_section_id', 'content_type', 'title', 'pdf_link', 'pdf_file', 'status')->first(),
        ];
        if (\request()->ajax())
        {
            return response()->json($this->data);
        }
        return ViewHelper::checkViewForApi($this->data, 'frontend.student.batch-exam.contents.pdf');
    }

    public function showBatchExamPdf($contentId)
    {
        $this->data = [
            'sectionContent'  => BatchExamSectionContent::whereId($contentId)->select('id', 'batch_exam_section_id', 'content_type', 'title', 'pdf_link', 'pdf_file', 'status')->first(),
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.student.batch-exam.contents.pdf');
    }

    public function studentChangePassword ()
    {
        return view('frontend.student.my-pages.password');
    }

    public function getTextTypeContent (Request $request)
    {
        try {
            $sectionContent = CourseSectionContent::find($request->content_id);
//            $sectionContent->course_exam_
            return view('frontend.student.course.contents.show-content-ajax', [
                'content'   => $sectionContent,
            ]);
        } catch (\Exception $exception)
        {
            return response()->json($exception->getMessage());
        }

//        return response()->json(CourseSectionContent::find($request->content_id));
    }
    public function showClassXmAjax (Request $request)
    {
        try {
            $content = CourseSectionContent::find($request->content_id, ['id', 'title']);

            $string = '<div class="mt-2">
<h1 class="text-center f-s-35">'.$content->title.'</h1>
    <p class="text-capitalize f-s-25">To Access Today\'s content, you have to participate last class exam.</p>
    <div class="mt-2">
        <p class="text-capitalize f-s-25">start your class exam now.</p>
        <a href="'. route('front.student.start-class-exam', ['content_id' => $content->id, 'slug' => str_replace(' ', '-', $content->title)]).'" class="btn btn-success rounded-0">Start Class Exam</a>
    </div>
</div>';
            return \response()->json($string);
//            return view('frontend.student.course.contents.show-content-ajax', [
//                'content'   => CourseSectionContent::find($request->content_id),
//            ]);
        } catch (\Exception $exception)
        {
            return response()->json($exception->getMessage());
        }

//        return response()->json(CourseSectionContent::find($request->content_id));
    }

    public function getBatchExamTextTypeContent (Request $request)
    {
        try {
            return view('frontend.student.batch-exam.contents.show-content-ajax', [
                'content'   => BatchExamSectionContent::find($request->content_id),
            ]);
        } catch (\Exception $exception)
        {
            return response()->json($exception->getMessage());
        }
    }

    public function myAffiliation()
    {
        $this->affiliateRegister = AffiliationRegistration::where(['user_id' => ViewHelper::loggedUser()->id])->first();
        $this->courses = Course::where(['status' => 1, 'is_paid' => 1])->get();
        $batchExams = BatchExam::where(['status' => 1, 'is_paid' => 1])->get();
        foreach ($this->courses as $course)
        {
            $course->banner = asset($course->banner);
        }
        foreach ($batchExams as $batchExam)
        {
            $batchExam->banner = asset($batchExam->banner);
        }
        $this->data = [
            'affiliateRegister'  => $this->affiliateRegister,
            'courses'           => $this->courses,
            'batchExams'        => $batchExams,
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.student.affiliation.index');
    }

    public function studentNotices()
    {
//        $this->notices  = Notice::where('')->latest()->get();
    }

    public function getDeliveryChargeForApp ()
    {
        $deliveryCharge = ProductDeliveryOption::where(['status' => 1])->first();
        return \response()->json(['deliveryCharge' => $deliveryCharge->fee ?? 0]);
    }
}
