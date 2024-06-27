<?php

namespace App\Models\Backend\AdditionalFeatureManagement\OurTeam;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurTeam extends Model
{
    protected static $ourTeam;
    use HasFactory;

    protected $fillable = [
        'name',
        'designation',
        'image',
        'content_show_type',
        'video_link',
        'video_file',
        'status',
    ];

    protected $table = 'our_teams';

    public static function updateOrCreateOurTeam($request, $id = null)
    {
        static::updateOrCreate(['id' => $id],[
            'name'                      => $request->name,
            'designation'               => $request->designation,
            'content_show_type'         => $request->content_show_type,
            'video_link'                => $request->video_link,
            'video_file'                => fileUpload($request->file('video_file'),'additional-feature-management/our-team/video', 'our-team-video', isset($id) ? static::find($id)->video_file : ''),
            'image'                     => fileUpload($request->file('image'),'additional-feature-management/our-team', 'our-team', isset($id) ? static::find($id)->image : ''),
            'status'                    => $request->status == 'on' ? 1 : 0,
        ]);
    }

    public static function deleteOurTeam($id)
    {
        self::$ourTeam = OurTeam::find($id);
        if(file_exists(self::$ourTeam->image))
        {
            unlink(self::$ourTeam->image);
        }
        self::$ourTeam->delete();
    }
}
