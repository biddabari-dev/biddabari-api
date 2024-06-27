<?php

namespace App\Http\Controllers\Backend\BatchExamManagement;

use App\helper\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\BatchExamManagement\BatchExamSection;
use App\Models\Backend\BatchExamManagement\BatchExamSectionContent;
use App\Models\Backend\Course\CourseSection;
use App\Models\Backend\Course\CourseSectionContent;
use App\Models\Backend\PdfManagement\PdfStoreCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class BatchExamSectionController extends Controller
{
    //    permission seed done
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('manage-batch-exam-section'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.batch-exam-management.batch-exam-sections.index', [
            'batchExamSections'   => BatchExamSection::whereBatchExamId(\request()->input('batch_exam_id'))->orderBy('order', 'ASC')->get(),
            'pdfStoreCategories'   => PdfStoreCategory::whereStatus(1)->where('parent_id', 0)->select('id', 'title')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-batch-exam-section'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('store-batch-exam-section'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate(['title' => 'required', 'available_at' => 'required',]);
        BatchExamSection::createOrUpdateCourseSection($request);
        return back()->with('success', 'Batch Exam Section Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-batch-exam-section'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-batch-exam-section'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return response()->json(BatchExamSection::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-batch-exam-section'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate(['title' => 'required', 'available_at' => 'required',]);
        BatchExamSection::createOrUpdateCourseSection($request, $id);
        return back()->with('success', 'Batch Exam Section Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        abort_if(Gate::denies('delete-batch-exam-section'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $batchExamSection = BatchExamSection::find($id);
        $batchExamId = $batchExamSection->batch_exam_id;
        $batchExamSection->delete();
        ViewHelper::reorderSerials('batch_exam_section', $batchExamId);
        return back()->with('success', 'Batch Exam Section deleted Successfully.');
    }

    public function changeOrderNumber($modelName = null, $modelId = null, $order = null )
    {
        if ($modelName == 'course_section')
        {
            $courseSection = CourseSection::find($modelId);
            if ($order == 'up')
            {
                if ($courseSection->order != 1)
                {
                    $previousOrderNumber = $courseSection->order-1;
                    $currentPosition = $courseSection->order;
                    $lastCourseSection = CourseSection::where(['order' => $previousOrderNumber, 'course_id' => $courseSection->course_id])->first();
                    $courseSection->order = $previousOrderNumber;
                    $courseSection->save();
                    $lastCourseSection->order   = $currentPosition;
                    $lastCourseSection->save();
                } else {
                    return back()->with('error', 'This item is already in top.');
                }
            } elseif ($order == 'down')
            {
                $nextCourseSection = CourseSection::where(['order' => $courseSection->order + 1, 'course_id' => $courseSection->course_id])->first();
                if (isset($nextCourseSection))
                {
                    $nextOrderNumber = $courseSection->order+1;
                    $currentPosition = $courseSection->order;
                    $courseSection->order = $nextOrderNumber;
                    $nextCourseSection->order = $currentPosition;
                    $nextCourseSection->save();
                    $courseSection->save();
                } else {
                    return back()->with('error', 'This is already at bottom.');
                }
            }
            $courseSection->save();
            return back()->with('success', 'Order Changed Successfully.');
        } elseif ($modelName == 'batch_exam_section')
        {
            $section = BatchExamSection::find($modelId);
            if ($order == 'up')
            {
                if ($section->order != 1)
                {
                    $previousOrderNumber = $section->order-1;
                    $currentPosition = $section->order;
                    $lastSection = BatchExamSection::where(['order' => $previousOrderNumber, 'batch_exam_id' => $section->batch_exam_id])->first();
                    $section->order = $previousOrderNumber;
                    $section->save();
                    $lastSection->order   = $currentPosition;
                    $lastSection->save();
                } else {
                    return back()->with('error', 'This item is already at top.');
                }
            } elseif ($order == 'down')
            {
                $nextSection = BatchExamSection::where(['order' => $section->order + 1, 'batch_exam_id' => $section->batch_exam_id])->first();
                if (isset($nextSection))
                {
                    $nextOrderNumber = $section->order+1;
                    $currentPosition = $section->order;
                    $section->order = $nextOrderNumber;
                    $section->save();
                    $nextSection->order = $currentPosition;
                    $nextSection->save();
                } else {
                    return back()->with('error', 'This is already at bottom.');
                }
            }
            $section->save();
            return back()->with('success', 'Order Changed Successfully.');
        } elseif ($modelName == 'course_section_content')
        {
            $sectionContent = CourseSectionContent::find($modelId);
            if ($order == 'up')
            {
                if ($sectionContent->order != 1)
                {
                    $previousOrderNumber = $sectionContent->order-1;
                    $currentPosition = $sectionContent->order;
                    $lastSectionContent = CourseSectionContent::where(['order' => $previousOrderNumber, 'course_section_id' => $sectionContent->course_section_id])->first();
                    $sectionContent->order = $previousOrderNumber;
                    $sectionContent->save();
                    $lastSectionContent->order   = $currentPosition;
                    $lastSectionContent->save();
                } else {
                    return back()->with('error', 'This item is already in top.');
                }
            } elseif ($order == 'down')
            {
                $nextSectionContent = CourseSectionContent::where(['order' => $sectionContent->order + 1, 'course_section_id' => $sectionContent->course_section_id])->first();
                if (isset($nextSectionContent))
                {
                    $nextOrderNumber = $sectionContent->order+1;
                    $currentPosition = $sectionContent->order;
                    $sectionContent->order = $nextOrderNumber;
                    $sectionContent->save();
                    $nextSectionContent->order = $currentPosition;
                    $nextSectionContent->save();
                } else {
                    return back()->with('error', 'This is already at bottom.');
                }
            }
            $sectionContent->save();
            return back()->with('success', 'Order Changed Successfully.');
        } elseif ($modelName == 'batch_exam_section_content')
        {
            $sectionContent = BatchExamSectionContent::find($modelId);
            if ($order == 'up')
            {
                if ($sectionContent->order != 1)
                {
                    $previousOrderNumber = $sectionContent->order-1;
                    $currentPosition = $sectionContent->order;
                    $lastSectionContent = BatchExamSectionContent::where(['order' => $previousOrderNumber, 'batch_exam_section_id' => $sectionContent->batch_exam_section_id])->first();
                    $sectionContent->order = $previousOrderNumber;
                    $sectionContent->save();
                    $lastSectionContent->order   = $currentPosition;
                    $lastSectionContent->save();
                } else {
                    return back()->with('error', 'This item is already in top.');
                }
            } elseif ($order == 'down')
            {
                $nextSectionContent = BatchExamSectionContent::where(['order' => $sectionContent->order + 1, 'batch_exam_section_id' => $sectionContent->batch_exam_section_id])->first();
                if (isset($nextSectionContent))
                {
                    $nextOrderNumber = $sectionContent->order+1;
                    $currentPosition = $sectionContent->order;
                    $sectionContent->order = $nextOrderNumber;
                    $sectionContent->save();
                    $nextSectionContent->order = $currentPosition;
                    $nextSectionContent->save();
                } else {
                    return back()->with('error', 'This is already at bottom.');
                }
            }
//            $sectionContent->save();
            return back()->with('success', 'Order Changed Successfully.');
        }
        return back()->with('error', 'Something went wrong buddy. Please try again.');
    }
}
