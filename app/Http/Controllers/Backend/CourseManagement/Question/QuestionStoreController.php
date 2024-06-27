<?php

namespace App\Http\Controllers\Backend\CourseManagement\Question;

use App\Exports\Backend\QuestionManagement\ExportMcqQuestions;
use App\Http\Controllers\Controller;
use App\Imports\Backend\QuestionManagement\McqQuestionImport;
use App\Imports\Backend\QuestionManagement\WrittenQuestionImport;
use App\Imports\Backend\UsersImport;
use App\Models\Backend\QuestionManagement\FavouriteQuestion;
use App\Models\Backend\QuestionManagement\QuestionOption;
use App\Models\Backend\QuestionManagement\QuestionStore;
use App\Models\Backend\QuestionManagement\QuestionTopic;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;
use function Nette\Utils\getTypes;

class QuestionStoreController extends Controller
{
    //    permission seed done
    protected $questionStore, $questionStores = [], $questionTopic, $questions = [];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('manage-question-store'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (isset($_GET['topic_id']) && isset($_GET['q-type']))
        {
            $this->questionTopic = QuestionTopic::whereId($_GET['topic_id'])->select('id', 'name', 'type', 'status')->with(['questionStores' => function($questionStores){
                $questionStores->where('question_type', $_GET['q-type'] == 'mcq' ? 'MCQ' : 'Written')->orderBy('id', 'ASC')->get();
            }])->first();

            return view('backend.question-management.question-stores.index', [
                'questionTopic' => $this->questionTopic
            ]);
        }
        return back()->with('error', 'Topic and Type Not Found');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-question-store'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('store-question-store'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            foreach ($request->question as $key => $singleQuestion)
            {
                $this->questionStore = QuestionStore::createOrUpdateQuestion($request, $singleQuestion);
                if ($request->question_type == 'MCQ')
                {
                    foreach ($singleQuestion['answer'] as $answer)
                    {
                        if (isset($answer['option_title']))
                        {
                            QuestionOption::saveQuestionOptions($answer, $this->questionStore->id);
                        }
                    }
                }

            }
            return back()->with('success', 'Question Created Successfully.');
        } catch (\Exception $exception)
        {
            return back()->with('error', $exception->getMessage());
        }
    }
    public $answer;
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-question-store'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-question-store'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.question-management.question-stores.edit', [
            'questionStore'  => QuestionStore::find($id),
