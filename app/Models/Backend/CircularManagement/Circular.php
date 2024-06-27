<?php

namespace App\Models\Backend\CircularManagement;

use App\Models\Scopes\Searchable;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Circular extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'circular_category_id',
        'user_id',
        'post_title',
        'job_title',
        'vacancy',
        'image',
        'about',
        'description',
        'publish_date',
        'publish_date_timestamp',
        'expire_date',
        'expire_date_timestamp',
        'status',
        'slug',
        'is_featured',
        'order',
    ];

    protected $searchableFields = ['*'];

    protected static $circular;

    public static function saveOrUpdateCircular ($request, $id = null)
    {
        Circular::updateOrCreate(['id' => $id], [
            'circular_category_id'              => $request->circular_category_id,
            'user_id'                           => isset($id) ? static::find($id)->user_id : auth()->id(),
            'post_title'                        => $request->post_title,
            'job_title'                         => $request->job_title,
            'vacancy'                           => $request->vacancy,
            'about'                             => $request->about,
            'image'                             => imageUpload($request->file('image'), 'blog-management/blogs/', 'blog-', '300', '200', (isset($id) ? static::find($id)->image : null) ),
            'description'                       => $request->description,
            'publish_date'                      => $request->publish_date,
            'publish_date_timestamp'            => strtotime($request->publish_date),
            'expire_date'                       => $request->expire_date,
            'expire_date_timestamp'             => strtotime($request->expire_date),
            'slug'                              => str_replace(' ', '-', $request->post_title),
            'is_featured'                       => $request->is_featured == 'on' ? 1 : 0,
            'status'                            => $request->status == 'on' ? 1 : 0,
        ]);
    }

    public function circularCategory()
    {
        return $this->belongsTo(CircularCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
