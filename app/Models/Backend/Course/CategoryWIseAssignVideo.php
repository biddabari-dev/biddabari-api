<?php

namespace App\Models\Backend\Course;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Backend\Course\CourseSectionContent;
use App\Models\Backend\BatchExamManagement\BatchExam;

class CategoryWIseAssignVideo extends Model
{
    use HasFactory;
    use Searchable;

    protected $guarded = [];

    protected $searchableFields = ['*'];

    protected $table = 'category_wise_assign_videos';

    // Define relationships
    public function categoryVideo()
    {
        return $this->belongsTo(CourseSectionContent::class, 'section_content_id', 'id');
    }
    public function categoryExam()
    {
        return $this->belongsTo(BatchExam::class, 'exam_id', 'id');
    }

    protected static function boot()
    {
        parent::boot(); // Call the parent boot method
    }
}

