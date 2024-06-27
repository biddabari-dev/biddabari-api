<?php

namespace App\Models\Backend\ExamManagement;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamCategory extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'exam_category_id',
        'name',
        'icon_class_code',
        'icon',
        'image',
        'description',
        'has_free_xm',
        'status',
        'order',
        'price',
        'open_for_sale',
        'slug',
        'valid_from',
        'valid_to',
        'xm_subscription_duration',
        'is_master_exam',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'exam_categories';

    public static function createOrUpdateExamCategory($request, $id = null)
    {
        ExamCategory::updateOrCreate(['id' => $id], [
            'name'                      => $request->name,
            'exam_category_id'          => isset($request->exam_category_id) ? $request->exam_category_id :  0,
            'description'               => $request->description,
            'price'                     => $request->price,
            'icon_class_code'           => $request->icon_class_code,
            'valid_from'                => $request->valid_from,
            'valid_to'                  => $request->valid_to,
            'xm_subscription_duration'  => $request->xm_subscription_duration,
            'icon'                      => isset($id) ? imageUpload($request->file('icon'), 'course/course-icons/', 'course-category', '40', '40', static::find($id)->icon) : imageUpload($request->file('icon'), 'course/course-icons/', 'course-category', '40', '40'),
            'image'                     => isset($id) ? imageUpload($request->file('image'), 'course/course-images/', 'course-category', '300', '300', static::find($id)->image) : imageUpload($request->file('image'), 'course/course-images/', 'course-category', '300', '300'),
            'slug'                      => str_replace(' ', '-', $request->name),
            'order'                     => isset($id) ? static::find($id)->order : 1,
            'has_free_xm'               => $request->has_free_xm == 'on' ? 1 : 0,
            'open_for_sale'             => $request->open_for_sale == 'on' ? 1 : 0,
            'status'                    => $request->status == 'on' ? 1 : 0,
            'is_master_exam'                    => $request->is_master_exam == 'on' ? 1 : 0,
        ]);

//        if (isset($id))
//        {
//            self::$courseCategory = CourseCategory::find($id);
//        } else {
//            self::$courseCategory = new CourseCategory();
//        }
//        self::$courseCategory->name        = $request->name;
//        self::$courseCategory->parent_id   = 0;
//        self::$courseCategory->note        = $request->note;
//        self::$courseCategory->icon        = isset($id) ? imageUpload($request->file('icon'), 'course/course-icons/', 'course-category', '40', '40', CourseCategory::find($id)->icon) : imageUpload($request->file('icon'), 'course/course-icons/', 'course-category', '40', '40');
//        self::$courseCategory->image       = isset($id) ? imageUpload($request->file('image'), 'course/course-images/', 'course-category', '300', '300', CourseCategory::find($id)->image) : imageUpload($request->file('image'), 'course/course-images/', 'course-category', '300', '300');
//        self::$courseCategory->slug        = str_replace(' ', '-', $request->name);
//        self::$courseCategory->order       = isset($id) ? CourseCategory::find($id)->order : 1;
//        self::$courseCategory->is_featured        = $request->is_featured == 'on' ? 1 : 0;
//        self::$courseCategory->status        = $request->status == 'on' ? 1 : 0;
//        self::$courseCategory->save();
    }

    public function examCategory()
    {
        return $this->belongsTo(ExamCategory::class);
    }

    public function examCategories()
    {
        return $this->hasMany(ExamCategory::class);
    }

    public function customExamCategories()
    {
        return $this->examCategories()->with('customExamCategories:id,exam_category_id,name,price')->with('exams:id,title,exam_category_id,xm_type,xm_date,price');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function examOrders()
    {
        return $this->hasMany(ExamOrder::class);
    }
}
