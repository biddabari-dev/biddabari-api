<?php

namespace App\Http\Controllers\Backend\BatchExamManagement;

use App\Http\Controllers\Controller;
use App\Models\Backend\BatchExamManagement\BatchExamRoutine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class BatchExamRoutineController extends Controller
{
    //    permission seed done
    protected $batchExamRoutines = [];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('manage-batch-exam-routine'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (!empty(request()->input('batch_exam_id')))
        {
            return view('backend.batch-exam-management.batch-exam-routines.index', [
                'batchExamRoutines'   => BatchExamRoutine::where('batch_exam_id', request()->input('batch_exam_id'))->get(),
            ]);
        }
        return 'Please select a Batch Exam to get Batch Exam Routine';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-batch-exam-routine'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('store-batch-exam-routine'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate(['date_time' => 'required','day' => 'required']);
        BatchExamRoutine::createOrUpdateCourseRoutines($request);
        return back()->with('success', 'Batch Exam Routine Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-batch-exam-routine'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-batch-exam-routine'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.batch-exam-management.batch-exam-routines.edit', [
            'batchExamRoutine'   => BatchExamRoutine::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-batch-exam-routine'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        BatchExamRoutine::createOrUpdateCourseRoutines($request, $id);
        return back()->with('success', 'Batch Exam Routine Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-batch-exam-routine'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        BatchExamRoutine::find($id)->delete();
        return back()->with('success', 'Batch Exam Routine deleted Successfully');
    }
}
