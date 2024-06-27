<?php

namespace App\Models\Backend\AdditionalFeatureManagement\StudentOpinion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentOpinion extends Model
{
    use HasFactory;
//    use Searchable;

    protected $fillable = ['show_type', 'name', 'image', 'comment', 'status'];

//    protected $searchableFields = ['*'];

    protected $table = 'student_opinions';
    protected static $opinions;


    public static function updateOrCreateStudentOpinion($request, $id = null)
    {
        static::updateOrCreate(['id' => $id],[
            'show_type'              => $request->show_type,
            'name'                   => $request->name,
            'image'                  => fileUpload($request->file('image'),'student-opinion/opinions','', isset($id) ? static::find($id)->image : '' ),
            'comment'                => $request->comment,
            'status'                 => $request->status == 'on' ? 1 : 0,
        ]);
    }

    public static function deleteStudentOpinion($id)
    {
        self::$opinions = StudentOpinion::find($id);
        if(file_exists(self::$opinions->image))
        {
            unlink(self::$opinions->image);
        }
        self::$opinions->delete();
    }
}
