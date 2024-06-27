<?php

namespace App\Models\Backend\ModelTestManagement;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelTest extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'model_test_category_id',
        'title',
        'image',
        'slug',
        'status',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'model_tests';

    protected static $modelTest;

    public static function createOrUpdateModelTest($request, $id = null)
    {
        if ($id)
        {
            self::$modelTest = ModelTest::find($id);
        }else{
            self::$modelTest = new ModelTest();
        }
        self::$modelTest->model_test_category_id    = $request->model_test_category_id;
        self::$modelTest->title                     = $request->title;
        self::$modelTest->image                     = isset($id) ? imageUpload($request->file('image'), 'model-test-management/model-tests/', 'model-test-', '', '', ModelTest::find($id)->image) : imageUpload($request->file('image'), 'model-test-management/model-tests/', 'model-test-', '', '');
        self::$modelTest->slug                      = str_replace(' ', '-', $request->title);
        self::$modelTest->status                    = $request->status == 'on' ? 1 : 0;
        self::$modelTest->save();
    }

    public function modelTestCategory()
    {
        return $this->belongsTo(ModelTestCategory::class);
    }

    public function modelTestContents()
    {
        return $this->hasMany(ModelTestContent::class);
    }
}
