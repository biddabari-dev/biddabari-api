<?php

namespace App\Models\Backend\UpdateContent;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GuidelineContent extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'content_type',
        'title',
        'slug',
        'description',
        'file',
        'status',
    ];
    protected $hidden = ['created_at', 'updated_at'];

    protected $searchableFields = ['*'];

    protected static $daily_update;

    public static function createOrUpdate($request, $id = null)
    {
        if ($id)
        {
            self::$daily_update = GuidelineContent::find($id);
        }else{
            self::$daily_update = new GuidelineContent();
        }
        self::$daily_update->content_type = $request->content_type ? $request->content_type : self::$daily_update->content_type;
        self::$daily_update->title = $request->title;
        self::$daily_update->description = $request->description;
        if ($request->hasFile('file')) {
            self::$daily_update->file = fileUpload($request->file('file'), 'updatecontent/', 'daily-update', $id ? self::$daily_update->file : null);
        } elseif ($request->content_type === 'video') {
            self::$daily_update->file = $request->file;
        }
        self::$daily_update->file = $request->file('file') ? fileUpload($request->file('file'), 'updatecontent/', 'daily-update', (isset($id) ? GuidelineContent::find($id)->file : null) ) : $request->file;
        self::$daily_update->slug = str_replace(' ', '-', $request->title);
        self::$daily_update->status = $request->status == 'on' ? 1 : 0;
        self::$daily_update->save();
    }

}
