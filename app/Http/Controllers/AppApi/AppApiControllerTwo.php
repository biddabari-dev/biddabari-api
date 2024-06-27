<?php

namespace App\Http\Controllers\AppApi;

use App\helper\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\BatchExamManagement\BatchExamResult;
use App\Models\Backend\BatchExamManagement\BatchExamSectionContent;
use App\Models\Backend\Course\CourseClassExamResult;
use App\Models\Backend\Course\CourseExamResult;
use App\Models\Backend\Course\CourseSectionContent;
use App\Models\Backend\ExamManagement\AssignmentFile;
use Illuminate\Http\Request;
use function Nette\Utils\data;

class AppApiControllerTwo extends Controller
{
    protected $sectionContent, $data = [];
    public function startcourseExam ($contentId)
    {
        if (ViewHelper::authCheck())
        {
            $existExamResult = CourseExamResult::where(['course_section_content_id' => $contentId, 'user_id' => ViewHelper::loggedUser()->id])->first();
            if (!empty($existExamResult))
            {
                return response()->json(['error' => 'You already participate in this exam.'], 400);
            }
            $this->exam = CourseSectionContent::whereId($contentId)->select('id', 'course_section_id', 'parent_id', 'content_type', 'title', 'exam_mode', 'exam_duration_in_minutes', 'exam_total_questions', 'exam_per_question_mark', 'exam_negative_mark', 'exam_pass_mark', 'exam_is_strict', 'exam_start_time', 'exam_start_time_timestamp', 'exam_end_time', 'exam_end_time_timestamp', 'exam_result_publish_time', 'exam_result_publish_time_timestamp', 'exam_total_subject', 'written_exam_duration_in_minutes', 'written_total_questions', 'written_description', 'written_is_strict', 'written_start_time', 'written_start_time_timestamp', 'written_end_time', 'written_end_time_timestamp', 'written_publish_time', 'written_publish_time_timestamp', 'written_total_subject', 'is_paid', 'has_class_xm', 'course_section_content_id', 'status')->with(['questionStores' => function ($questionStores) {
                $questionStores->where(['status' => 1])->select('id', 'question_type', 'question', 'question_image', 'has_all_wrong_ans', 'status', 'written_que_file', 'question_option_image', 'subject_name')->with('questionOptions')->get();
            }])->first();
            $this->data = [
                'exam'   => $this->exam
            ];
            return response()->json($this->data);
        } else {
            return response()->json(['error' => 'Please Login First.'], 400);
        }
    }

    public function startClassExam($contentId)
    {
        if (ViewHelper::authCheck())
        {
            $this->sectionContent = CourseSectionContent::whereId($contentId)->select('id', 'course_section_id', 'parent_id', 'content_type', 'title', 'exam_mode', 'exam_duration_in_minutes', 'exam_total_questions', 'exam_per_question_mark', 'exam_negative_mark', 'exam_pass_mark', 'exam_is_strict', 'exam_start_time', 'exam_start_time_timestamp', 'exam_end_time', 'exam_end_time_timestamp', 'exam_result_publish_time', 'exam_result_publish_time_timestamp', 'exam_total_subject', 'is_paid', 'has_class_xm', 'course_section_content_id', 'class_xm_duration_in_minutes', 'status')->with(['questionStoresForClassXm' => function ($questionStores) {
                $questionStores->where(['status' => 1])->select('id', 'question_type', 'question', 'question_image', 'question_video_link', 'has_all_wrong_ans', 'status', 'written_que_file', 'question_option_image', 'subject_name')->with('questionOptions')->get();
            }])->first();
            $existUserClassXm = CourseClassExamResult::where(['course_section_content_id' => $this->sectionContent->id, 'user_id' => ViewHelper::loggedUser()->id])->first();
            if (isset($existUserClassXm))
            {
                return response()->json(['error' => 'You already passed the class Exam.']);
            }
            $this->data = [
                'exam'   => $this->sectionContent
            ];
            return response()->json($this->data, 200);
        } else {
            return response()->json(['error' => 'Please Login First.'], 400);
        }
    }

    public function startBatchExam ($contentId)
    {
        if (ViewHelper::authCheck())
        {
            $existExamResult = BatchExamResult::where(['batch_exam_section_content_id' => $contentId, 'user_id' => ViewHelper::loggedUser()->id])->first();
            if (!empty($existExamResult))
            {
                return response()->json(['error' => 'You already participate in this exam.'], 400);
            }
            $this->exam = BatchExamSectionContent::whereId($contentId)->select('id', 'batch_exam_section_id', 'parent_id', 'content_type', 'title', 'exam_mode', 'exam_duration_in_minutes', 'exam_total_questions', 'exam_per_question_mark', 'exam_negative_mark', 'exam_pass_mark', 'exam_is_strict', 'exam_start_time', 'exam_start_time_timestamp', 'exam_end_time', 'exam_end_time_timestamp', 'exam_result_publish_time', 'exam_result_publish_time_timestamp', 'exam_total_subject', 'written_exam_duration_in_minutes', 'written_total_questions', 'written_description', 'written_is_strict', 'written_start_time', 'written_start_time_timestamp', 'written_end_time', 'written_end_time_timestamp', 'written_publish_time', 'written_publish_time_timestamp', 'written_total_subject', 'is_paid', 'status')->with(['questionStores' => function ($questionStores) {
                $questionStores->where(['status' => 1])->select('id', 'question_type', 'question', 'question_image', 'question_video_link', 'has_all_wrong_ans', 'status', 'written_que_file', 'question_option_image', 'subject_name')->with('questionOptions')->get();
            }])->first();;
            $this->data = [
                'exam'   => $this->exam
            ];
            return response()->json($this->data, 200);
        } else {
            return response()->json(['error' => 'Please Login First.']);
        }
    }
    
    public function checkIfAssignmentExist($sectionContentId)
    {
        $existAssignment = AssignmentFile::where(['user_id' => auth()->user()->id, 'course_section_content_id' => $sectionContentId])->first();
        if (!empty($existAssignment))
        {
            return response()->json(['msg' => 'You already submitted assignment file']);
        } else {
            return response()->json(['msg' => 'false']);
        }
    }
}
