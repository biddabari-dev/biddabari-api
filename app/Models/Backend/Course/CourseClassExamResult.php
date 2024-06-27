<?php

namespace App\Models\Backend\Course;

use App\Models\Backend\ExamManagement\ExamResult;
use App\Models\Scopes\Searchable;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseClassExamResult extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'course_section_content_id',
        'user_id',
        'provided_ans',
        'total_right_ans',
        'total_wrong_ans',
        'total_provided_ans',
        'result_mark',
        'is_reviewed',
        'required_time',
        'status',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'course_class_exam_results';

    public static function storeExamResult($arrayData, $examResultId = null)
    {
        return CourseClassExamResult::updateOrCreate(['id' => $examResultId], $arrayData);
    }

    public function courseSectionContent()
    {
        return $this->belongsTo(CourseSectionContent::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
