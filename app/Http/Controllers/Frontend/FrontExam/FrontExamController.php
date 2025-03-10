<?php

namespace App\Http\Controllers\Frontend\FrontExam;

use App\helper\ViewHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Checkout\CheckoutController;
use App\Models\Backend\AdditionalFeatureManagement\Advertisement;
use App\Models\Backend\AdditionalFeatureManagement\Affiliation\AffiliationHistory;
use App\Models\Backend\AdditionalFeatureManagement\Affiliation\AffiliationRegistration;
use App\Models\Backend\BatchExamManagement\ArchiveExamResult;
use App\Models\Backend\BatchExamManagement\BatchExam;
use App\Models\Backend\BatchExamManagement\BatchExamCategory;
use App\Models\Backend\BatchExamManagement\BatchExamResult;
use App\Models\Backend\BatchExamManagement\BatchExamSectionContent;
use App\Models\Backend\ExamManagement\AssignmentFile ;
use App\Models\Backend\Course\CourseClassExamResult;
use App\Models\Backend\Course\CourseExamResult;
use App\Models\Backend\Course\CourseSectionContent;
use App\Models\Backend\Course\PracticeExamResult;
use App\Models\Backend\ExamManagement\Exam;

use App\Models\Backend\ExamManagement\ExamResult;
use App\Models\Backend\OrderManagement\ParentOrder;
use App\Models\Backend\QuestionManagement\QuestionOption;
use App\Models\Backend\QuestionManagement\QuestionStore;
use App\Models\Frontend\AdditionalFeature\ContactMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\directoryExists;

class FrontExamController extends Controller
{
    protected float $resultNumber;
    protected $questions = [], $exams = [], $exam, $examCategory, $examCategories = [], $subscriptions = [], $courseExamResults = [];
    protected $xmResult, $data = [], $courseSection, $courseSections = [], $sectionContent, $sectionContents = [];
    protected $examResult, $totalRightAns, $totalWrongAns, $totalProvidedAns, $question, $questionOption, $questionJson=[], $fileSessionPaths = [], $filePathString, $pdfFilePath;
    public function xmTestForDev ()
    {
        $this->questions = QuestionStore::whereQuestionType('mcq')->get();
        return view('frontend.exams.view-exam-form', ['questions' => $this->questions]);
    }

    public function startExam ($examId, $slug = null)
    {
        if (ViewHelper::authCheck())
        {
            $this->exam = Exam::find($examId);
//        if (Carbon::today()->format('Y-m-d') <= $this->exam->xm_date)
//        {
//            return 'can participate';
//        }
//        if (Carbon::today()->format('Y-m-d') > $this->exam->xm_date)
//        {
//            return 'date over';
//        }
            return view('frontend.exams.practice.start', [
                'exam'  => $this->exam,
            ]);
        } else {
            return back()->with('error', 'Please Login First.');
        }
    }

    public function submitFormIfPageReloaded()
    {
        $response = '';
        if (session()->has('getXmStartStatus'))
        {
            if (session('getXmStartStatus')['xmStartStatus'] == 1)
            {

                if (session('getXmStartStatus')['xmType'] == 'course')
                {

                    return $response =  $this->commonGetCourseExamResul((object) session('getXmDataToSession'), session('getXmStartStatus')['xmContentId']);
//                        return 'sdf';
//                        $content = CourseSectionContent::find(session('getXmStartStatus')['xmContentId']);
//                        return redirect('/student/get-course-exam-result/'.$content->id.'/'.$content->title)->withInput(session('getXmDataToSession'));
//                        return redirect()->route('front.student.get-course-exam-result', ['content_id'=>$content->id, 'slug' => $content->title])->withInput(session('getXmDataToSession'));
//                        return redirect()->action([FrontExamController::class, 'getCourseExamResult'], ['content_id'=>$content->id, 'slug' => $content->title])->withInput(session('getXmDataToSession'));
                } elseif (session('getXmStartStatus')['xmType'] == 'batch_exam')
                {
                session()->forget('getXmStartStatus');
                        session()->forget('getXmDataToSession');
                                    return $response = $this->commonGetBatchExamResult((object) session('getXmDataToSession'), session('getXmStartStatus')['xmContentId']);
                                }
                            }
                        }
                        session()->forget('getXmStartStatus');
                        session()->forget('getXmDataToSession');
                        return $response;
                    }

    public function startcourseExam ($contentId)
    {
        if (ViewHelper::authCheck())
        {
            $existExam = CourseExamResult::where(['user_id' => ViewHelper::loggedUser()->id, 'course_section_content_id' => $contentId])->first();
            if (isset($existExam) && !empty($existExam))
            {
                if (str()->contains(url()->current(), '/api/'))
                {
                    return response()->json(['error' => 'You already participated in this exam.'], 400);
                } else {
                    return redirect('/student/dashboard')->with('success', 'You already participated in this exam.');
                }
            }
            $response = '';
            if (session()->has('getXmStartStatus'))
            {
                if (session('getXmStartStatus')['xmStartStatus'] == 1)
                {
                    if (session('getXmStartStatus')['xmType'] == 'course')
                    {
                          return $this->commonGetCourseExamResul((object) session('getXmDataToSession'), session('getXmStartStatus')['xmContentId']);
                    }
                }
            }

//            $existExamResult = CourseExamResult::where(['course_section_content_id' => $contentId, 'user_id' => ViewHelper::loggedUser()->id])->first();
//            if (!empty($existExamResult))
//            {
//                return back()->with('error', 'You already participate in this exam.');
//            }
            $this->exam = CourseSectionContent::whereId($contentId)->with(['questionStores'])->first();
            $this->data = [
                'exam'   => $this->exam
            ];
            return ViewHelper::checkViewForApi($this->data, 'frontend.exams.course.start');
        } else {
            return back()->with('error', 'Please Login First.');
        }
    }

    public function startClassExam($contentId)
    {
        if (ViewHelper::authCheck())
        {
            $this->sectionContent = CourseSectionContent::whereId($contentId)->with(['questionStoresForClassXm'])->first();
            $existUserClassXm = CourseClassExamResult::where(['course_section_content_id' => $this->sectionContent->id, 'user_id' => ViewHelper::loggedUser()->id])->first();
            if (isset($existUserClassXm))
            {
                return back()->with('error' , 'You already passed the class Exam.');
            }
            $this->data = [
                'exam'   => $this->sectionContent
            ];
            return ViewHelper::checkViewForApi($this->data, 'frontend.exams.course.class.start');
        } else {
            return back()->with('error', 'Please Login First.');
        }
    }

    public function startBatchExam ($contentId)
    {
        if (ViewHelper::authCheck())
        {
//            $this->submitFormIfPageReloaded();
            $existExamResult = BatchExamResult::where(['batch_exam_section_content_id' => $contentId, 'user_id' => ViewHelper::loggedUser()->id])->first();
            if (isset($existExamResult) && !empty($existExamResult))
            {
                if (str()->contains(url()->current(), '/api/'))
                {
                    return response()->json(['error' => 'You already participated in this exam.'], 400);
                } else {
                    return redirect('/student/dashboard')->with('success', 'You already participated in this exam.');
                }
            }
            if (session()->has('getXmStartStatus'))
            {
                if (session('getXmStartStatus')['xmStartStatus'] == 1)
                {
                    if (session('getXmStartStatus')['xmType'] == 'batch_exam')
                    {
                        return  $this->commonGetBatchExamResult((object) session('getXmDataToSession'), session('getXmStartStatus')['xmContentId']);
                    }
                }
            }
//            if (!empty($existExamResult))
//            {
//                return back()->with('error', 'You already participate in this exam.');
//            }
            $this->exam = BatchExamSectionContent::whereId($contentId)->with(['questionStores'])->first();
            $this->data = [
                'exam'   => $this->exam
            ];
            return ViewHelper::checkViewForApi($this->data, 'frontend.exams.batch-exam.start');
        } else {
            return back()->with('error', 'Please Login First.');
        }
    }

