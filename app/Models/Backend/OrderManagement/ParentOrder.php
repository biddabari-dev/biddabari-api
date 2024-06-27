<?php

namespace App\Models\Backend\OrderManagement;

use App\helper\ViewHelper;
use App\Models\Backend\BatchExamManagement\BatchExam;
use App\Models\Backend\BatchExamManagement\BatchExamSubscription;
use App\Models\Backend\Course\Course;
use App\Models\Backend\ProductManagement\Product;
use App\Models\Backend\UserManagement\Student;
use App\Models\Scopes\Searchable;
use App\Models\User;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParentOrder extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'user_id',
        'parent_model_id',
        'checked_by',
        'batch_exam_subscription_id',
        'ordered_for',
        'order_invoice_number',
        'payment_method',
        'vendor',
        'paid_to',
        'paid_from',
        'txt_id',
        'paid_amount',
        'total_amount',
        'coupon_code',
        'coupon_amount',
        'status',
        'contact_status',
        'is_free_course',
        'bank_tran_id',
        'gateway_val_id',
        'gateway_status',
        'payment_status',
        'shipping_address',
        'notes',
        'delivery_charge',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'parent_orders';

    protected static $xmOrder;

    public static function storeXmOrderInfo($request, $id = null, $parentOrderId = null)
    {
        return ParentOrder::updateOrCreate(['id' => $parentOrderId], [
            'parent_model_id'           => $id,
            'user_id'                   => ViewHelper::loggedUser()->id,
            'order_invoice_number'      => self::generateOrderNumber(),
            'ordered_for'               => $request->ordered_for,
            'payment_method'            => $request->payment_method,
            'vendor'                    => $request->vendor,
            'paid_to'                   => $request->paid_to,
            'paid_from'                 => $request->paid_from,
            'txt_id'                    => $request->txt_id,
//            'paid_amount'   => $request->paid_amount,
            'total_amount'              => $request->total_amount,
            'coupon_code'               => $request->coupon_code,
            'coupon_amount'             => $request->coupon_amount,
            'batch_exam_subscription_id' => isset($request->batch_exam_subscription_id) ?? null,
        ]);
    }

    public static function createOrderAfterSsl($request)
    {
        return ParentOrder::create([
            'user_id'                   => ViewHelper::loggedUser()->id,
            'parent_model_id'           => $request->parent_model_id,
            'order_invoice_number'      => ParentOrder::generateOrderNumber(),
            'ordered_for'               => $request->ordered_for,
            'payment_method'            => $request->payment_method,
            'paid_amount'               => $request->total_amount,
            'total_amount'              => $request->total_amount,
            'coupon_code'               => $request->coupon_code,
            'coupon_amount'             => $request->coupon_amount,
            'bank_tran_id'              => $request->bank_tran_id,
            'gateway_val_id'            => $request->gateway_val_id,
            'gateway_status'            => $request->gateway_status,
            'status'                    => 'approved',
            'payment_status'            => 'complete',
            'batch_exam_subscription_id'=> isset($requestData->batch_exam_subscription_id) ?? null,

            'shipping_address'          => $request->ordered_for == 'product' ? $request->shipping_address : null,
            'notes'                     => $request->ordered_for == 'product' ? $request->shipping_address : null,
            'delivery_charge'           => $request->delivery_charge == 'product' ? $request->delivery_charge : 0,
        ]);
    }
    public static function placeOrderAfterGatewayPayment($request, $requestData , $parentOrderId = null)
    {
        return ParentOrder::updateOrCreate(['id' => $parentOrderId], [
            'parent_model_id'           => $requestData->model_id,
            'user_id'                   => ViewHelper::loggedUser()->id,
            'order_invoice_number'      => $request->tran_id ?? '000',
            'ordered_for'               => $requestData->ordered_for,
            'payment_method'            => $requestData->payment_method,
            'paid_amount'               => $request->amount,
            'total_amount'              => $requestData->total_amount ?? 0,
            'coupon_code'               => $requestData->coupon_code ?? null,
            'coupon_amount'             => $requestData->coupon_amount ?? null,
            'bank_tran_id'              => $requestData->payment_method == 'ssl' ? $request->bank_tran_id : ($requestData->payment_method == 'bkash' ? $request->trxID : ''),
//            'bank_tran_id'              => $request->bank_tran_id ,
            'gateway_val_id'            => $request->gateway_val_id ?? '',
            'gateway_status'            => $request->gateway_status ?? '',
            'status'                    => 'approved',
            'payment_status'            => 'complete',
            'batch_exam_subscription_id' => isset($requestData->batch_exam_subscription_id) ?? null,
        ]);
    }
    public static function assignNewStudentToModel($orderedForm, $request, $id = null)
    {
        ParentOrder::create([
            'parent_model_id'           => $id,
            'user_id'                   => Student::find($request->student_id)->user_id,
            'order_invoice_number'      => self::generateOrderNumber(),
            'ordered_for'               => $orderedForm,
            'payment_method'            => 'cod',
            'vendor'                    => $request->vendor,
            'paid_to'                   => $request->paid_to,
            'paid_from'                 => $request->paid_from,
            'txt_id'                    => $request->txt_id,
            'paid_amount'               => $request->paid_amount,
            'total_amount'              => $request->total_amount,
            'payment_status'            => $request->payment_status,
            'status'                    => 'approved',
//            'coupon_code'               => $request->coupon_code,
//            'coupon_amount'             => $request->coupon_amount,
            'batch_exam_subscription_id' => isset($request->batch_exam_subscription_id) ?? null,
        ]);
    }

    public static function orderProduct($request, $id = null)
    {
        ParentOrder::updateOrCreate(['id' => $id], [
            'parent_model_id'           => $request->parent_model_id,
            'user_id'                   => auth()->id(),
            'order_invoice_number'      => self::generateOrderNumber(),
            'ordered_for'               => $request->ordered_for,
            'payment_method'            => $request->payment_method,
            'vendor'                    => $request->vendor,
            'paid_to'                   => $request->paid_to,
            'paid_from'                 => $request->paid_from,
            'txt_id'                    => $request->txt_id,
//            'paid_amount'   => $request->paid_amount,
            'total_amount'              => $request->total_amount,
            'coupon_code'               => $request->coupon_code,
            'coupon_amount'             => $request->coupon_amount,
            'batch_exam_subscription_id' => isset($request->batch_exam_subscription_id) ?? null,

            'shipping_address'          => $request->ordered_for == 'product' ? $request->shipping_address : null,
            'notes'                     => $request->ordered_for == 'product' ? $request->shipping_address : null,
            'delivery_charge'           => $request->delivery_charge == 'product' ? $request->delivery_charge : 0,
        ]);
    }

    public static function orderProductThroughSSL($requestData, $request, $parentOrderId = null)
    {
        foreach (Cart::getContent() as $item)
        {
            ParentOrder::updateOrCreate(['id' => $parentOrderId], [
                'parent_model_id'           => $item->id,
                'user_id'                   => ViewHelper::loggedUser()->id,
                'order_invoice_number'      => $request->tran_id,
                'ordered_for'               => 'product',
                'payment_method'            => $requestData->payment_method,
                'paid_amount'               => $request->amount ?? 0,
                'total_amount'              => Cart::getTotal() + $requestData->delivery_charge ?? 0,
//                'coupon_code'               => $requestData->coupon_code,
//                'coupon_amount'             => $requestData->coupon_amount,
                'bank_tran_id'              => $requestData->payment_method == 'ssl' ? $request->bank_tran_id : ($requestData->payment_method == 'bkash' ? $request->trxID : ''),
//                'bank_tran_id'              =>  $request->bank_tran_id ,
                'gateway_val_id'             => $request->gateway_val_id ?? '',
                'gateway_status'             => $request->gateway_status ?? '',
                'status'                    => 'approved',
                'payment_status'            => 'complete',
//                'batch_exam_subscription_id' => isset($requestData->batch_exam_subscription_id) ?? null,

                'shipping_address'          => $requestData->ordered_for == 'product' ? $requestData->shipping_address : null,
                'notes'                     => $requestData->ordered_for == 'product' ? $requestData->notes : null,
                'delivery_charge'           => $requestData->ordered_for == 'product' ? $requestData->delivery_charge : 0,
            ]);
            $product = Product::find($item->id);
            $product->stock_amount = $product->stock_amount -1;
            if ($product->stock_amount == 0)
            {
                $product->is_stock = 0;
            }
            $product->save();
        }
        Cart::clear();
    }

    public static function generateOrderNumber ()
    {
        $number = rand(100000, 999999999);
        $existNumber = ParentOrder::where('order_invoice_number', $number)->first();
        if (!empty($existNumber) && count($existNumber) > 0)
        {
            self::generateOrderNumber();
        }
        return $number;
    }

    public static function updateExamOrderStatus($request, $id)
    {
        self::$xmOrder = ParentOrder::find($id);
//        self::$xmOrder->checked_by  = auth()->id();

//        if ($request->payment_status == 'complete')
//        {
//            self::$xmOrder->paid_amount  = self::$xmOrder->exam->price;
//        } else {
//            self::$xmOrder->paid_amount  = !empty($request->paid_amount) ? $request->paid_amount : self::$xmOrder->paid_amount;
//        }

        self::$xmOrder->paid_amount  = $request->paid_amount;
        self::$xmOrder->payment_status  = $request->payment_status;
//        self::$xmOrder->contact_status  = $request->contact_status;
        self::$xmOrder->status  = $request->status;
        self::$xmOrder->save();
        return self::$xmOrder;
    }

    public static function detachStudent($modelType, $modelId, $userId)
    {
        if ($modelType == 'course')
        {
            $course = Course::find($modelId);
            $course->students()->detach(Student::where('user_id', $userId)->first()->id);
        } elseif ($modelType == 'batch_exam')
        {
            $batchExam = BatchExam::find($modelId);
            $batchExam->students()->detach(Student::where('user_id', $userId)->first()->id);
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'parent_model_id');
    }

    public function batchExam()
    {
        return $this->belongsTo(BatchExam::class, 'parent_model_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'parent_model_id');
    }

    public function checkedBy()
    {
        return $this->belongsTo(User::class, 'checked_by');
    }

    public function batchExamSubscription()
    {
        return $this->belongsTo(BatchExamSubscription::class);
    }
    public function orderRefferedBy()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }
}
