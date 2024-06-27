<?php

namespace App\Models\Backend\NoticeManagement;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notice extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'notice_category_id',
        'title',
        'image',
        'type',
        'body',
        'slug',
        'status',
        'alt_text',
        'banner_title'
    ];

    protected $searchableFields = ['*'];

    protected static $notice;

    public static function createOrUpdateNotice($request, $id = null)
    {
        if ($id)
        {
            self::$notice = Notice::find($id);
        }else{
            self::$notice = new Notice();
        }
        self::$notice->notice_category_id = $request->notice_category_id;
        self::$notice->title = $request->title;
        self::$notice->type = $request->type;
        self::$notice->alt_text = $request->alt_text;
        self::$notice->banner_title = $request->banner_title;
        self::$notice->image = isset($id) ? imageUpload($request->file('image'), 'notice-management/notices/', 'notice-', '', '', Notice::find($id)->image) : imageUpload($request->file('image'), 'notice-management/notices/', 'notice-', '', '');
        self::$notice->body = $request->body;
        self::$notice->status = $request->status == 'on' ? 1 : 0;
        self::$notice->slug = str_replace(' ', '-', $request->title);
        self::$notice->save();
    }

    public function noticeCategory()
    {
        return $this->belongsTo(NoticeCategory::class);
    }
}
