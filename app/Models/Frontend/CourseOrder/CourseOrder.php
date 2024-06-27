<?php

namespace App\Models\Frontend\CourseOrder;

use App\Models\Backend\Course\Course;
use App\Models\Scopes\Searchable;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseOrder extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'course_id',
        'user_id',
        'checked_by',
        'order_invoice_number',
        'payment_method',
        'vendor',
        'paid_to',
        'paid_from',
        'txt_id',
        'payment_status',
        'paid_amount',
        'total_amount',
        'coupon_code',
        'coupon_amount',
        'status',
        'contact_status',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'course_orders';

    protected static $courseOrder;

    public static function saveOrUpdateCourseOrder ($request, $id = null)
    {
        if (isset($id))
        {
            self::$courseOrder  = CourseOrder::find($id);
        } else {
            self::$courseOrder  = new CourseOrder();
        }
        self::$courseOrder->user_id   = auth()->id();
        self::$courseOrder->course_id   = $request->course_id;
        self::$courseOrder->order_invoice_number   = self::generateOrderNumber();
        self::$courseOrder->payment_method   = $request->payment_method;
        self::$courseOrder->vendor   = $request->vendor;
        self::$courseOrder->paid_to   = $request->paid_to;
        self::$courseOrder->paid_from   = $request->paid_from;
        self::$courseOrder->txt_id   = $request->txt_id;
        self::$courseOrder->paid_amount   = $request->paid_amount;
        self::$courseOrder->total_amount   = $request->total_amount;
        self::$courseOrder->coupon_code   = $request->coupon_code;
        self::$courseOrder->coupon_amount   = $request->coupon_amount;
//        if ($request->paid_amount == $request->total_amount)
//        {
//            self::$courseOrder->payment_status   = 'complete';
//        }
//        if (($request->paid_amount > 0) && ($request->paid_amount < $request->total_amount))
//        {
//            self::$courseOrder->payment_status   = 'partial';
//        }
        self::$courseOrder->payment_status   = 'pending';
        self::$courseOrder->contact_status   = 'pending';
        self::$courseOrder->status   = 0;
        self::$courseOrder->save();
    }

    public static function generateOrderNumber ()
    {
        $number = rand(100000, 999999);
        $existNumber = CourseOrder::where('order_invoice_number', $number)->first();
        if (!empty($existNumber) && count($existNumber) > 0)
        {
            self::generateOrderNumber();
        }
        return $number;
    }

    public static function updateCourseOrderStatus($request, $id)
    {
        self::$courseOrder = CourseOrder::find($id);
//        self::$courseOrder->checked_by  = auth()->id();
        if ($request->payment_status == 'complete')
        {
//            self::$courseOrder->paid_amount  = self::$courseOrder->course->price - ((self::$courseOrder->course->discount_type == 1 ? self::$courseOrder->course->discount_amount : (self::$courseOrder->course->discount_amount * self::$courseOrder->course->price)/100) > 0) ?? 0;
            self::$courseOrder->paid_amount  = self::$courseOrder->total_amount;
        } else {
            self::$courseOrder->paid_amount  = !empty($request->paid_amount) ? $request->paid_amount : self::$courseOrder->paid_amount;
        }
        self::$courseOrder->payment_status  = $request->payment_status;
//        self::$courseOrder->contact_status  = $request->contact_status;
        self::$courseOrder->status  = $request->status;
        self::$courseOrder->save();
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chckedBy()
    {
        return $this->belongsTo(User::class, 'checked_by');
    }
}
