<?php

namespace App\Models\Backend\AdditionalFeatureManagement;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PopupNotification extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'popup_type',
        'image',
        'action_btn_text',
        'active_btn_link',
        'description',
        'slug',
        'status',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'popup_notifications';

    protected static $popupNotification;

    public static function saveOrUpdatePopupNotification ($request, $id = null)
    {
        PopupNotification::updateOrCreate(['id' => $id], [
            'title'                 => $request->title,
            'popup_type'            => $request->popup_type,
            'action_btn_text'       => $request->action_btn_text,
            'active_btn_link'       => $request->active_btn_link,
            'description'           => $request->description,
            'slug'                  => str_replace(' ', '-', $request->title),
            'image'                 => imageUpload($request->file('image'), 'additional-features-management/popup-notifications/', 'pop-noti', '400', '400', (isset($id) ? PopupNotification::find($id)->image : null)),
            'status'                => $request->status == 'on' ? 1 : 0
        ]);
    }
}