    public function getExamResult (Request $request, $examId, $slug = null)
    {
        $this->resultNumber = 0;
        $this->exam = Exam::whereId($examId)->first();

        if ($this->exam)
        {
            if ($this->exam->xm_type == 'MCQ')
            {
                $this->questionJson = $request->question;
                foreach ($request->question as $question_id => $answer)
                {
                    if (!is_array($answer))
                    {
                        unset($this->questionJson[$question_id]);
                    }
                    $this->question = QuestionStore::whereId($question_id)->select('id', 'question_type', 'question_mark', 'negative_mark', 'has_all_wrong_ans', 'status')->first();
                    if (is_array($answer))
                    {
                        if ($this->question->has_all_wrong_ans == 1)
                        {
//                            $this->resultNumber -= (int)$this->question->negative_mark;
                            $this->resultNumber -= (int)$this->exam->exam_per_question_mark;
                        } else {
                            $this->questionOption = QuestionOption::whereId($answer['answer'])->select('id', 'is_correct')->first();
                            if ($this->questionOption->is_correct == 1)
                            {
                                $this->resultNumber += (int)$this->exam->exam_per_question_mark;
                            } else {
                                $this->resultNumber -= $this->exam->exam_negative_mark;
                            }
                        }
                    }
                }
                $this->examResult = [
                    'exam_id'       => $examId,
                    'user_id'       => ViewHelper::loggedUser()->id,
                    'xm_type'       => $this->exam->xm_type,
//                    'written_xm_file'       => fileUpload($request->file('written_xm_file'), 'xm-files/'.$this->exam->id.'/', 'file-'.ViewHelper::loggedUser()->id.'-'),
                    'provided_ans'      => json_encode($this->questionJson),
                    'result_mark'       => $this->resultNumber ?? 0,
                    'is_reviewed'       => 0,
                    'status'        => $this->exam->xm_type == 'MCQ' ? ($this->resultNumber >= $this->exam->xm_pass_mark ? 'pass' : 'fail') : 'pending',
                ];
            } elseif ($this->exam->xm_type == 'Written')
            {
                $imageUrl = '';
                $this->pdfFilePath = '';
                if (!empty($request->file('ans_files')))
                {
                    foreach ($request->file('ans_files') as $ans_file)
                    {
                        $imageUrl = imageUpload($ans_file, 'xm-temp-file-upload/', 'tmp-', 600, 800);
                        array_push($this->fileSessionPaths, $imageUrl);
//                        $this->filePathString .= $_SERVER['DOCUMENT_ROOT'].'/'.$imageUrl.' ';
                        $this->filePathString .= public_path($imageUrl).' ';
                    }
                    $this->pdfFilePath = 'backend/assets/uploaded-files/written-xm-ans-files/'.rand(10000,99999).time().'.pdf';
                    // shell_exec('magick convert '. $this->filePathString.public_path($this->pdfFilePath));
//                    exec('convert '. $this->filePathString.$_SERVER['DOCUMENT_ROOT'].'/'.$this->pdfFilePath);
                     shell_exec('convert '. $this->filePathString.public_path($this->pdfFilePath));
                    foreach ($this->fileSessionPaths as $fileSessionPath)
                    {
                        if (file_exists($fileSessionPath))
                        {
                            unlink($fileSessionPath);
                        }
                    }
                }

                $this->examResult = [
                    'exam_id'       => $examId,
                    'user_id'       => ViewHelper::loggedUser()->id,
                    'xm_type'       => $this->exam->xm_type,
                    'written_xm_file'       => $this->pdfFilePath,
//                    'provided_ans'      => json_encode($this->questionJson),
//                    'result_mark'       => $this->resultNumber ?? 0,
                    'is_reviewed'       => 0,
                    'status'        =>  'pending',
                ];
            }
            ExamResult::storeExamResult($this->examResult);
            return redirect()->route('front.student.show-exam-result', ['xm_id' => $examId])->with('success', 'You Successfully finished your exam.');
        }
        return back()->with('error', 'Exam Not Found.');
    }

//    public function commonGetCourseExamResul($request, $contentId, $slug = null)
//    {
//
//
//
////        $existExam = CourseExamResult::where(['user_id' => ViewHelper::loggedUser()->id, 'course_section_content_id' => $contentId])->first();
////        if (isset($existExam) && !empty($existExam))
////        {
////            if (str()->contains(url()->current(), '/api/'))
////            {
////                return response()->json(['error' => 'You already participated in this exam.'], 400);
////            } else {
////                return redirect('/student/dashboard')->with('success', 'You already participated in this exam.');
////            }
////        }
//        $this->resultNumber = 0;
//        $this->totalRightAns = 0;
//        $this->totalWrongAns = 0;
//        $this->totalProvidedAns = 0;
//        $this->exam = CourseSectionContent::whereId($contentId)->first();
//        if ($this->exam)
//        {
//            if ($this->exam->content_type == 'exam')
//            {
//                if (!empty($request->question))
//                {
//                    $this->questionJson = $request->question;
//                    foreach ($request->question as $question_id => $answer)
//                    {
//                        if (!is_array($answer))
//                        {
//                            unset($this->questionJson[$question_id]);
//                        }
//                        $this->question = QuestionStore::whereId($question_id)->select('id', 'question_type', 'question_mark', 'negative_mark', 'has_all_wrong_ans', 'status')->first();
//                        if (is_array($answer))
//                        {
//                            ++$this->totalProvidedAns;
//                            if ($this->question->has_all_wrong_ans == 1)
//                            {
////                                    $this->resultNumber -= (int)$this->question->negative_mark;
//                                $this->resultNumber -= $this->exam->exam_negative_mark;
//                                ++$this->totalWrongAns;
//                            } else {
//                                $this->questionOption = QuestionOption::whereId($answer['answer'])->select('id', 'is_correct')->first();
//                                if ($this->questionOption->is_correct == 1)
//                                {
//                                    $this->resultNumber += (int)$this->exam->exam_per_question_mark;
//                                    ++$this->totalRightAns;
//                                } else {
//                                    $this->resultNumber -= $this->exam->exam_negative_mark;
//                                    ++$this->totalWrongAns;
//                                }
//                            }
//                        }
//                    }
//                }
//                $this->examResult = [
//                    'course_section_content_id'       => $contentId,
//                    'user_id'       => ViewHelper::loggedUser()->id,
//                    'xm_type'       => $this->exam->content_type,
////                    'written_xm_file'       => fileUpload($request->file('written_xm_file'), 'xm-files/'.$this->exam->id.'/', 'file-'.ViewHelper::loggedUser()->id.'-'),
//                    'provided_ans'      => json_encode($this->questionJson),
//                    'total_right_ans'       => $this->totalRightAns ?? 0,
//                    'total_wrong_ans'       => $this->totalWrongAns ?? 0,
//                    'total_provided_ans'    => $this->totalProvidedAns ?? 0,
////                        'result_mark'       => $this->resultNumber > 0 ? $this->resultNumber : 0,
//                    'result_mark'       => $this->resultNumber,
//                    'is_reviewed'       => 0,
//                    'required_time'       => $request->required_time ?? 0,
//                    'status'        => $this->exam->content_type == 'exam' ? ($this->resultNumber >= $this->exam->exam_pass_mark ? 'pass' : 'fail') : 'pending',
//                ];
//
//            } elseif ($this->exam->content_type == 'written_exam')
//            {
//                $imageUrl = '';
//                $this->pdfFilePath = '';
//
//                if (isset($request->ans_files))
//                {
//                    if (!empty($request->file('ans_files')))
//                    {
//                        foreach ($request->file('ans_files') as $ans_file)
//                        {
//
//                            $imageUrl = imageUpload($ans_file, 'course-xm-temp-file-upload/', 'tmp', 600, 800);
//                            array_push($this->fileSessionPaths, $imageUrl);
////                            $this->filePathString .= $_SERVER['DOCUMENT_ROOT'].'/'.($imageUrl).' ';
//                            $this->filePathString .= public_path($imageUrl).' ';
//                        }
//                        $this->pdfFilePath = 'backend/assets/uploaded-files/course-written-xm-ans-files/'.rand(10000,99999).time().'.pdf';
//                        if (!File::isDirectory(public_path('backend/assets/uploaded-files/course-written-xm-ans-files')))
//                        {
//                            File::makeDirectory(public_path('backend/assets/uploaded-files/course-written-xm-ans-files'), 0777, true, true);
//                        }
////                        exec('convert '. $this->filePathString.$_SERVER['DOCUMENT_ROOT'].'/'.$this->pdfFilePath);
//
//                         shell_exec('convert '. $this->filePathString.public_path($this->pdfFilePath));
//                        foreach ($this->fileSessionPaths as $fileSessionPath)
//                        {
//                            if (file_exists($fileSessionPath))
//                            {
//                                unlink($fileSessionPath);
//                            }
//                        }
//                    }
//                }
//                $this->examResult = [
//                    'course_section_content_id'       => $contentId,
//                    'user_id'       => ViewHelper::loggedUser()->id,
//                    'xm_type'       => $this->exam->content_type,
//                    'written_xm_file'       => $this->pdfFilePath,
////                    'provided_ans'      => json_encode($this->questionJson),
////                    'result_mark'       => $this->resultNumber ?? 0,
//                    'is_reviewed'       => 0,
//                    'required_time'       => $request->required_time ?? 0,
//                    'status'        =>  'pending',
//                ];
//            }
//            $courseExamId = CourseExamResult::storeExamResult($this->examResult);
//
//            Session::forget(['getXmStartStatus', 'getXmDataToSession']);
//
//            if (str()->contains(url()->current(), '/api/'))
//            {
//                return response()->json(['status' => 'success', 'message' => 'Exam Data Saved Successfully.', 'exam_id' => $this->exam->id]);
//            } else {
//                return redirect()->route('front.student.show-course-exam-result', ['xm_id' => $contentId, 'xm_result_id' => $courseExamId->id])->with('success', 'You Successfully finished your exam.');
//            }
//        } else {
//            return ViewHelper::returEexceptionError('Exam Not Found.');
//        }
//    }

    public function getPracticeExamResult(Request $request, $contentId, $slug = null)
    {

        $existExamResults = PracticeExamResult::where(['course_section_content_id' => $contentId, 'user_id' => ViewHelper::loggedUser()->id])->get();
        if (!empty($existExamResults))
        {
            foreach($existExamResults as $exist){
                $exist->delete();
            }
        }

        $request['exam_type'] = 'practice';

        return $this->commonGetCourseExamResul($request, $contentId, $slug = null);

    }

