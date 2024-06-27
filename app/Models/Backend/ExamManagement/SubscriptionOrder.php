<?php

namespace App\Models\Backend\ExamManagement;

use App\Models\Scopes\Searchable;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionOrder extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'exam_subscription_package_id',
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
    ];

    protected $searchableFields = ['*'];

    protected $table = 'subscription_orders';

    protected static $subscriptionOrder;

    public static function createSubscriptionOrder($request, $id = null)
    {
        SubscriptionOrder::create([
            'exam_subscription_package_id'      => $id,
            'user_id'                           => auth()->id(),
            'order_invoice_number'              => self::generateOrderNumber(),
            'payment_method'                    => $request->payment_method,
            'vendor'                            => $request->vendor,
            'paid_to'                           => $request->paid_to,
            'paid_form'                         => $request->paid_form,
            'txt_id'                            => $request->txt_id,
//            'paid_amount'                     => $request->paid_amount,
            'total_amount'                      => $request->total_amount,
            'status'                            => 0,
        ]);
    }

    public static function generateOrderNumber ()
    {
        $number = rand(100000, 999999);
        $existNumber = SubscriptionOrder::where('order_invoice_number', $number)->first();
        if (!empty($existNumber) && count($existNumber) > 0)
        {
            self::generateOrderNumber();
        }
        return $number;
    }

    public static function updateExamOrderStatus($request, $id)
    {
        self::$subscriptionOrder = SubscriptionOrder::find($id);
//        self::$xmOrder->checked_by  = auth()->id();
        if ($request->payment_status == 'complete')
        {
            self::$subscriptionOrder->paid_amount  = self::$subscriptionOrder->examSubscriptionPackage->price;
        } else {
            self::$subscriptionOrder->paid_amount  = !empty($request->paid_amount) ? $request->paid_amount : self::$subscriptionOrder->paid_amount;
        }
//        self::$xmOrder->payment_status  = $request->payment_status;
//        self::$xmOrder->contact_status  = $request->contact_status;
        self::$subscriptionOrder->status  = $request->status;
        self::$subscriptionOrder->save();
    }

    public function examSubscriptionPackage()
    {
        return $this->belongsTo(ExamSubscriptionPackage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
