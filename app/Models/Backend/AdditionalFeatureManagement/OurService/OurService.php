<?php

namespace App\Models\Backend\AdditionalFeatureManagement\OurService;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurService extends Model
{
    use HasFactory;
//    use Searchable;

    protected $fillable = ['icon_code', 'image', 'title', 'content', 'status'];
//    protected $searchableFields = ['*'];

    protected $table = 'our_services';
    protected static $service;


    public static function updateOrCreateService($request, $id = null)
    {
        static::updateOrCreate(['id' => $id],[
            'icon_code'              => $request->icon_code,
            'image'                  => fileUpload($request->file('image'),'our-services/services', 'service-', isset($id) ? static::find($id)->image : '' ),
            'title'                  => $request->title,
            'content'                => $request->content,
            'status'                 => $request->status == 'on' ? 1 : 0,
        ]);
    }

    public static function deleteService($id)
    {
        self::$service = OurService::find($id);
        if(file_exists(self::$service->image))
        {
            unlink(self::$service->image);
        }
        self::$service->delete();
    }
}



