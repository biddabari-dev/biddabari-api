<?php

namespace App\Models\Backend\ExamManagement;

use App\Models\Scopes\Searchable;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamOrder extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'exam_category_id',
        'user_id',
        'order_invoice_number',
        'payment_method',
        'vendor',
        'paid_to',
        'paid_form',
        'txt_id',
        'paid_amount',
        'total_amount',
        'status',
        'contact_status',
        'xm_order_checked_by',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'exam_orders';

    protected static $xmOrder;

    public static function storeXmOrderInfo($request, $id)
    {
        ExamOrder::updateOrCreate(['id' => $id], [
            'exam_category_id'   => $id,
            'user_id'   => auth()->id(),
            'order_invoice_number'  => self::generateOrderNumber(),
            'payment_method'    => $request->payment_method,
            'vendor'    => $request->vendor,
            'paid_to'   => $request->paid_to,
            'paid_form' => $request->paid_form,
            'txt_id'    => $request->txt_id,
//            'paid_amount'   => $request->paid_amount,
            'total_amount'  => $request->total_amount,
        ]);
    }

    public static function generateOrderNumber ()
    {
        $number = rand(100000, 999999);
        $existNumber = ExamOrder::where('order_invoice_number', $number)->first();
        if (!empty($existNumber) && count($existNumber) > 0)
        {
            self::generateOrderNumber();
        }
        return $number;
    }

    public static function updateExamOrderStatus($request, $id)
    {
        self::$xmOrder = ExamOrder::find($id);
//        self::$xmOrder->checked_by  = auth()->id();
        if ($request->payment_status == 'complete')
        {
            self::$xmOrder->paid_amount  = self::$xmOrder->exam->price;
        } else {
            self::$xmOrder->paid_amount  = !empty($request->paid_amount) ? $request->paid_amount : self::$xmOrder->paid_amount;
        }
//        self::$xmOrder->payment_status  = $request->payment_status;
//        self::$xmOrder->contact_status  = $request->contact_status;
        self::$xmOrder->status  = $request->status;
        self::$xmOrder->save();
    }

    public function examCategory()
    {
        return $this->belongsTo(ExamCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function examOrderCheckedBy()
    {
        return $this->belongsTo(User::class, 'xm_order_checked_by');
    }
}
