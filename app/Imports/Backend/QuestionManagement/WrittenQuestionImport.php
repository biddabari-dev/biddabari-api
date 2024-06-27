<?php

namespace App\Imports\Backend\QuestionManagement;

use App\Models\Backend\QuestionManagement\QuestionStore;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WrittenQuestionImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new QuestionStore([
            'question'  => $row['question'],
            'question_description'  => $row['question_description'],
            'question_video_link'  => $row['question_video_link'],
//            'question_mark'  => $row['question_mark'],
            'written_que_ans'  => $row['written_que_ans'],
            'written_que_ans_description'  => $row['written_que_ans_description'],
        ]);
    }
}
