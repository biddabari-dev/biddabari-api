<?php

namespace App\Models\Backend\ProductManagement;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductDeliveryOption extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'image',
        'fee',
        'description',
        'slug',
        'status',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'product_delivery_options';

    public static function saveOrUpdateProductDeliveryOptions ($request, $id = null)
    {
        static::updateOrCreate(['id' => $id], [
            'name'          => $request->name,
            'slug'          => str_replace(' ', '-', $request->name),
            'fee'          => $request->fee,
            'description'     => $request->description,
            'image'         => imageUpload($request->file('image'), 'product-management/product-delivery-options/', 'product-delivery-options', '400', '400', (isset($id) ? static::find($id)->image : null)),
            'status'        => $request->status == 'on' ? 1 : 0
        ]);
    }
}
