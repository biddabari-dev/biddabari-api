<?php

namespace App\Models\Backend\Course;

use App\Models\Backend\Course\CourseSectionContent;
use App\Models\Scopes\Searchable;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseExamResult extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'course_section_content_id',
        'user_id',
        'xm_type',
        'written_xm_file',
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

    protected $table = 'course_exam_results';

    protected static $xmResult;

    public static function storeExamResult($arrayData, $examResultId = null)
    {
        return CourseExamResult::updateOrCreate(['id' => $examResultId], $arrayData);
    }

    public static function updateXmResult($request, $examOf)
    {
        self::$xmResult                     = CourseExamResult::find($request->xm_result_id);
        if ($request->hasFile('written_xm_file'))
        {
            if (file_exists(self::$xmResult->written_xm_file))
            {
                unlink(self::$xmResult->written_xm_file);
            }
        }
        self::$xmResult->result_mark        = $request->result_mark;
        self::$xmResult->written_xm_file    = $request->hasFile('written_xm_file') ? fileUpload($request->file('written_xm_file'), 'written-xm-ans-files', '') : static::find($request->xm_result_id)->written_xm_file;
        self::$xmResult->status             = !empty($request->result_mark) ? (self::$xmResult->courseSectionContent->xm_pass_mark >= $request->result_mark ? 'fail' : 'pass') : 'pending';
        self::$xmResult->save();
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
