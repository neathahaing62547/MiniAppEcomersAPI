<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orderitem extends Model
{
    protected $table = 'orderitems';
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'subtotal'
    ];
    public function order()
    {
        return $this->belongsTo(order::class);
    }
    public function product()
    {
        return $this->belongsTo(product::class);
    }
}