    public function commonGetCourseExamResul(Request $request, $contentId, $slug = null)
    {
        $this->resultNumber = 0;
        $this->totalRightAns = 0;
        $this->totalWrongAns = 0;
        $this->totalProvidedAns = 0;
        $this->exam = CourseSectionContent::whereId($contentId)->first();
        if ($this->exam)
        {
            if ($this->exam->content_type == 'exam')
            {
                if (!empty($request->question))
                {
                    $this->questionJson = $request->question;
                    foreach ($request->question as $question_id => $answer)
                    {
                        if (!is_array($answer))
                        {
                            unset($this->questionJson[$question_id]);
                        }
                        $this->question = QuestionStore::whereId($question_id)->select('id', 'question_type', 'question_mark', 'negative_mark', 'has_all_wrong_ans', 'status')->first();
                        if (is_array($answer))
                        {
                            ++$this->totalProvidedAns;
                            if ($this->question->has_all_wrong_ans == 1)
                            {
                                $this->resultNumber -= $this->exam->exam_negative_mark;
                                ++$this->totalWrongAns;
                            } else {
                                $this->questionOption = QuestionOption::whereId($answer['answer'])->select('id', 'is_correct')->first();
                                if ($this->questionOption->is_correct == 1)
                                {
                                    $this->resultNumber += (int)$this->exam->exam_per_question_mark;
                                    ++$this->totalRightAns;
                                } else {
                                    $this->resultNumber -= $this->exam->exam_negative_mark;
                                    ++$this->totalWrongAns;
                                }
                            }
                        }
                    }
                }
                $this->examResult = [
                    'course_section_content_id'       => $contentId,
                    'user_id'       => ViewHelper::loggedUser()->id,
                    'xm_type'       => $this->exam->content_type,
                    'provided_ans'      => json_encode($this->questionJson),
                    'total_right_ans'       => $this->totalRightAns ?? 0,
                    'total_wrong_ans'       => $this->totalWrongAns ?? 0,
                    'total_provided_ans'    => $this->totalProvidedAns ?? 0,
                    'result_mark'       => $this->resultNumber,
                    'is_reviewed'       => 0,
                    'required_time'       => $request->required_time ?? 0,
                    'status'        => $this->exam->content_type == 'exam' ? ($this->resultNumber >= $this->exam->exam_pass_mark ? 'pass' : 'fail') : 'pending',
                ];

            }elseif ($this->exam->content_type == 'written_exam')
            {
                $imageUrl = '';
                $this->pdfFilePath = '';

                if (isset($request->ans_files))
                {
                    if (!empty($request->file('ans_files')))
                    {
                        foreach ($request->file('ans_files') as $ans_file)
                        {

                            $imageUrl = imageUpload($ans_file, 'course-xm-temp-file-upload/', 'tmp', 600, 800);
                            array_push($this->fileSessionPaths, $imageUrl);
//                            $this->filePathString .= $_SERVER['DOCUMENT_ROOT'].'/'.($imageUrl).' ';
                            $this->filePathString .= public_path($imageUrl).' ';
                        }
                        $this->pdfFilePath = 'backend/assets/uploaded-files/course-written-xm-ans-files/'.rand(10000,99999).time().'.pdf';
                        if (!File::isDirectory(public_path('backend/assets/uploaded-files/course-written-xm-ans-files')))
                        {
                            File::makeDirectory(public_path('backend/assets/uploaded-files/course-written-xm-ans-files'), 0777, true, true);
                        }
//                        exec('convert '. $this->filePathString.$_SERVER['DOCUMENT_ROOT'].'/'.$this->pdfFilePath);

                        shell_exec('convert '. $this->filePathString.public_path($this->pdfFilePath));
                        foreach ($this->fileSessionPaths as $fileSessionPath)
                        {
                            if (file_exists($fileSessionPath))
                            {
                                unlink($fileSessionPath);
                            }
                        }
                    }
                }
                $this->examResult = [
                    'course_section_content_id'       => $contentId,
                    'user_id'       => ViewHelper::loggedUser()->id,
                    'xm_type'       => $this->exam->content_type,
                    'written_xm_file'       => $this->pdfFilePath,
//                    'provided_ans'      => json_encode($this->questionJson),
//                    'result_mark'       => $this->resultNumber ?? 0,
                    'is_reviewed'       => 0,
                    'required_time'       => $request->required_time ?? 0,
                    'status'        =>  'pending',
                ];
            }

            if(isset($request->exam_type) && $request->exam_type == 'practice'){
                $courseExamId = PracticeExamResult::storeExamResult($this->examResult);
            }else{
                $courseExamId = CourseExamResult::storeExamResult($this->examResult);
            }

            Session::forget(['getXmStartStatus', 'getXmDataToSession']);

            if (str()->contains(url()->current(), '/api/'))
            {
                return response()->json(['status' => 'success', 'message' => 'Exam Data Saved Successfully.', 'exam_id' => $this->exam->id]);
            } else {
                return redirect()->route('front.student.show-course-exam-result', ['xm_id' => $contentId, 'xm_result_id' => $courseExamId->id])->with('success', 'You Successfully finished your exam.');
            }
        }else{
            return ViewHelper::returEexceptionError('Exam Not Found.');
        }

    }

    public function getCourseExamResult(Request $request, $contentId, $slug = null)
    {
        try {
            $existExam = CourseExamResult::where(['user_id' => ViewHelper::loggedUser()->id, 'course_section_content_id' => $contentId])->first();
            if (isset($existExam) && !empty($existExam))
            {
                if (str()->contains(url()->current(), '/api/'))
                {
                    return response()->json(['error' => 'You already participated in this exam.'], 400);
                } else {
                    return redirect('/student/dashboard')->with('success', 'You already participated in this exam.');
                }
            }
            return $this->commonGetCourseExamResul($request, $contentId, $slug = null);

        } catch (\Exception $exception)
        {
            return ViewHelper::returEexceptionError($exception->getMessage());
        }

    }
    public function getCourseClassExamResult(Request $request, $contentId, $slug = null)
    {
        try {
            $existExam = CourseClassExamResult::where(['user_id' => ViewHelper::loggedUser()->id, 'course_section_content_id' => $contentId])->first();
            if (isset($existExam) && !empty($existExam))
            {
                if (str()->contains(url()->current(), '/api/'))
                {
                    return response()->json(['error' => 'You already participated in this exam.'], 400);
                } else {
                    return redirect('/student/dashboard')->with('success', 'You already participated in this exam.');
                }
            }
            $this->resultNumber = 0;
            $this->totalRightAns = 0;
            $this->totalWrongAns = 0;
            $this->totalProvidedAns = 0;
            $this->exam = CourseSectionContent::whereId($contentId)->first();
            if ($this->exam)
            {
                if (!empty($request->question))
                {
                    $this->questionJson = $request->question;

                    foreach ($request->question as $question_id => $answer)
                    {
                        if (!is_array($answer))
                        {
                            unset($this->questionJson[$question_id]);
                        }
                        $this->question = QuestionStore::whereId($question_id)->select('id', 'question_type', 'question_mark', 'negative_mark', 'has_all_wrong_ans', 'status')->first();
                        if (is_array($answer))
                        {
                            ++$this->totalProvidedAns;
                            if ($this->question->has_all_wrong_ans == 1)
                            {
                                $this->resultNumber -= 1;
                                ++$this->totalWrongAns;
                            } else {
                                $this->questionOption = QuestionOption::whereId($answer['answer'])->select('id', 'is_correct')->first();
                                if ($this->questionOption->is_correct == 1)
                                {
                                    $this->resultNumber += 1;
                                    ++$this->totalRightAns;
                                } else {
                                    ++$this->totalWrongAns;
                                }
                            }
                        }
                    }
                }
                $this->examResult = [
                    'course_section_content_id'       => $contentId,
                    'user_id'       => ViewHelper::loggedUser()->id,
//                'xm_type'       => $this->exam->content_type,
//                    'written_xm_file'       => fileUpload($request->file('written_xm_file'), 'xm-files/'.$this->exam->id.'/', 'file-'.ViewHelper::loggedUser()->id.'-'),
                    'provided_ans'      => json_encode($this->questionJson),
                    'total_right_ans'       => $this->totalRightAns ?? 0,
                    'total_wrong_ans'       => $this->totalWrongAns ?? 0,
                    'total_provided_ans'    => $this->totalProvidedAns ?? 0,
//                    'result_mark'       => $this->resultNumber ?? 0,
//                    'result_mark'       => $this->resultNumber > 0 ? $this->resultNumber : 0,
                    'result_mark'       => $this->resultNumber,
                    'is_reviewed'       => 0,
                    'required_time'     => $request->required_time ?? 0,
//                'status'        => $this->resultNumber >= $this->exam->exam_pass_mark ? 'pass' : 'fail',
                    'status'            => 'pass',
                ];
                $courseClassExamResult = CourseClassExamResult::storeExamResult($this->examResult);
                if (str()->contains(url()->current(), '/api/'))
                {
                    return response()->json(['status' => 'success', 'message' => 'Exam Data Saved Successfully.', 'exam_id' => $this->exam->id]);
                } else {
                    return redirect()->route('front.student.show-course-class-exam-result', ['xm_id' => $contentId, 'xm_result_id' => $courseClassExamResult->id])->with('success', 'You Successfully finished your exam.');
                }
            }
            return ViewHelper::returEexceptionError('Exam Not Found.');
        } catch (\Exception $exception)
        {
            return ViewHelper::returEexceptionError($exception->getMessage());
        }

    }

