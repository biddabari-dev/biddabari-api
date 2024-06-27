<?php

namespace App\Models\Backend\AdditionalFeatureManagement\Affiliation;

use App\helper\ViewHelper;
use App\Models\Backend\BatchExamManagement\BatchExam;
use App\Models\Backend\Course\Course;
use App\Models\Backend\ProductManagement\Product;
use App\Models\Scopes\Searchable;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AffiliationHistory extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'model_type',
        'model_id',
        'affiliation_registration_id',
        'user_id',
        'amount',
        'affiliate_type',
        'status',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'affiliation_histories';

    protected static $affiliationHistories;

    public static function createNewHistory($request, $modelType = null, $modelId = null, $affiliate_amount = null, $affiliate_type = null)
    {
        AffiliationHistory::create([
            'model_type'    => $modelType,
            'model_id'    => $modelId,
            'affiliation_registration_id'    => AffiliationRegistration::where('affiliate_code', $request->rc)->first()->id,
            'user_id'   => ViewHelper::loggedUser()->id,
            'amount'    => $affiliate_amount,
            'affiliate_type'    => $affiliate_type,
            'status'    => 0
        ]);
    }

    public function affiliationRegistration()
    {
        return $this->belongsTo(AffiliationRegistration::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'model_id');
//        return $this->belongsTo(Course::class, 'model_id')->where('model_type', 'course');
    }

    public function batchExam()
    {
        return $this->belongsTo(BatchExam::class, 'model_id');
//        return $this->belongsTo(BatchExam::class, 'model_id')->where('model_type', 'batch_exam');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'model_id');
//        return $this->belongsTo(Product::class, 'model_id')->where('model_type', 'product');
    }
}
