<?php

namespace App\Http\Controllers\Backend\BatchExamManagement;

use App\helper\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\BatchExamManagement\BatchExamSection;
use App\Models\Backend\BatchExamManagement\BatchExamSectionContent;
use App\Models\Backend\PdfManagement\PdfStoreCategory;
use App\Models\Backend\QuestionManagement\QuestionTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class BatchExamSectionContentController extends Controller
{
    //    permission seed done
    protected $sectionContent,$sectionContents;
    protected $questionTopics = [], $questionTopic, $questions;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('manage-batch-exam-section-content'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (!empty(\request()->input('section_id')))
        {
            return view('backend.batch-exam-management.section-contents.index', [
                'sectionContents'   => BatchExamSectionContent::whereBatchExamSectionId(\request()->input('section_id'))->latest()->get(),
                'batchExamSections'   => BatchExamSection::whereBatchExamId(\request()->input('batch_exam_id'))->get(),
                'pdfStoreCategories'   => PdfStoreCategory::whereStatus(1)->where('parent_id', 0)->select('id', 'title')->get(),
            ]);
        }
        return back()->with('error', 'Please Select a Batch Exam Section to get it\'s contents.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-batch-exam-section-content'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('store-batch-exam-section-content'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'content_type' => 'required',
            'title' => 'required',
            'available_at' => 'required',
        ]);
        BatchExamSectionContent::saveOrUpdateCourseSectionContent($request);
        if ($request->ajax())
        {
            return response()->json('Batch Exam Content saved successfully.');
        } else {
            return  back()->with('success', 'Batch Exam Content saved successfully.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-batch-exam-section-content'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.batch-exam-management.section-contents.show', [
            'sectionContent'    => BatchExamSectionContent::find($id),
            'pdfStoreCategories'   => PdfStoreCategory::whereStatus(1)->select('id', 'title')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-batch-exam-section-content'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.batch-exam-management.section-contents.edit', [
            'sectionContent'    => BatchExamSectionContent::find($id),
            'pdfStoreCategories'   => PdfStoreCategory::whereStatus(1)->where('parent_id', 0)->select('id', 'title')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-batch-exam-section-content'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        BatchExamSectionContent::saveOrUpdateCourseSectionContent($request, $id);
        if ($request->ajax())
        {
            return response()->json('Batch Exam Content saved successfully.');
        } else {
            return  back()->with('success', 'Batch Exam Content saved successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-batch-exam-section-content'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $batchExamSectionContent = BatchExamSectionContent::find($id);
        $batchExamSectionId = $batchExamSectionContent->batch_exam_section_id;
        $batchExamSectionContent->delete();

        ViewHelper::reorderSerials('batch_exam_section_content', $batchExamSectionId);
        return  back()->with('success', 'Batch Exam Content deleted successfully.');
    }

    public function getContentForAddQuestion (Request $request)
    {
        abort_if(Gate::denies('add-question-to-batch-exam-section-content'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            return view('backend.batch-exam-management.section-contents.include-add-que-to-contents', [
                'content'   => BatchExamSectionContent::find($request->section_content_id),
                'examType'  => $request->exam_type,
                'questionTopics'    => QuestionTopic::whereStatus(1)->whereType($request->exam_type == 'exam' ? 'mcq' : 'written')->where('question_topic_id', 0)->select('id', 'question_topic_id', 'name')->get(),
            ]);
        } catch (\Exception $exception)
        {
            return response()->json(['error' => $exception->getMessage()]);
        }

    }

    public function detachQuestionFromContent(Request $request)
    {
        abort_if(Gate::denies('detach-question-to-batch-exam-section-content'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            BatchExamSectionContent::find($request->content_id)->questionStores()->detach($request->question_id);
            return response()->json(['status' => 'success']);
        } catch (\Exception $exception)
        {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public function getQuesByTopic (Request $request)
    {
//        abort_if(Gate::denies('manage-batch-exam-section-content'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        foreach ($request->question_topic_ids as $question_topic_id)
        {
            $this->questionTopic = QuestionTopic::whereId($question_topic_id)->select('id', 'question_topic_id', 'name')->with(['questionStores' => function($questions) use($request){
                $questions->whereQuestionType($request->exam_type == 'exam' ? 'MCQ' : 'Written')->whereStatus(1)->select('id', 'question_type', 'question')->get();
            }])->first();
            array_push($this->questionTopics, $this->questionTopic);
        }
//        return response()->json($this->questionTopics);
        return view('backend.batch-exam-management.section-contents.include-questions', [
            'questionTopics'    => $this->questionTopics,
        ]);
    }

    public function assignQuestionToContent (Request $request)
    {
        abort_if(Gate::denies('assign-question-to-batch-exam-section-content'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->sectionContent = BatchExamSectionContent::find($request->section_content_id);
        $this->sectionContent->questionStores()->attach($request->question_ids);
        return back()->with('success', 'Questions Added to this exam successfully.');
    }
}
