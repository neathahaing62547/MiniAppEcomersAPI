<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_id',
        'amount',
        'payment_method',
        'status',
    ];

    public function order()
    {
        return $this->hasMany(order::class);
    }
}