//            'questionTopics' => QuestionTopic::whereStatus(1)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-question-store'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//        return $request;
        try {
            foreach ($request->question as $key => $singleQuestion)
            {
                $this->questionStore = QuestionStore::createOrUpdateQuestion($request, $singleQuestion, $id);
                if ($request->question_type == 'MCQ')
                {
                    $this->questionStore->questionOptions->each->delete();
                    foreach ($singleQuestion['answer'] as $answer)
                    {
                        QuestionOption::saveQuestionOptions($answer, $this->questionStore->id);
                    }
                }

            }
            return back()->with('success', 'Question Updated Successfully.');
        } catch (\Exception $exception)
        {
            return back()->with('error', $exception->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-question-store'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        QuestionStore::find($id)->delete();
        return back()->with('success', 'Question deleted Successfully.');
    }

    protected $fileArray = [], $fileData = [], $questionStoreIds = [], $topic, $optionOne, $optionTwo, $optionThree, $optionFour, $optionFive;
    public function questionImport(Request $request, $topicId = null, $type = null)
    {
        $this->topic = QuestionTopic::find($topicId);
        try {
            if ($type == 'Written')
            {
                $this->fileArray = Excel::toArray(new WrittenQuestionImport(), $request->file('import_file'));
                foreach ($this->fileArray[0] as $item)
                {
                    if ($item['question'])
                    {
                        $questionStore = new QuestionStore();
                        $questionStore->created_by = auth()->id();
                        $questionStore->question_type = $type;
                        $questionStore->question = $item['question'];
                        $questionStore->question_description = $item['question_description'];
                        $questionStore->question_video_link = $item['question_video_link'];
//                    $questionStore->question_mark = $item['question_mark'];
                        $questionStore->written_que_ans = $item['written_que_ans'];
                        $questionStore->written_que_ans_description = $item['written_que_ans_description'];
                        $questionStore->status = 1;
                        $questionStore->save();
                        array_push($this->questionStoreIds, $questionStore->id);
                    }
                }
                $this->topic->questionStores()->attach($this->questionStoreIds);
                return back()->with('success', 'Questions imported successfully.');
            } elseif ($type == 'MCQ') {
                $this->fileArray = Excel::toArray(new McqQuestionImport(), $request->file('import_file'));
                foreach ($this->fileArray[0] as $item)
                {
                    if ($item['question'])
                    {
                        $this->optionOne    = $item['option_one'];
                        $this->optionTwo    = $item['option_two'];
                        $this->optionThree    = $item['option_three'];
                        $this->optionFour    = $item['option_four'];
                        $this->optionFive    = $item['option_five'];

                        $questionStore = new QuestionStore();
                        $questionStore->created_by = auth()->id();
                        $questionStore->question_type = $type;
                        $questionStore->question = $item['question'];
                        $questionStore->question_description = $item['question_description'];
//                    $questionStore->question_mark = $item['question_mark'];
//                    $questionStore->negative_mark = $item['negative_mark'];
                        $questionStore->has_all_wrong_ans = $item['has_all_wrong_ans'];
                        $questionStore->status      = 1;
                        $questionStore->save();
                        array_push($this->questionStoreIds, $questionStore->id);
                        $optionSingleString = "$this->optionOne$$$$this->optionTwo$$$$this->optionThree$$$$this->optionFour$$$$this->optionFive";
                        foreach (explode('$$$', $optionSingleString) as $option)
                        {
                            if ($option) {
                                $questionOption = new QuestionOption();
                                $questionOption->question_store_id  = $questionStore->id;
                                $questionOption->created_by  = auth()->id();
                                $questionOption->option_title  = $option;
                                $questionOption->option_description  = $item['option_description'];
                                $questionOption->is_correct = $option == $item['correct_answer'] ? 1 : 0;
                                $questionOption->save();
                            }
                        }
                    }
                }
                $this->topic->questionStores()->attach($this->questionStoreIds);
                return back()->with('success', 'Questions imported successfully.');
//            return $this->fileArray[0];
            }
        } catch (\Exception $exception)
        {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function questionExport($topicId = null, $type = null)
    {
        return Excel::download(new ExportMcqQuestions($topicId, $type), 'mcqQuestions.xlsx');
    }

    public function setFavouriteQuestion($userId, $questionId)
    {
        try {
            FavouriteQuestion::create([
                'user_id'   => $userId,
                'question_store_id'   => $questionId,
            ]);
            return \response()->json(['success' => 'Favourite Question Saved Successfully.']);
        } catch (\Exception $exception)
        {
            return \response()->json(['error' => $exception->getMessage()]);
        }
    }
    public function deleteFavouriteQuestion($userId, $questionId)
    {
        try {
            FavouriteQuestion::where([
                'user_id'   => $userId,
                'question_store_id'   => $questionId,
            ])->first()->delete();
            return \response()->json(['success' => 'Favourite Question deleted Successfully.']);
        } catch (\Exception $exception)
        {
            return \response()->json(['error' => $exception->getMessage()]);
        }
    }

    public function getFavouriteQuestions($userId)
    {
        $this->questionStores = FavouriteQuestion::where(['user_id' => $userId])->with(['questionStore' => function ($questionStore) {
            $questionStore->select('id', 'mcq_store_id', 'question_type', 'question', 'question_description', 'question_image', 'question_file_type', 'question_video_link', 'written_que_ans', 'written_que_ans_description', 'written_que_file', 'has_all_wrong_ans')->with('questionOptions')->get();
        }])->get();
        return \response()->json(['questions' => $this->questionStores]);
    }
}
