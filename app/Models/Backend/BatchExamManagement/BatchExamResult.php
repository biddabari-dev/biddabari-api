<?php

namespace App\Models\Backend\BatchExamManagement;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class BatchExamResult extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'batch_exam_section_content_id',
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

    protected $table = 'batch_exam_results';

    protected static $xmResult;

    public static function storeExamResult($arrayData, $examResultId = null)
    {
        return BatchExamResult::updateOrCreate(['id' => $examResultId], $arrayData);
    }

    public static function updateXmResult($request, $examOf)
    {
        self::$xmResult                     = BatchExamResult::find($request->xm_result_id);
        if ($request->hasFile('written_xm_file'))
        {
            if (file_exists(self::$xmResult->written_xm_file))
            {
                unlink(self::$xmResult->written_xm_file);
            }
        }
        self::$xmResult->result_mark        = $request->result_mark;
        self::$xmResult->written_xm_file    = $request->hasFile('written_xm_file') ? fileUpload($request->file('written_xm_file'), 'written-xm-ans-files', '') : static::find($request->xm_result_id)->written_xm_file;
        self::$xmResult->status             = !empty($request->result_mark) ? (self::$xmResult->batchExamSectionContent->xm_pass_mark >= $request->result_mark ? 'fail' : 'pass') : 'pending';
        self::$xmResult->save();
    }

    public function batchExamSectionContent()
    {
        return $this->belongsTo(BatchExamSectionContent::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
