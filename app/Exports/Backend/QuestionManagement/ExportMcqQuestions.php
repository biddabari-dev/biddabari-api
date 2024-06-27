<?php

namespace App\Exports\Backend\QuestionManagement;

use App\Models\Backend\QuestionManagement\QuestionStore;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportMcqQuestions implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $topicId , $type;

    public function __construct($topicId = null, $type = null)
    {
        $this->topicId = $topicId;
        $this->type = $type == 'mcq' ? 'MCQ' : 'Written';
    }

    public function collection()
    {
        return QuestionStore::where('question_type', $this->type)->get();
    }
}
