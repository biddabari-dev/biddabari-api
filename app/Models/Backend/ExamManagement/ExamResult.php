<?php

namespace App\Models\Backend\ExamManagement;

use App\Models\Backend\BatchExamManagement\BatchExam;
use App\Models\Backend\BatchExamManagement\BatchExamSectionContent;
use App\Models\Scopes\Searchable;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamResult extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'exam_id',
        'user_id',
        'xm_type',
        'written_xm_file',
        'provided_ans',
        'result_mark',
        'is_reviewed',
        'status',
        'required_time',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'exam_results';

    protected static $xmResult;

    public static function storeExamResult($arrayData, $examResultId = null)
    {
        return ExamResult::updateOrCreate(['id' => $examResultId], $arrayData);
    }

    public static function updateXmResult($request)
    {
        self::$xmResult                     = ExamResult::find($request->xm_result_id);
        if ($request->hasFile('written_xm_file'))
        {
            if (file_exists(self::$xmResult->written_xm_file))
            {
                unlink(self::$xmResult->written_xm_file);
            }
        }
        self::$xmResult->result_mark        = $request->result_mark;
        self::$xmResult->written_xm_file    = $request->hasFile('written_xm_file') ? fileUpload($request->file('written_xm_file'), 'written-xm-ans-files', '') : static::find($request->xm_result_id)->written_xm_file;
        self::$xmResult->status             = !empty($request->result_mark) ? (self::$xmResult->exam->xm_pass_mark >= $request->result_mark ? 'fail' : 'pass') : 'pending';
        self::$xmResult->save();
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function batchExamSectionContent()
    {
        return $this->belongsTo(BatchExamSectionContent::class);
    }
}
