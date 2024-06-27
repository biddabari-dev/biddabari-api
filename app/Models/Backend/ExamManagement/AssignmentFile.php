<?php

namespace App\Models\Backend\ExamManagement;

use App\Models\Backend\Course\CourseSectionContent;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignmentFile extends Model
{
    use HasFactory;
    use Searchable;
    protected $fillable = [
        'course_section_content_id',
        'user_id',
        'file',
        'file_type',
        'status',
    ];



    protected $searchableFields = ['*'];

    protected $table = 'assignment_files';

    protected static $assignmentFile;
    public static function updateAssesmentFile($request)
    {
        self::$assignmentFile                     = AssignmentFile::find($request->xm_result_id);
        if ($request->hasFile('written_xm_file'))
        {
            if (file_exists(self::$assignmentFile->file))
            {
                unlink(self::$assignmentFile->file);
            }
        }
        self::$assignmentFile->file    = $request->hasFile('written_xm_file') ? fileUpload($request->file('written_xm_file'), 'written-xm-ans-files', '') : static::find($request->xm_result_id)->file;
        self::$assignmentFile->status             = 1;
        self::$assignmentFile->save();
    }

    public function courseSectionContent()
    {
        return $this->belongsTo(CourseSectionContent::class);
    }
}
