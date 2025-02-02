<?php

namespace App\Models;

use App\Models\Backend\BatchExamManagement\BatchExamSectionContent;
use App\Models\Backend\Course\CourseSectionContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentSeen extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'content_id', 'content_type'];

    // Relationship: ContentSeen belongs to CourseSectionContent
    public function courseSectionContent()
    {
        return $this->belongsTo(CourseSectionContent::class, 'content_id');
    }

    public function batchExamSectionContent()
    {
        return $this->belongsTo(BatchExamSectionContent::class, 'content_id');
    }

    // Relationship: ContentSeen belongs to User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