    public function commonGetBatchExamResult($request, $contentId, $slug = null)
    {
//        $existExam = CourseClassExamResult::where(['user_id' => ViewHelper::loggedUser()->id, 'batch_exam_section_content_id' => $contentId])->first();
//        if (isset($existExam) && !empty($existExam))
//        {
//            if (str()->contains(url()->current(), '/api/'))
//            {
//                return response()->json(['error' => 'You already participated in this exam.'], 400);
//            } else {
//                return redirect('/student/dashboard')->with('success', 'You already participated in this exam.');
//            }
//        }
        $this->resultNumber = 0;
        $this->totalRightAns = 0;
        $this->totalWrongAns = 0;
        $this->totalProvidedAns = 0;
        $this->exam = BatchExamSectionContent::whereId($contentId)->first();

        if ($this->exam)
        {
            if ($this->exam->content_type == 'exam')
            {
                if (!empty($request->question))
                {
                    $this->questionJson = $request->question;
                    foreach ($request->question as $question_id => $answer)
                    {
                        if (!is_array($answer))
                        {
                            unset($this->questionJson[$question_id]);
                        }
                        $this->question = QuestionStore::whereId($question_id)->select('id', 'question_type', 'question_mark', 'negative_mark', 'has_all_wrong_ans', 'status')->first();
                        if (is_array($answer))
                        {
                            ++$this->totalProvidedAns;
                            if ($this->question->has_all_wrong_ans == 1)
                            {
//                                $this->resultNumber -= (int)$this->question->negative_mark;
                                $this->resultNumber -= (int)$this->exam->exam_per_question_mark;
                                ++$this->totalWrongAns;
                            } else {
                                $this->questionOption = QuestionOption::whereId($answer['answer'])->select('id', 'is_correct')->first();
                                if ($this->questionOption->is_correct == 1)
                                {
                                    ++$this->totalRightAns;
                                    $this->resultNumber += (int)$this->exam->exam_per_question_mark;
                                } else {
                                    $this->resultNumber -= $this->exam->exam_negative_mark;
                                    ++$this->totalWrongAns;
                                }
                            }
                        }
                    }
                }
                $this->examResult = [
                    'batch_exam_section_content_id'       => $contentId,
                    'user_id'       => ViewHelper::loggedUser()->id,
                    'xm_type'       => $this->exam->content_type,
//                    'written_xm_file'       => fileUpload($request->file('written_xm_file'), 'xm-files/'.$this->exam->id.'/', 'file-'.ViewHelper::loggedUser()->id.'-'),
                    'provided_ans'      => json_encode($this->questionJson),
                    'total_right_ans'       => $this->totalRightAns ?? 0,
                    'total_wrong_ans'       => $this->totalWrongAns ?? 0,
                    'total_provided_ans'    => $this->totalProvidedAns ?? 0,
//                        'result_mark'       => $this->resultNumber ?? 0,
//                        'result_mark'       => $this->resultNumber > 0 ? $this->resultNumber : 0,
                    'result_mark'       => $this->resultNumber,
                    'is_reviewed'       => 0,
                    'required_time'       => $request->required_time ?? 0,
                    'status'        => $this->exam->content_type == 'exam' ? ($this->resultNumber >= $this->exam->exam_pass_mark ? 'pass' : 'fail') : 'pending',
                ];

            } elseif ($this->exam->content_type == 'written_exam')
            {
                $imageUrl = '';
                $this->pdfFilePath = '';
                if (!empty($request->file('ans_files')))
                {
                    foreach ($request->file('ans_files') as $ans_file)
                    {
                        $imageUrl = imageUpload($ans_file, 'batch-xm-temp-file-upload/', 'tmp-', 600, 800);
                        array_push($this->fileSessionPaths, $imageUrl);
//                        $this->filePathString .= $_SERVER['DOCUMENT_ROOT'].'/'.($imageUrl).' ';
                        $this->filePathString .= public_path($imageUrl).' ';
                    }
                    $this->pdfFilePath = 'backend/assets/uploaded-files/batch-written-xm-ans-files/'.rand(10000,99999).time().'.pdf';
                    if (!File::isDirectory(public_path('backend/assets/uploaded-files/batch-written-xm-ans-files')))
                    {
                        File::makeDirectory(public_path('backend/assets/uploaded-files/batch-written-xm-ans-files'), 0777, true, true);
                    }
//                    exec('convert '. $this->filePathString.$_SERVER['DOCUMENT_ROOT'].'/'.($this->pdfFilePath));
                     shell_exec('convert '. $this->filePathString.public_path($this->pdfFilePath));
                        // shell_exec('magick convert '. $this->filePathString.public_path($this->pdfFilePath));
                    foreach ($this->fileSessionPaths as $fileSessionPath)
                    {
                        if (file_exists($fileSessionPath))
                        {
                            unlink($fileSessionPath);
                        }
                    }
                }

                $this->examResult = [
                    'batch_exam_section_content_id'       => $contentId,
                    'user_id'       => ViewHelper::loggedUser()->id,
                    'xm_type'       => $this->exam->content_type,
                    'written_xm_file'       => $this->pdfFilePath,
//                    'provided_ans'      => json_encode($this->questionJson),
//                    'result_mark'       => $this->resultNumber ?? 0,
                    'is_reviewed'       => 0,
                    'required_time'       => $request->required_time ?? 0,
                    'status'        =>  'pending',
                ];
            }
//            session_start();
//            unset($_SESSION['getXmStartStatus']);
//            unset($_SESSION['getXmDataToSession']);
            Session::forget('getXmStartStatus');
            Session::forget('getXmDataToSession');
            $batchExamResult = BatchExamResult::storeExamResult($this->examResult);
            if (str()->contains(url()->current(), '/api/'))
            {
                return response()->json(['status' => 'success', 'message' => 'Exam Data Saved Successfully.', 'exam_id' => $this->exam->id]);
            } else {
                return redirect()->route('front.student.show-batch-exam-result', ['xm_id' => $contentId, 'xm_result_id' => $batchExamResult->id])->with('success', 'You Successfully finished your exam.');
            }
        } else {
            return ViewHelper::returEexceptionError('Exam Not Found.');
        }
    }
    public function getBatchExamResult(Request $request, $contentId, $slug = null)
    {
        try {
            return $this->commonGetBatchExamResult($request, $contentId, $slug = null);
            // return ViewHelper::returEexceptionError('Exam Not Found.');
        } catch (\Exception $exception)
        {
            return ViewHelper::returEexceptionError($exception->getMessage());
        }
    }

    public function showExamResult ($xmId, $xmResultId = null)
    {
        $this->exam = Exam::whereId($xmId)->select('id', 'title', 'xm_type', 'total_mark', 'xm_pass_mark', 'xm_duration')->first();
        if (isset($xmResultId))
        {
            $this->xmResult = ExamResult::find($xmResultId);
        } else {
            $this->xmResult = ExamResult::where('exam_id', $xmId)->latest()->first();
        }

        return view('frontend.exams.practice.result', [
            'exam'  => $this->exam,
            'examResult'    => $this->xmResult
        ]);
    }

