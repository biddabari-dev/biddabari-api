<?php

namespace App\Http\Controllers\Backend\ExamManagement;

use App\Http\Controllers\Controller;
use App\Models\Backend\BatchExamManagement\BatchExam;
use App\Models\Backend\BatchExamManagement\BatchExamResult;
use App\Models\Backend\BatchExamManagement\BatchExamSection;
use App\Models\Backend\BatchExamManagement\BatchExamSectionContent;
use App\Models\Backend\Course\Course;
use App\Models\Backend\Course\CourseClassExamResult;
use App\Models\Backend\Course\CourseExamResult;
use App\Models\Backend\Course\CourseSection;
use App\Models\Backend\Course\CourseSectionContent;
use App\Models\Backend\ExamManagement\AssignmentFile;
use App\Models\Backend\ExamManagement\Exam;
use App\Models\Backend\ExamManagement\ExamCategory;
use App\Models\Backend\ExamManagement\ExamResult;
use App\Models\Backend\QuestionManagement\QuestionStore;
use App\Models\Backend\QuestionManagement\QuestionTopic;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    private $questions, $exam, $exams, $examSheets = [], $examResults = [], $enrolledUsers = [], $xmParticipateUsers = [], $presentStudents = [], $absentStudents = [];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.exam-management.exams.index', [
            'exams' => Exam::latest()->get(),
            'questionTopics' => QuestionTopic::whereStatus(1)->get(),
            'examCategories' => ExamCategory::where('exam_category_id', 0)->select('id', 'name')->whereStatus(1)->orderBy('order', 'ASC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required',
        ]);
        try {
            Exam::createOrUpdateExam($request);
            return back()->with('success', 'Exam created Successfully.');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
//        return view('backend.exam-management.exams.edit', [
//            'exam'  => Exam::find($id)
//        ]);
        $this->exam = Exam::whereId($id)->with(['questionStores' => function ($questionStore) {
            $questionStore->select('id', 'question')->get();
        }])->first();
//        return response()->json($this->exam);
        return view('backend.exam-management.exams.edit', [
            'exam' => $this->exam,
            'examCategories' => ExamCategory::where('exam_category_id', 0)->select('id', 'name')->whereStatus(1)->orderBy('order', 'ASC')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required',
        ]);
        try {
            Exam::createOrUpdateExam($request, $id);
            return back()->with('success', 'Exam Updated Successfully.');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Exam::find($id)->delete();
        return back()->with('success', 'Exam Updated Successfully.');
    }

    public function getQuestionsForExam(Request $request)
    {
        $this->questions = QuestionStore::whereStatus(1)->where('question_type', $request->question_type)->select('id', 'question')->get();
        return response()->json($this->questions);
    }

    public function showExamSheet(Request $request)
    {
//        return $request;
        if (!empty($request->section_content_id) && !empty($request->exam_of)) {
            if ($request->exam_of == 'course') {
                if ($request->exam_section_content_type == 'written')
                {
                    $this->examSheets = CourseExamResult::where('course_section_content_id', $request->section_content_id)->get();
                } elseif ($request->exam_section_content_type == 'assignment')
                {
                    $this->examSheets = AssignmentFile::where('course_section_content_id', $request->section_content_id)->get();
                }
            } elseif ($request->exam_of == 'batch_exam') {
                $this->examSheets = BatchExamResult::where('batch_exam_section_content_id', $request->section_content_id)->get();
            }
        }
//        else{
//            $this->examSheets =AssignmentFile::all();
//            $examOf='course';
//            $sectionContentType=' ';
//        }
        return view('backend.exam-management.xm-sheets.index', [
//            'exams'   => Exam::whereStatus(1)->where('xm_type', 'Written')->get(),
//            'exams'   => BatchExamResult::whereStatus(1)->where('xm_type', 'Written')->get(),
            'examSheets' => !empty($this->examSheets) ? $this->examSheets : '',
            'examOf' => isset($request->exam_of) ? $request->exam_of : '',
            'sectionContentType' => isset($request->exam_section_content_type) ? $request->exam_section_content_type : '',
        ]);
    }

    public function getCourseOrExamNames($xmOf)
    {
        if ($xmOf == 'course') {
            return response()->json(Course::where('status', 1)->select('id', 'title')->get());
        } elseif ($xmOf == 'batch_exam') {
            return response()->json(BatchExam::where('status', 1)->select('id', 'title')->get());
        }
    }

    public function getExamNames($xmOf, $typeId)
    {
        if ($xmOf == 'course') {
            return response()->json(CourseSection::where(['status' => 1, 'course_id' => $typeId])->select('id', 'title', 'course_id')->get());
        } elseif ($xmOf == 'batch_exam') {
            return response()->json(BatchExamSection::where(['status' => 1, 'batch_exam_id' => $typeId])->select('id', 'title', 'batch_exam_id')->get());
        }
    }

    public function getWrittenSectionContents($xmOf, $sectionId, $sectionContentType)
    {
        if (isset($xmOf, $sectionId))
        {
            if (isset($sectionContentType))
            {
                if ($xmOf == 'course') {
                    if ($sectionContentType == 'written')
                    {
                        return response()->json(CourseSectionContent::where(['status' => 1, 'course_section_id' => $sectionId, 'content_type' => 'written_exam'])->select('id', 'title', 'course_section_id')->get());
                    } elseif ($sectionContentType == 'assignment')
                    {
                        return response()->json(CourseSectionContent::where(['status' => 1, 'course_section_id' => $sectionId, 'content_type' => 'assignment'])->select('id', 'title', 'course_section_id')->get());
                    }

                } elseif ($xmOf == 'batch_exam') {
                    return response()->json(BatchExamSectionContent::where(['status' => 1, 'batch_exam_section_id' => $sectionId, 'content_type' => 'written_exam'])->select('id', 'title', 'batch_exam_section_id')->get());
                }
            } else {
                return response()->json(['error' => 'Please select Section Content Type.']);
            }
        } else {
            return response()->json(['error' => 'Please select all Xm of, and Section.']);
        }
    }

    public function updateExamResult(Request $request)
    {
//      return  isset($request->written_xm_file)?'sarowar':'mizan';
//        return $request;
       $data= ExamResult::updateXmResult($request);
        return $data;
        return back()->with('success', 'Exam Result Updated Successfully.');
    }

    public function getExamSheet($id)
    {
        return response()->json(ExamResult::find($id));
    }

    public function getExamsByCategory($id)
    {
        return response()->json(Exam::whereExamCategoryId($id)->whereStatus(1)->select('id', 'title', 'slug')->get());
    }

    public function checkExamPaper($id = null, $typeOf = null, $sectionContentType = null)
    {
//      $file=  $typeOf == 'course' ? ($sectionContentType == 'written' ? CourseExamResult::find($id) : AssignmentFile::find($id)) : BatchExamResult::find($id);
//
//      return $file->file;
        return view('backend.exam-management.xm-sheets.check-paper', [
            'examSheet' => $typeOf == 'course' ? ($sectionContentType == 'written' ? CourseExamResult::find($id) : AssignmentFile::find($id)) : BatchExamResult::find($id),
            'examOf' => $typeOf,
            'sectionContentType' => $sectionContentType,
        ]);
    }

    public function updateWrittenExamResult(Request $request, $id, $examOf = 'course', $sectionContentType = null)
    {
        $request['xm_result_id'] = $id;
        if ($examOf == 'course') {
            if ($sectionContentType == 'written')
            {
                CourseExamResult::updateXmResult($request, $examOf);
            } else {
                AssignmentFile::updateAssesmentFile($request);
            }
        } elseif ($examOf == 'batch_exam') {
            BatchExamResult::updateXmResult($request, $examOf);
        }
        return redirect()->route('show-exam-sheet')->with('success', 'Sheet updated successfully.');
    }

    public function getXmForAddQuestion(Request $request)
    {
        return view('backend.exam-management.exams.include-add-que-to-exams', [
            'exam' => Exam::whereId($request->exam_id)->select('id', 'title', 'exam_category_id', 'subject_name')->first(),
            'examType' => $request->exam_type,
            'questionTopics' => QuestionTopic::whereStatus(1)->whereType($request->exam_type == 'exam' ? 'mcq' : 'written')->select('id', 'question_topic_id', 'name')->get(),
        ]);
    }

    public function assignQuestionToExam(Request $request)
    {
        $this->sectionContent = Exam::find($request->exam_id);
        $this->sectionContent->questionStores()->attach($request->question_ids);
        return back()->with('success', 'Questions Added to this exam successfully.');
    }

    public function contentExamRankingDownloadPage($reqForm, $contentId)
    {
        if ($reqForm == 'course')
        {
            $this->examResults = CourseExamResult::where(['course_section_content_id' => $contentId])->orderBy('result_mark', 'DESC')->orderBy('required_time', 'ASC')->with(['courseSectionContent' => function($courseSectionContent) {
                $courseSectionContent->select('id',  'course_section_id', 'exam_total_questions','exam_per_question_mark', 'written_total_questions', 'exam_negative_mark')->first();
            },
                'user'])->get();
        } elseif ($reqForm == 'batch_exam') {
            $this->examResults = BatchExamResult::where(['batch_exam_section_content_id' => $contentId])->orderBy('result_mark', 'DESC')->orderBy('required_time', 'ASC')->with(['batchExamSectionContent' => function($batchExamSectionContent) {
                $batchExamSectionContent->select('id', 'batch_exam_section_id', 'exam_total_questions','exam_per_question_mark', 'written_total_questions', 'exam_negative_mark')->first();
            },
                'user'])->get();
        } elseif ($reqForm == 'course_class_exam')
        {
            $this->examResults = CourseClassExamResult::where(['course_section_content_id' => $contentId])->orderBy('result_mark', 'DESC')->orderBy('required_time', 'ASC')->with(['courseSectionContent' => function($courseSectionContent) {
                $courseSectionContent->select('id', 'course_section_id','class_xm_mark', 'class_xm_duration_in_minutes')->first();
            },
                'user'])->get();
        }
        return view('backend.exam-management.xm-ranking.index', [
            'examResults'   => $this->examResults,
            'req_form'       => $reqForm
        ]);
    }

    public function showXmAttendance($reqForm, $contentId)
    {
        if ($reqForm == 'course')
        {
            $content = CourseSectionContent::find($contentId);
            $baseType = $content->courseSection->course;
            $this->enrolledUsers = Course::find($baseType->id)->students;
            $this->xmParticipateUsers = CourseExamResult::where(['course_section_content_id' => $contentId])->get(['id', 'user_id', 'course_section_content_id']);
        } elseif ($reqForm == 'batch_exam')
        {
            $content = BatchExamSectionContent::find($contentId);
            $baseType = $content->batchExamSection->batchExam;
            $this->enrolledUsers = BatchExam::find($baseType->id)->students;
            $this->xmParticipateUsers = BatchExamResult::where(['batch_exam_section_content_id' => $contentId])->get(['id', 'user_id', 'batch_exam_section_content_id']);
        } elseif ($reqForm == 'course_class_exam')
        {
            $content = CourseSectionContent::find($contentId);
            $baseType = $content->courseSection->course;
            $this->enrolledUsers = Course::find($baseType->id)->students;
            $this->xmParticipateUsers = CourseClassExamResult::where(['course_section_content_id' => $contentId])->get(['id', 'user_id', 'course_section_content_id']);
        }
        
        foreach ($this->enrolledUsers as $enrolledUser)
        {
            $count = 0;
            if (count($this->xmParticipateUsers) > 0)
            {
                foreach ($this->xmParticipateUsers as $xmParticipateUser)
                {
                    if ($enrolledUser->user_id == $xmParticipateUser->user_id)
                    {
                        $count = $count + 1;
                        array_push($this->presentStudents, $enrolledUser->user);
                    }
//                    else {
//                        array_push($this->absentStudents, $enrolledUser->user);
//                    }
                }
                if ($count == 0)
                {
                    array_push($this->absentStudents, $enrolledUser->user);
                }
            } else {
                array_push($this->absentStudents, $enrolledUser->user);
            }
        }
        $data = [
            'presentStudents'   => $this->presentStudents,
            'absentStudents'   => $this->absentStudents,
            'examFrom'      => $baseType,
            'content'       => $content
        ];
        return view('backend.exam-management.xm-attendance.index', $data);
    }
}
