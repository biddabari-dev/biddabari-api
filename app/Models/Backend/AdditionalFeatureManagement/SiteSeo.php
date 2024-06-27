<?php

namespace App\Models\Backend\AdditionalFeatureManagement;

use App\Models\Backend\BatchExamManagement\BatchExam;
use App\Models\Backend\BatchExamManagement\BatchExamCategory;
use App\Models\Backend\BlogManagement\Blog;
use App\Models\Backend\BlogManagement\BlogCategory;
use App\Models\Backend\Course\Course;
use App\Models\Backend\Course\CourseCategory;
use App\Models\Backend\ProductManagement\Product;
use App\Models\Backend\ProductManagement\ProductCategory;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteSeo extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'model_type',
        'parent_model_id',
        'header_code',
        'footer_code',
        'status',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'site_seos';

    public function course()
    {
        return $this->belongsTo(Course::class, 'parent_model_id');
//        return $this->belongsTo(Course::class, 'parent_model_id')->where('model_type', 'course');
    }

    public function batchExam()
    {
        return $this->belongsTo(BatchExam::class, 'parent_model_id');
//        return $this->belongsTo(BatchExam::class, 'parent_model_id')->where('model_type', 'batch_exam');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'parent_model_id');
//        return $this->belongsTo(Product::class, 'parent_model_id')->where('model_type', 'product');
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class, 'parent_model_id');
//        return $this->belongsTo(Blog::class, 'parent_model_id')->where('model_type', 'blog');
    }

    public function courseCategory()
    {
        return $this->belongsTo(CourseCategory::class, 'parent_model_id');
//        return $this->belongsTo(CourseCategory::class, 'parent_model_id')->where('model_type', 'course_category');
    }

    public function batchExamCategory()
    {
        return $this->belongsTo(BatchExamCategory::class, 'parent_model_id');
//        return $this->belongsTo(BatchExamCategory::class, 'parent_model_id')->where('model_type', 'batch_exam_category');
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_model_id');
//        return $this->belongsTo(ProductCategory::class, 'parent_model_id')->where('model_type', 'product_category');
    }

    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class, 'parent_model_id');
//        return $this->belongsTo(BlogCategory::class, 'parent_model_id')->where('model_type', 'blog_category');
    }
}
