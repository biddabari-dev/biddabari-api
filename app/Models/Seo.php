<?php

namespace App\Models;

use App\Http\Controllers\Backend\SEO\SeoController;
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

class Seo extends Model
{
//    use HasFactory;
    use Searchable;

    protected $fillable = [
        'seo_for',
        'parent_model_id',
        'custom_page_link',
        'slug',
        'meta_keywords',
        'meta_description',
        'meta_tags',
        'meta_image_description',
        'status',
    ];

    protected $searchableFields = ['*'];


    public static function saveOrUpdateProduct($request, $id = null){
        return Seo::updateOrCreate(['id' => $id], [
//            'product_category_id'   => $request->product_category_id,
            'seo_for'                   => $request->seo_for,
            'parent_model_id'           => $request->parent_model_id,
            'custom_page_link'          => $request->custom_page_link,
            'slug'                      => $request->slug,
            'meta_keywords'             => $request->meta_keywords,
            'meta_description'          => $request->meta_description,
            'meta_tags'                 => $request->meta_tags,
            'meta_image_description'    => $request->meta_image_description,
            'status'                    => $request->status == 'on' ? 1 : 0,
        ]);
    }
    public function course()
    {

        return $this->belongsTo(Course::class, 'parent_model_id');
    }

    public function courseCategory()
    {
        return $this->belongsTo(CourseCategory::class, 'parent_model_id');
    }

    public function batchExam()
    {
//        return $this->belongsTo(BatchExam::)
        return $this->belongsTo(BatchExam::class, 'parent_model_id');
    }

    public function batchExamCategory()
    {
//        return $this->belongsTo(BatchExamCategory::)
        return $this->belongsTo(BatchExamCategory::class, 'parent_model_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'parent_model_id');
    }

    public function productCategory()
    {
//        return $this->belongsTo(ProductCategory::)
        return $this->belongsTo(ProductCategory::class, 'parent_model_id');
    }

    public function blog()
    {
//        return $this->belongsTo(Blog::)
        return $this->belongsTo(Blog::class, 'parent_model_id');
    }

    public function blogCategory()
    {
//        return $this->belongsTo(BlogCategory::)
        return $this->belongsTo(BlogCategory::class, 'parent_model_id');
    }
}
