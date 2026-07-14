<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'order_no',
        'total_price',
        'payment_method',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(auth_user::class);
    }
    public function orderItems()
    {
        return $this->hasMany(orderitem::class);
    }
    public function payment()
    {
        return $this->hasMany(payment::class);
    }
}
