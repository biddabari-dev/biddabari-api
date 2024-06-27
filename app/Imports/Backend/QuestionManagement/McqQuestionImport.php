<?php

namespace App\Imports\Backend\QuestionManagement;

use App\Models\Backend\QuestionManagement\QuestionStore;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class McqQuestionImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new QuestionStore([
            'question'                      => $row['question'],
            'question_description'          => $row['question_description'],
//            'question_video_link'           => $row['question_video_link'],
//            'question_mark'                 => $row['question_mark'],
//            'negative_mark'                 => $row['negative_mark'],
            'has_all_wrong_ans'             => $row['has_all_wrong_ans'],
            'option_one'                    => $row['option_one'],
            'option_two'                    => $row['option_two'],
            'option_three'                  => $row['option_three'],
            'option_four'                   => $row['option_four'],
            'option_five'                   => $row['option_five'],
            'correct_answer'                => $row['correct_answer'],
            'option_description'            => $row['option_description'],
        ]);
    }
}
