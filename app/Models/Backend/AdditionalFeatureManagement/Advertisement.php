<?php

namespace App\Models\Backend\AdditionalFeatureManagement;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Advertisement extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'content_type',
        'description',
        'link',
        'image',
        'slug',
        'status',
    ];

    protected $searchableFields = ['*'];

    protected static $advertisement;

    public static function createOrUpdateAdvertisement($request, $id = null)
    {
        if (isset($id))
        {
            self::$advertisement = Advertisement::find($id);
        }else{
            self::$advertisement = new Advertisement();
        }
        self::$advertisement->title = $request->title;
        self::$advertisement->content_type = $request->content_type;
        self::$advertisement->description = $request->description;
        self::$advertisement->link = $request->link;
        self::$advertisement->image = isset($id) ? imageUpload($request->file('image'), 'advertisement-management/advertisements/', 'advertisement-', '760', '440', Advertisement::find($id)->image) : imageUpload($request->file('image'), 'advertisement-management/advertisements/', 'advertisement-', '760', '440');
        self::$advertisement->slug = str_replace(' ', '-', $request->title);
        self::$advertisement->status = $request->status == 'on' ? 1 : 0;
        self::$advertisement->save();
    }
}
