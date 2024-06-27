<?php

namespace App\Http\Controllers\Backend\CourseManagement\Question;

use App\Http\Controllers\Controller;
use App\Models\Backend\QuestionManagement\QuestionTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use function Symfony\Component\HttpFoundation\Session\Storage\save;

class QuestionTopicController extends Controller
{
    //    permission seed done
    protected $questionTopic, $questionTopics = [];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('manage-question-topic'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (isset($_GET['topic_id']))
        {
            $this->questionTopics = QuestionTopic::where('question_topic_id', $_GET['topic_id'])->whereType($_GET['q-type'])->get();
        } else {
            $this->questionTopics = QuestionTopic::where('question_topic_id', 0)->whereType($_GET['q-type'])->get();
        }
        return view('backend.question-management.question-topics.index', [
            'questionTopics'    => $this->questionTopics,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-question-topic'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('store-question-topic'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate(['name' => 'required']);
        QuestionTopic::createOrUpdateQuestionTopic($request);
        return back()->with('success', 'Question Topic Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-question-topic'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-question-topic'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return response()->json(QuestionTopic::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-question-topic'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        QuestionTopic::createOrUpdateQuestionTopic($request, $id);
        if ($request->ajax())
        {
            return response()->json('Question Topic Updated Successfully.');
        }
        return back()->with('success', 'Question Topic Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-question-topic'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->deleteNestedQuestionTopic(QuestionTopic::find($id));
        return back()->with('success', 'Question Topic deleted Successfully.');
    }

    protected function deleteNestedQuestionTopic ($questionTopic)
    {
//        if (file_exists($questionTopic->image))
//        {
//            unlink($questionTopic->image);
//        }
//        if (file_exists($questionTopic->icon))
//        {
//            unlink($questionTopic->icon);
//        }
        if (!empty($questionTopic->courseCategories))
        {
            foreach ($questionTopic->questionTopics as $subCategory)
            {
                $this->deleteNestedQuestionTopic($subCategory);
            }
        }
        $questionTopic->delete();
    }
}