    public function showCourseExamResult ($xmId, $xmResultId = null)
    {
//        $this->exam = CourseSectionContent::whereId($xmId)->select('id', 'title', 'content_type', 'total_mark', 'xm_pass_mark', 'xm_duration')->first();
       $this->exam = CourseSectionContent::whereId($xmId)->first();


        if (isset($xmResultId))
        {
            $this->xmResult = CourseExamResult::find($xmResultId);
        } else {
            $this->xmResult = CourseExamResult::where('course_section_content_id', $xmId)->latest()->first();
        }

        $this->data = [
            'exam'  => $this->exam,
            'examResult'    => $this->xmResult,
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.exams.course.result');
    }


    public function showCourseClassExamResult ($xmId, $xmResultId = null)
    {
        $this->exam = CourseSectionContent::whereId($xmId)->first();
        if (isset($xmResultId))
        {
            $this->xmResult = CourseClassExamResult::find($xmResultId);
        } else {
            $this->xmResult = CourseClassExamResult::where('course_section_content_id', $xmId)->latest()->first();
        }
        $this->data = [
            'exam'  => $this->exam,
            'examResult'    => $this->xmResult
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.exams.course.class.result');
    }

    public function showBatchExamResult ($xmId, $xmResultId = null)
    {
//        $this->exam = CourseSectionContent::whereId($xmId)->select('id', 'title', 'content_type', 'total_mark', 'xm_pass_mark', 'xm_duration')->first();
        $this->exam = BatchExamSectionContent::whereId($xmId)->first();
        if (isset($xmResultId))
        {
            $this->xmResult = BatchExamResult::find($xmResultId);
        } else {
            $this->xmResult = BatchExamResult::where('batch_exam_section_content_id', $xmId)->latest()->first();
        }
        $this->data = [
            'exam'  => $this->exam,
            'examResult'    => $this->xmResult
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.exams.batch-exam.result');
    }


    // public function showAllExams ()
    // {

    //     $masterExam = BatchExam::whereIsMasterExam(1)->with('batchExamSubscriptions')->first();
    //     if (isset($masterExam))
    //     {
    //         $masterExam->purchase_status = ViewHelper::checkUserBatchExamIsEnrollment(ViewHelper::loggedUser(), $masterExam);
    //     }

    //     $this->examCategories = BatchExamCategory::where(['status' => 1, 'parent_id' => 0])->get();

    //     // $allBatchExams = BatchExam::where(['status' => 1, 'is_master_exam' => 0, 'is_paid' => 1])->get();
    //     $allBatchExams = BatchExam::where([
    //         'status' => 1,
    //         'is_master_exam' => 0,
    //         'is_paid' => 1
    //     ])->select('id', 'title', 'banner', 'slug', 'price', 'discount_type', 'discount_amount', 'admission_last_date')->get();

    //     $allBatchExams = $allBatchExams->map(function ($exam) {
    //         $exam->price = (float) $exam->price; // Cast price to float
    //         return $exam;
    //     });

    //     $exam_sliders = Advertisement::whereStatus(1)->whereContentType('exam')->select('id', 'title', 'content_type', 'description','link','image')->take(6)->get();
    //     return response()->json([
    //         'examCategories'     => $this->examCategories,
    //         'masterExam'    => $masterExam,
    //         'allExams'      => $allBatchExams,
    //         'exam_sliders'      => $exam_sliders,
    //     ],200);

    // }

    public function showAllExams (Request $request)
    {
        $masterExam = BatchExam::whereIsMasterExam(1)->first();
        if (isset($masterExam))
        {
            $masterExam->purchase_status = ViewHelper::checkUserBatchExamIsEnrollment(ViewHelper::loggedUser(), $masterExam);
        }

        $this->examCategories = BatchExamCategory::where(['status' => 1, 'parent_id' => 0])->get();


        $allExams = BatchExam::where([
            'status' => 1,
            'is_master_exam' => 0,
            'is_paid' => 1
        ])->select(['id', 'title', 'banner', 'slug', 'price', 'discount_type', 'discount_amount', 'admission_last_date', 'discount_start_date', 'discount_end_date'])->paginate(20);

        $exam_sliders = Advertisement::whereStatus(1)->whereContentType('exam')->select('id', 'title', 'content_type', 'description','link','image')->take(6)->get();


        return response()->json([
            'examCategories'     => $this->examCategories,
            'masterExam'    => $masterExam,
            'allExams'      => $allExams,
            'exam_sliders'      => $exam_sliders,
        ],200);

    }



//     public function categoryExams ($id, $name = null)
//     {
//         $this->exam = BatchExam::whereId($id)->select('id', 'title', 'description', 'banner',  'status', 'is_paid', 'slug')->with(['batchExamSubscriptions' => function ($package) {
//             $package->whereStatus(1)->select('id', 'batch_exam_id', 'price', 'package_duration_in_days', 'package_title', 'discount_amount', 'discount_start_date', 'discount_end_date')->get();
//         }])->first();
// //        $this->examCategory->validity = Carbon::parse($this->examCategory->valid_from)->format('d-m-Y').' - '. Carbon::parse($this->examCategory->valid_to)->format('d-m-Y');
//         return response()->json([
//             'exam' => $this->exam,
//             'enrollStatus'  => ViewHelper::authCheck() ? ViewHelper::checkIfBatchExamIsEnrollmentAndHasValidity(ViewHelper::loggedUser(),$this->exam) : 'false',
//         ]);
// //        $this->data = [
// //            'examCategories'    => ExamCategory::where(['exam_category_id' => $id, 'status' => 1])->select('id', 'name', 'image', 'status')->get(),
// //            'exams'    => Exam::where(['exam_category_id' => $id, 'status' => 1])->select('id', 'slug', 'title', 'image', 'xm_duration')->get(),
// //        ];
// //        return ViewHelper::checkViewForApi($this->data, 'frontend.exams.xm.category-exams');
//     }

    public function categoryExams($id = null) {

        $category = BatchExamCategory::where('id', $id)
            ->select('id', 'name', 'parent_id', 'slug', 'status', 'image') // Fields to select from BatchExamCategory
            ->with([
                'batchExams' => function ($exam) {
                    $exam->where('status', 1)
                        ->select('id', 'title', 'banner', 'slug', 'price', 'discount_type', 'discount_amount','discount_start_date','discount_end_date', 'admission_last_date', 'batch_exam_category_id');
                },
                'batchExamCategories' => function ($batchExamCategories) { // Assuming 'subCategories' is the relationship for child categories
                    $batchExamCategories->where('status', 1)
                        ->orderBy('order', 'ASC')
                        ->select('id', 'parent_id', 'name', 'slug', 'image', 'status');
                }
            ])
            ->first();

            if ($category) {
                $now = Carbon::now();
                $category->batchExams->each(function ($exam) use ($now) {
                    $exam->has_discount_validity = false;
                    if (!empty($exam->discount_start_date) && !empty($exam->discount_end_date)) {
                        $discountStart = Carbon::parse($exam->discount_start_date);
                        $discountEnd = Carbon::parse($exam->discount_end_date);

                        if ($now->between($discountStart, $discountEnd)) {
                            $exam->has_discount_validity = true;
                        }
                    }
                });
            }
        if (!$category) {
            return response()->view('errors.404', [], 404);
        }

        $this->data = ['category' => $category];

        return ViewHelper::checkViewForApi($this->data, 'frontend.exams.xm.exam-category', 'Category Not Found');
    }

    // public function viewExamDetails($id, $slug = null)
    // {
    //     $this->exam = BatchExam::find($id);
    //     $this->data = [
    //         'exam'  => $this->exam,
    //         'enrollStatus'  => ViewHelper::checkUserBatchExamIsEnrollment(ViewHelper::loggedUser(),$this->exam)
    //     ];
    //     return ViewHelper::checkViewForApi($this->data, 'frontend.exams.xm.details');
    // }
    public function viewExamDetails($id, $slug = null)
    {

        $this->exam = BatchExam::select('id', 'title', 'slug', 'price', 'banner', 'discount_type', 'discount_amount', 'discount_start_date', 'discount_end_date', 'admission_last_date', 'package_duration_in_days','is_paid','	description')
            ->where('id', $id)
            ->first();

        if(!$this->exam){
            return response()->view('errors.404', [], 404);
        }

        $now = Carbon::now();
        $this->exam->has_discount_validity = 'false';

        if (!empty($this->exam->discount_start_date) && !empty($this->exam->discount_end_date)) {
            $discountStart = Carbon::parse($this->exam->discount_start_date);
            $discountEnd = Carbon::parse($this->exam->discount_end_date);

            if ($now->between($discountStart, $discountEnd)) {
                $this->exam->has_discount_validity = 'true';
            }
        }

        $totalStudentEnrollments = DB::table('batch_exam_student')->where('batch_exam_id', $this->exam->id)->count('student_id');
        $batchExam = BatchExam::where('id', $id)->select('id', 'slug')->first();
        $batchExamSection = BatchExam::whereId($batchExam->id)
            ->select('id', 'title', 'slug', 'status')
            ->with(['batchExamSections' => function($batchExamSections){
                $batchExamSections->whereStatus(1)
                    ->where('available_at', '<=', currentDateTimeYmdHi())
                    ->orderBy('order', 'ASC')
                    ->select('id', 'batch_exam_id', 'title', 'available_at', 'is_paid')
                    ->with(['batchExamSectionContents' => function($batchExamSectionContents){
                        $batchExamSectionContents->where('available_at_timestamp', '<=', strtotime(currentDateTimeYmdHi()))
                            ->whereIn('content_type', ['exam', 'written_exam'])
                            ->whereStatus(1)
                            ->orderBy('order', 'ASC')
                            ->get();
                    }]);
            }])->first();

        $this->data = [
            'exam'  => $this->exam,
            'batchExamSection'  => $batchExamSection,
            'totalStudentEnrollments'  => $totalStudentEnrollments,
            'enrollStatus'  => ViewHelper::checkUserBatchExamIsEnrollment(ViewHelper::loggedUser(),$this->exam),
            'comments' => ContactMessage::where(['status' => 1, 'type' => 'batch_exam', 'parent_model_id' => $this->exam->id, 'is_seen' => 1])->get(),
        ];
        return ViewHelper::checkViewForApi($this->data);
    }

    public function orderXm (Request $request, $id)
    {
        if (ViewHelper::authCheck())
        {
            if (isset($request->rc))
            {
                $existAffiliateUser = AffiliationRegistration::where('user_id', ViewHelper::loggedUser()->id)->first();
                if (isset($existAffiliateUser) && $existAffiliateUser->affiliate_code == $request->rc)
                {
                    return ViewHelper::returEexceptionError('You can not use your own referral code.');
                }
            }
            if ($request->payment_method == 'ssl')
            {
                if (str()->contains(url()->current(), '/api/'))
                {
                    ParentOrder::createOrderAfterSsl($request);
                    return response()->json(['success' => 'Payment completed successfully.']);
                }
                $request['details_url'] = url()->previous();
                $request['model_name'] = 'batch_exam';
                $request['model_id'] = $id;
                $request['affiliate_amount'] = isset(BatchExam::find($id)->affiliate_amount) ? BatchExam::find($id)->affiliate_amount : 0;
                \session()->put('requestData', $request->all());
                return CheckoutController::sendOrderRequestToSSLZ($request->total_amount, BatchExam::find($id)->title);
            } elseif ($request->payment_method == 'cod')
            {
                $validator = Validator::make($request->all(), [
                    'paid_to'   => 'required',
                    'paid_from'   => 'required',
                    'txt_id'   => 'required',
                    'vendor'   => 'required',
                    'batch_exam_subscription_id'   => 'required',
                ]);
                if ($validator->fails())
                {
                    return ViewHelper::returEexceptionError($validator->errors());
//                return back()->withErrors($validator);
                }
                ParentOrder::storeXmOrderInfo($request, $id);
                if (isset($request->rc))
                {
                    AffiliationHistory::createNewHistory($request, 'batch_exam', $id, BatchExam::find($id)->affiliate_amount, 'insert');
                }
                return ViewHelper::returnSuccessMessage('You successfully purchased this exam.');
            }

//            return back()->with('success', 'You successfully purchased this exam');
        } else {
            return back()->with('error','Please Login First.');
        }
    }
// course exam
    // public function showCourseExamAnswers($contentId)
    // {
    //     $this->sectionContent = CourseSectionContent::whereId($contentId)->select('id', 'course_section_id', 'parent_id', 'content_type', 'title', 'status', 'exam_end_time_timestamp','exam_duration_in_minutes','written_exam_duration_in_minutes')->with(['questionStores' => function($questionStores){
    //         $questionStores->select('id', 'question_type', 'question', 'question_description', 'question_image', 'question_video_link', 'written_que_ans', 'written_que_ans_description', 'has_all_wrong_ans', 'status', 'mcq_ans_description')->with('questionOptions')->get();
    //     }])->first();


    //     $this->courseExamResults = CourseExamResult::where(['course_section_content_id' => $contentId])->orderBy('result_mark', 'DESC')->orderBy('required_time', 'ASC')->with(['courseSectionContent' => function($courseSectionContent) {
    //         $courseSectionContent->select('id',  'course_section_id', 'exam_total_questions','exam_per_question_mark', 'written_total_questions')->first();
    //     },
    //         'user'])->get();

    //     $myRank = [];
    //     foreach ($this->courseExamResults as $index => $courseExamResult)
    //     {
    //         if ($courseExamResult->user_id == ViewHelper::loggedUser()->id)
    //         {
    //             $myRank = $courseExamResult;
    //             $myRank['position'] = ++$index;
    //         }
    //     }

    //     //        student xm perticipant check
    //     $xmAllResults   = CourseExamResult::where('course_section_content_id', $contentId)->get();
    //     $userXmPerticipateStatus = false;
    //     foreach ($xmAllResults as $xmSingleResult)
    //     {
    //         if ($xmSingleResult->user_id == ViewHelper::loggedUser()->id )
    //         {
    //             $userXmPerticipateStatus    = true;
    //             break;
    //         }
    //     }
    //     if (strtotime(currentDateTimeYmdHi()) > $this->sectionContent->exam_end_time_timestamp)
    //     {
    //         $userXmPerticipateStatus = true;
    //     }
    //     if (!$userXmPerticipateStatus)
    //     {
    //         return ViewHelper::returEexceptionError('You can\'t view the answers till exam ends.');
    //     }
    //     //        student xm perticipant check ends



    //     if ($this->sectionContent->content_type == 'exam')
    //     {
    //         $getProvidedAnswers = CourseExamResult::where(['course_section_content_id' => $contentId, 'user_id' => ViewHelper::loggedUser()->id])->first();
    //         if (isset($getProvidedAnswers->provided_ans))
    //         {
    //             $this->ansLoop($this->sectionContent, (array) json_decode($getProvidedAnswers->provided_ans));
    //         }
    //     } elseif ($this->sectionContent->content_type == 'written_exam')
    //     {
    //         $writtenXmFile = CourseExamResult::where(['xm_type' => 'written_exam', 'course_section_content_id' => $contentId,'user_id'=>ViewHelper::loggedUser()->id])->select('id', 'course_section_content_id', 'xm_type', 'user_id', 'written_xm_file')->first();
    //         if (str()->contains(url()->current(), '/api/'))
    //         {
    //             $writtenXmFile = $writtenXmFile->written_xm_file;
    //         }
    //     }

    //     $this->data = [
    //         'content'   => $this->sectionContent,
    //         'writtenFile' => $writtenXmFile ?? null,
    //         'myPosition'    => $myRank,

    //     ];
    //     return ViewHelper::checkViewForApi($this->data, 'frontend.exams.course.show-ans');
    // }

    public function showArchiveExamAnswers($contentId)
    {
        return $this->sectionContent = BatchExamSectionContent::whereId($contentId)->select('id', 'batch_exam_section_id', 'parent_id', 'content_type', 'title', 'status', 'exam_total_questions', 'exam_per_question_mark', 'exam_pass_mark', 'exam_duration_in_minutes', 'exam_negative_mark', 'exam_end_time', 'exam_end_time_timestamp', 'written_start_time', 'written_start_time_timestamp', 'written_end_time', 'written_end_time_timestamp', 'written_publish_time', 'written_publish_time_timestamp', 'exam_result_publish_time', 'exam_result_publish_time_timestamp')->with(['questionStores' => function($questionStores){
            $questionStores->select('id', 'question_type', 'question', 'question_description', 'question_image', 'question_video_link', 'written_que_ans', 'written_que_ans_description', 'has_all_wrong_ans', 'status', 'mcq_ans_description')->with('questionOptions')->get();
        }])->first();

        if ($this->sectionContent->content_type == 'exam')
        {
            $getProvidedAnswers = ArchiveExamResult::where(['archive_exam_section_content_id' => $contentId, 'user_id' => ViewHelper::loggedUser()->id])->first();
            if (isset($getProvidedAnswers->provided_ans))
            {
                $this->ansLoop($this->sectionContent, (array) json_decode($getProvidedAnswers->provided_ans));
            }
        } elseif ($this->sectionContent->content_type == 'written_exam')
        {
            $writtenXmFile = ArchiveExamResult::where(['xm_type' => 'written_exam', 'archive_exam_section_content_id' => $contentId,'user_id' => ViewHelper::loggedUser()->id])->select('id', 'batch_exam_section_content_id', 'xm_type', 'user_id', 'written_xm_file')->first();
            if (str()->contains(url()->current(), '/api/'))
            {
                $writtenXmFile = $writtenXmFile->written_xm_file;
            }
        }

        return response()->json([
            'content'   => $this->sectionContent,
            'batchExamResult'   => $getProvidedAnswers ?? null,
            'writtenFile' => $writtenXmFile ?? null
        ],200);

    }

    public function showArchiveExamRanking($contentId)
    {

        $result = BatchExamResult::selectRaw('
                COUNT(*) as total_students,
                SUM(CASE WHEN status = "pass" THEN 1 ELSE 0 END) as passed_students,
                SUM(CASE WHEN status = "fail" THEN 1 ELSE 0 END) as failed_students
            ')->where('batch_exam_section_content_id', $contentId)
                ->first();

        $this->courseExamResults = ArchiveExamResult::where(['archive_exam_section_content_id' => $contentId, 'user_id' =>  ViewHelper::loggedUser()->id])->with('user')->first();

        return response()->json([
            'courseExamResult'     => $this->courseExamResults,
            'result'     => $result,
        ],200);

    }


    public function showCourseExamAnswers($contentId)
    {
        $this->sectionContent = CourseSectionContent::whereId($contentId)->select('id', 'course_section_id', 'parent_id', 'content_type', 'title', 'status', 'exam_end_time_timestamp', 'exam_total_questions', 'exam_per_question_mark', 'exam_pass_mark', 'exam_duration_in_minutes', 'exam_negative_mark')->with(['questionStores' => function($questionStores){
            $questionStores->select('id', 'question_type', 'question', 'question_description', 'question_image', 'question_video_link', 'written_que_ans', 'written_que_ans_description', 'has_all_wrong_ans', 'status', 'mcq_ans_description')->with('questionOptions')->get();
        }])->first();

        $xmAllResults   = CourseExamResult::where('course_section_content_id', $contentId)->get();
        $userXmPerticipateStatus = false;
        if($xmAllResults){
            foreach ($xmAllResults as $xmSingleResult)
            {
                if ($xmSingleResult->user_id == ViewHelper::loggedUser()->id )
                {
                    $userXmPerticipateStatus    = true;
                    break;
                }
            }
        }

        if (strtotime(currentDateTimeYmdHi()) > isset($this->sectionContent->exam_end_time_timestamp))
        {
            $userXmPerticipateStatus = true;
        }
        if (!$userXmPerticipateStatus)
        {
            return ViewHelper::returEexceptionError('You can\'t view the answers till exam ends.');
        }
        //        student xm perticipant check ends



        if (isset($this->sectionContent->content_type) == 'exam')
        {
            $getProvidedAnswers = CourseExamResult::where(['course_section_content_id' => $contentId, 'user_id' => ViewHelper::loggedUser()->id])->first();
            if (isset($getProvidedAnswers->provided_ans))
            {
                $this->ansLoop($this->sectionContent, (array) json_decode($getProvidedAnswers->provided_ans));
            }
        } elseif (isset($this->sectionContent->content_type) == 'written_exam')
        {
            $writtenXmFile = CourseExamResult::where(['xm_type' => 'written_exam', 'course_section_content_id' => $contentId,'user_id'=>ViewHelper::loggedUser()->id])->select('id', 'course_section_content_id', 'xm_type', 'user_id', 'written_xm_file')->first();
            if (str()->contains(url()->current(), '/api/'))
            {
                $writtenXmFile = $writtenXmFile->written_xm_file;
            }
        }

        $this->data = [
            'content'   => $this->sectionContent ?? null,
            'courseExamResult' => $getProvidedAnswers ?? null,
            'writtenFile' => $writtenXmFile ?? null
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.exams.course.show-ans');
    }
// class exam
    public function showCourseClassExamAnswers($contentId)
    {
        $this->sectionContent = CourseSectionContent::whereId($contentId)->select('id', 'course_section_id', 'parent_id', 'content_type', 'title', 'status', 'exam_end_time_timestamp','exam_duration_in_minutes','written_exam_duration_in_minutes','class_xm_duration_in_minutes')->with(['questionStoresForClassXm' => function($questionStores){
            $questionStores->select('id', 'question_type', 'question', 'question_description', 'question_image', 'question_video_link', 'written_que_ans', 'written_que_ans_description', 'has_all_wrong_ans', 'status', 'mcq_ans_description')->with('questionOptions')->get();
        }])->first();

        // dd($this->sectionContent);

        $this->courseExamResults = CourseClassExamResult::where(['course_section_content_id' => $contentId])->orderBy('result_mark', 'DESC')->orderBy('required_time', 'ASC')->with(['courseSectionContent' => function($courseSectionContent) {
            $courseSectionContent->select('id',  'course_section_id', 'exam_total_questions','exam_per_question_mark', 'written_total_questions')->first();
        },
            'user'])->get();

        $myRank = [];
        foreach ($this->courseExamResults as $index => $courseExamResult)
        {
            if ($courseExamResult->user_id == ViewHelper::loggedUser()->id )
            {
                $myRank = $courseExamResult;
                $myRank['position'] = ++$index;
            }
        }

        //student xm perticipant check
        $xmAllResults = CourseExamResult::where('course_section_content_id', $contentId)->get();
        $userXmPerticipateStatus = false;
        foreach ($xmAllResults as $xmSingleResult)
        {
            if ($xmSingleResult->user_id == ViewHelper::loggedUser()->id )
            {
                $userXmPerticipateStatus = true;
                break;
            }
        }

        if (strtotime(currentDateTimeYmdHi()) > isset($this->sectionContent->exam_end_time_timestamp))
        {
            $userXmPerticipateStatus = true;
        }
        if (!$userXmPerticipateStatus)
        {
            return ViewHelper::returEexceptionError('You can\'t view the answers till exam ends.');
        }
        //        student xm perticipant check ends





        if (isset($this->sectionContent->content_type) == 'video')
        {
            $getProvidedAnswers = CourseClassExamResult::where(['course_section_content_id' => $contentId, 'user_id' => ViewHelper::loggedUser()->id])->first();

            if (isset($getProvidedAnswers->provided_ans))
            {
                $this->ansLoop($this->sectionContent, (array) json_decode($getProvidedAnswers->provided_ans));
            }
        } elseif (isset($this->sectionContent->content_type) == 'written_exam')
        {
            $writtenXmFile = CourseClassExamResult::where(['xm_type' => 'written_exam', 'course_section_content_id' => $contentId,'user_id'=>ViewHelper::loggedUser()->id])->select('id', 'course_section_content_id', 'xm_type', 'user_id', 'written_xm_file')->first();
            if (str()->contains(url()->current(), '/api/'))
            {
                $writtenXmFile = $writtenXmFile->written_xm_file;
            }
        }

        // dd($this->sectionContent['questionStoresForClassXm'][0]);

        $this->courseExamResults = CourseClassExamResult::where(['course_section_content_id' => $contentId])->orderBy('result_mark', 'DESC')->orderBy('required_time', 'ASC')->with(['courseSectionContent' => function($courseSectionContent) {
            $courseSectionContent->select('id',  'course_section_id', 'exam_total_questions','exam_per_question_mark', 'written_total_questions')->first();
        },
            'user'])->get();

        if ($this->sectionContent->content_type == 'video') {
            # code...
            $myRank = [];
            if ($this->courseExamResults != null) {
                # code...
                foreach ($this->courseExamResults as $index => $courseExamResult)
                {
                    if ($courseExamResult->user_id == ViewHelper::loggedUser()->id)
                    {
                        $myRank = $courseExamResult;
                        $myRank['position'] = ++$index;
                    }
                }
            }

        }else{

            $myRank = [];
            if ($this->courseExamResults != null) {
                # code...
                foreach ($this->courseExamResults as $index => $courseExamResult)
                {
                    if ($courseExamResult->user_id == ViewHelper::loggedUser()->id)
                    {
                        $myRank = $courseExamResult;
                        $myRank['position'] = ++$index;
                    }
                }
            }

        }




        $this->data = [
            'content'   => $this->sectionContent,
            'writtenFile' => $writtenXmFile ?? null,
            'myPosition'    => $myRank,
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.exams.course.class.show-ans');
    }

    public function showBatchExamAnswers($contentId)
    {
        $this->sectionContent = BatchExamSectionContent::whereId($contentId)->select('id', 'batch_exam_section_id', 'parent_id', 'content_type', 'title', 'status','exam_duration_in_minutes','written_exam_duration_in_minutes')->with(['questionStores' => function($questionStores){
            $questionStores->select('id', 'question_type', 'question', 'question_description', 'question_image', 'question_video_link', 'written_que_ans', 'written_que_ans_description', 'has_all_wrong_ans', 'status', 'mcq_ans_description')->with('questionOptions')->get();
        }])->first();

        if (isset($this->sectionContent->content_type) == 'exam')
        {
            $getProvidedAnswers = BatchExamResult::where(['batch_exam_section_content_id' => $contentId, 'user_id' => ViewHelper::loggedUser()->id])->first();
            if (isset($getProvidedAnswers->provided_ans))
            {
                $this->ansLoop($this->sectionContent, (array) json_decode($getProvidedAnswers->provided_ans));
            }
        } elseif (isset($this->sectionContent->content_type) == 'written_exam')
        {
            $writtenXmFile = BatchExamResult::where(['xm_type' => 'written_exam', 'batch_exam_section_content_id' => $contentId,'user_id' => ViewHelper::loggedUser()->id])->select('id', 'batch_exam_section_content_id', 'xm_type', 'user_id', 'written_xm_file')->first();
             if (str()->contains(url()->current(), '/api/'))
            {
                $writtenXmFile = $writtenXmFile->written_xm_file;
            }
        }

        $this->courseExamResults = BatchExamResult::where(['batch_exam_section_content_id' => $contentId])->orderBy('result_mark', 'DESC')->orderBy('required_time', 'ASC')->with(['batchExamSectionContent' => function($batchExamSectionContent) {
            $batchExamSectionContent->select('id',  'batch_exam_section_id', 'exam_total_questions','exam_per_question_mark', 'written_total_questions')->first();
        },
            'user'])->get();
        $myRank = [];
        foreach ($this->courseExamResults as $index => $courseExamResult)
        {
            if ($courseExamResult->user_id == ViewHelper::loggedUser()->id)
            {
                $myRank = $courseExamResult;
                $myRank['position'] = ++$index;
            }
        }
        $this->data = [
            'content'   => $this->sectionContent,
            'writtenFile' => $writtenXmFile ?? null,
            'myPosition'    => $myRank

        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.exams.batch-exam.show-ans');
    }


    public function ansLoop($sectionContent, $providedAnswers)
    {
        // dd($sectionContent->questionStores);
        foreach ($sectionContent->questionStores as $questionStore)
        {
            foreach ($questionStore->questionOptions as $questionOption)
            {
                foreach ($providedAnswers as $questionId => $providedAnswer)
                {
                    if($questionStore->id == $questionId){
                        $questionStore->has_answered=1;
                    }
                    if ($questionId == $questionStore->id && $questionOption->is_correct == 1 && $questionOption->id == $providedAnswer->answer)
                    {
                        $questionOption->my_ans = 1;
                        break;
                    } elseif ($questionId == $questionStore->id && $questionOption->is_correct == 0 && $questionOption->id == $providedAnswer->answer)
                    {
                        $questionOption->my_ans = 0;
                        break;
                    } else {
                        $questionOption->my_ans = 2;
                    }
                }
            }
        }
        if($sectionContent->questionStoresForClassXm) {
            foreach ($sectionContent->questionStoresForClassXm as $questionStore) {
                foreach ($questionStore->questionOptions as $questionOption) {
                    foreach ($providedAnswers as $questionId => $providedAnswer) {
                        if ($questionStore->id == $questionId) {
                            $questionStore->has_answered = 1;
                        }
                        if ($questionId == $questionStore->id && $questionOption->is_correct == 1 && $questionOption->id == $providedAnswer->answer) {
                            $questionOption->my_ans = 1;
                            break;
                        } elseif ($questionId == $questionStore->id && $questionOption->is_correct == 0 && $questionOption->id == $providedAnswer->answer) {
                            $questionOption->my_ans = 0;
                            break;
                        } else {
                            $questionOption->my_ans = 2;
                        }
                    }
                }
            }
        }
    }
   /* public function showCourseExamRanking($contentId)
    {
        $this->courseExamResults = CourseExamResult::where(['course_section_content_id' => $contentId])->orderBy('result_mark', 'DESC')->orderBy('required_time', 'ASC')->with(['courseSectionContent' => function($courseSectionContent) {
            $courseSectionContent->select('id',  'course_section_id', 'exam_total_questions','exam_per_question_mark', 'written_total_questions','exam_duration_in_minutes','written_exam_duration_in_minutes')->first();
        },
            'user'])->get();
        $myRank = [];
        foreach ($this->courseExamResults as $index => $courseExamResult)
        {
            if ($courseExamResult->user_id == ViewHelper::loggedUser()->id)
            {
                $myRank = $courseExamResult;
                $myRank['position'] = ++$index;
            }
        }
        // $total=CourseExamResult::where('course_section_content_id',$contentId)->get();
        // return count($total);
        $this->data = [
            'courseExamResults'     => $this->courseExamResults,
            'myPosition'    => $myRank,
            // 'total_question'=>count(CourseSectionContent::where('course_section_id',$contentId)->get())
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.exams.course.show-ranking');
    }*/

    public function showCourseExamRanking($contentId)
    {
        $this->courseExamResults = CourseExamResult::where(['course_section_content_id' => $contentId])->orderBy('result_mark', 'DESC')->orderBy('required_time', 'ASC')->with(['courseSectionContent' => function($courseSectionContent) {
            $courseSectionContent->select('id',  'course_section_id', 'exam_total_questions','exam_per_question_mark', 'written_total_questions')->first();
        },
            'user'])->paginate(100);

        //return $this->courseExamResults;
        $this->data = [
            'courseExamResults'     => $this->courseExamResults,
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.exams.course.show-ranking');
    }


    public function showBatchExamRanking($contentId)
    {
        $this->courseExamResults = BatchExamResult::where(['batch_exam_section_content_id' => $contentId])->orderBy('result_mark', 'DESC')->orderBy('required_time', 'ASC')->with(['batchExamSectionContent' => function($batchExamSectionContent) {
            $batchExamSectionContent->select('id',  'batch_exam_section_id', 'exam_total_questions','exam_per_question_mark', 'written_total_questions','exam_duration_in_minutes','written_exam_duration_in_minutes')->first();
        },
            'user'])->get();
        $myRank = [];
        foreach ($this->courseExamResults as $index => $courseExamResult)
        {
            if ($courseExamResult->user_id == ViewHelper::loggedUser()->id)
            {
                $myRank = $courseExamResult;
                $myRank['position'] = ++$index;
            }
        }
        $this->data = [
            'courseExamResults'     => $this->courseExamResults,
            'myPosition'    => $myRank
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.exams.batch-exam.show-ranking');
    }
    public function pdfViewTest ()
    {
//        return Response::make(file_get_contents('assets/pdf-demo.pdf'), 200, [
//            'content-type'=>'application/pdf',
//        ]);
//        return view('backend.exam-management.xm-sheets.view-pdf-test');
    }

//     public function uploadAssignmentFiles(Request $request)
//     {
// //        return $request;
//         try {
//             $imageUrl = '';
//             $this->pdfFilePath = '';

//             if (!empty($request->file('files')))
//             {
//                 foreach ($request->file('files') as $ans_file)
//                 {
//                     $imageUrl = imageUpload($ans_file, 'course-xm-temp-file-upload/', 'tmp-', 600, 800);
//                     array_push($this->fileSessionPaths, $imageUrl);
//                     $this->filePathString .= public_path($imageUrl).' ';
//                 }
//                 $this->pdfFilePath = 'backend/assets/uploaded-files/course-assignment-files/'.rand(10000,99999).time().'.pdf';
//                 if (!File::isDirectory(public_path('backend/assets/uploaded-files/course-assignment-files')))
//                 {
//                     File::makeDirectory(public_path('backend/assets/uploaded-files/course-assignment-files'), 0777, true, true);
//                 }
// //                        shell_exec('magick convert'. $this->filePathString.public_path($this->pdfFilePath));
// //               echo shell_exec('convert '. $this->filePathString.public_path($this->pdfFilePath));
// //                echo shell_exec("convert image.png image.pdf");
// //              echo putenv("PATH=your_path_to_the_bin_folder");
//                 $output = shell_exec('ls -lart');
//                 echo "<pre>$output</pre>";
//                 echo 'sarowar';
//                 return 0;
//                 AssignmentFile::create([
//                     'course_section_content_id' => $request->course_content_id,
//                     'file'  => $this->pdfFilePath,
//                     'file_type' => 'pdf',
//                     'user_id'   => ViewHelper::loggedUser()->id
//                 ]);
//                 foreach ($this->fileSessionPaths as $fileSessionPath)
//                 {
//                     if (file_exists($fileSessionPath))
//                     {
//                         unlink($fileSessionPath);
//                     }
//                 }
//                 return ViewHelper::returnSuccessMessage('Files Uploaded successfully.');
//             } else {
//                 return ViewHelper::returEexceptionError('No files found.');
//             }
//         } catch (\Exception $exception)
//         {
//             return ViewHelper::returEexceptionError($exception->getMessage());
//         }
//     }

  public function uploadAssignmentFiles(Request $request)
    {
        try {
            $imageUrl = '';
            $this->pdfFilePath = '';
            if (!empty($request->file('files')))
            {
                foreach ($request->file('files') as $ans_file)
                {
                    $imageUrl = imageUpload($ans_file, 'course-xm-temp-file-upload/', 'tmp-', 600, 800);
                    array_push($this->fileSessionPaths, $imageUrl);
                    $this->filePathString .= public_path($imageUrl).' ';
//                    $this->filePathString .= $_SERVER['DOCUMENT_ROOT'].'/'.$imageUrl.' ';
                }
                $this->pdfFilePath = 'backend/assets/uploaded-files/course-assignment-files/'.rand(10000,99999).time().'.pdf';
                if (!File::isDirectory(public_path('backend/assets/uploaded-files/course-assignment-files')))
                {
                    File::makeDirectory(public_path('backend/assets/uploaded-files/course-assignment-files'), 0777, true, true);
                }


                // exec('convert /home/biddabari/biddabari/public/backend/assets/uploaded-files/course-xm-temp-file-upload/tmp--1712313447380.jpg /home/biddabari/biddabari/public/backend/assets/uploaded-files/course-xm-temp-file-upload/tmp--1712313447829.jpg /home/biddabari/biddabari/public/backend/assets/uploaded-files/course-assignment-files/829821712313447.pdf');

//                exec('convert '. $this->filePathString.$_SERVER['DOCUMENT_ROOT'].'/'.$this->pdfFilePath);
                // exec('convert '. $this->filePathString.public_path($this->pdfFilePath));
                        // shell_exec('magick convert '. $this->filePathString.public_path($this->pdfFilePath));
                 shell_exec('convert '. $this->filePathString.public_path($this->pdfFilePath));
                AssignmentFile::create([
                    'course_section_content_id' => $request->course_content_id,
                    'file'  => $this->pdfFilePath,
                    'file_type' => 'pdf',
                    'user_id'   => ViewHelper::loggedUser()->id
                ]);
                foreach ($this->fileSessionPaths as $fileSessionPath)
                {
                    if (file_exists($fileSessionPath))
                    {
                        unlink($fileSessionPath);
                    }
                }
                return ViewHelper::returnSuccessMessage('Files Uploaded successfully.');
            } else {
                return ViewHelper::returEexceptionError('No files found.');
            }
        } catch (\Exception $exception)
        {
            return ViewHelper::returEexceptionError($exception->getMessage());
        }
    }
    public function setXmStartStatus(Request $request)
    {
        $xmStartedStatus    = [
            'user_id'   => ViewHelper::loggedUser()->id,
            'xmType'    => $request->xmType,
            'xmUrl'     => $request->xmUrl,
            'xmContentId'     => $request->xmContentId,
            'xmStartStatus' => 1
        ];
        session()->put('getXmStartStatus', $xmStartedStatus);
        return response()->json('Xm Status set success');
//        return response()->json($request);
    }
    public function setXmDataToSession(Request $request)
    {
        session()->put('getXmDataToSession', $request->toArray());
        return response()->json('Xm DAta set success');
    }


    public function startFreeExam ($contentId)
    {
        if (ViewHelper::authCheck())
        {
            if (session()->has('getXmStartStatus'))
            {
                if (session('getXmStartStatus')['xmStartStatus'] == 1)
                {
                    if (session('getXmStartStatus')['xmType'] == 'course')
                    {
                        return $this->commonGetCourseExamResul((object) session('getXmDataToSession'), session('getXmStartStatus')['xmContentId']);
                    }
                }
            }

            $this->exam = CourseSectionContent::with('questionStores.questionOptions')->whereId($contentId)->first();

            $this->data = [
                'exam'   => $this->exam,
            ];
            return ViewHelper::checkViewForApi($this->data, 'frontend.free-service.start');
        } else {
            return back()->with('error', 'Please Login First.');
        }
    }

    public function showPracticeExamAnswers($contentId)
    {

        $this->sectionContent = CourseSectionContent::whereId($contentId)->select('id', 'course_section_id', 'parent_id', 'content_type', 'title', 'status', 'exam_end_time', 'exam_end_time_timestamp', 'exam_total_questions', 'exam_per_question_mark', 'exam_pass_mark', 'exam_duration_in_minutes', 'exam_negative_mark', 'exam_result_publish_time', 'exam_result_publish_time_timestamp', 'written_start_time', 'written_end_time', 'written_publish_time')->with(['questionStores' => function($questionStores){
            $questionStores->select('id', 'question_type', 'question', 'question_description', 'question_image', 'question_video_link', 'written_que_ans', 'written_que_ans_description', 'has_all_wrong_ans', 'status', 'mcq_ans_description')->with('questionOptions')->get();
        }])->first();

        $xmAllResults   = CourseExamResult::where('course_section_content_id', $contentId)->get();
        $userXmPerticipateStatus = false;
        foreach ($xmAllResults as $xmSingleResult)
        {
            if ($xmSingleResult->user_id == ViewHelper::loggedUser()->id )
            {
                $userXmPerticipateStatus    = true;
                break;
            }
        }
        if (strtotime(currentDateTimeYmdHi()) > $this->sectionContent->exam_end_time_timestamp)
        {
            $userXmPerticipateStatus = true;
        }
        if (!$userXmPerticipateStatus)
        {
            return ViewHelper::returEexceptionError('You can\'t view the answers till exam ends.');
        }
        //        student xm perticipant check ends



        if ($this->sectionContent->content_type == 'exam')
        {
            $getProvidedAnswers = PracticeExamResult::where(['course_section_content_id' => $contentId, 'user_id' => ViewHelper::loggedUser()->id])->first();
            if (isset($getProvidedAnswers->provided_ans))
            {
                $this->ansLoop($this->sectionContent, (array) json_decode($getProvidedAnswers->provided_ans));
            }
        } elseif ($this->sectionContent->content_type == 'written_exam')
        {
            $writtenXmFile = PracticeExamResult::where(['xm_type' => 'written_exam', 'course_section_content_id' => $contentId,'user_id'=>ViewHelper::loggedUser()->id])->select('id', 'course_section_content_id', 'xm_type', 'user_id', 'written_xm_file')->first();
            if (str()->contains(url()->current(), '/api/'))
            {
                $writtenXmFile = $writtenXmFile->written_xm_file;
            }
        }

        $this->data = [
            'content'   => $this->sectionContent,
            'courseExamResult' => $getProvidedAnswers ?? null,
            'writtenFile' => $writtenXmFile ?? null
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.exams.course.show-ans');
    }

    public function showPracticeExamResult ($xmId, $xmResultId = null)
    {
        $previousExamUrl = session('previousExamUrl');

        $this->exam = CourseSectionContent::whereId($xmId)->first();


        if (isset($xmResultId))
        {
            $this->xmResult = PracticeExamResult::find($xmResultId);
        } else {
            $this->xmResult = PracticeExamResult::where('course_section_content_id', $xmId)->latest()->first();
        }

        $this->data = [
            'exam'  => $this->exam,
            'examResult'    => $this->xmResult,
            'previousExamUrl'    => $previousExamUrl,
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.free-service.result');
    }

    public function showPracticeExamRanking($contentId)
    {
        $result = CourseExamResult::selectRaw('
                COUNT(*) as total_students,
                SUM(CASE WHEN status = "pass" THEN 1 ELSE 0 END) as passed_students,
                SUM(CASE WHEN status = "fail" THEN 1 ELSE 0 END) as failed_students
            ')->where('course_section_content_id', $contentId)
                ->first();

        $this->courseExamResults = PracticeExamResult::where(['course_section_content_id' => $contentId, 'user_id' => ViewHelper::loggedUser()->id])->with('user')->first();

        $this->data = [
            'courseExamResult'     => $this->courseExamResults,
            'result'     => $result,
        ];

        return ViewHelper::checkViewForApi($this->data, 'frontend.free-service.show-ranking');
    }

}
