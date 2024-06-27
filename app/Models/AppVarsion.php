<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppVarsion extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'varsion',
        'url',
        'status',

    ];

    protected $searchableFields = ['*'];

//    protected $table = 'service_complains';

    public static function createorupdatappvarsion($request, $id = null)
    {
        AppVarsion::updateOrCreate(['id' => $id], [
            'varsion'          => $request->varsion,
            'url'          => $request->url,
            'status'          => isset($request->status) ? 1 : 0,
        ]);

    }
}
