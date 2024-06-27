<?php

namespace App\Models\Backend\AdditionalFeatureManagement\NumberCounter;

use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumberCounter extends Model
{
    protected static $numberCounter;
    use HasFactory;
//    use Searchable;

    protected $fillable = [
        'label',
        'icon_code',
        'total_number',
        'image',
        'status',
    ];

//    protected $searchableFields = ['*'];

    protected $table = 'number_counters';

    public static function updateOrCreateNumberCounter($request, $id = null)
    {
        static::updateOrCreate(['id' => $id],[
            'label'             => $request->label,
            'icon_code'         => $request->icon_code,
            'total_number'      => $request->total_number,
            'image'             => fileUpload($request->file('image'),'additional-feature-management/number-counter','number-counter', isset($id) ? static::find($id)->image : ''),
            'status'            => $request->status == 'on' ? 1 : 0,
        ]);
    }

    public static function deleteNumberCounter($id)
    {
        self::$numberCounter = NumberCounter::find($id);
        if (file_exists(self::$numberCounter->image))
        {
            unlink(self::$numberCounter->image);
        }
        self::$numberCounter->delete();
    }
}
