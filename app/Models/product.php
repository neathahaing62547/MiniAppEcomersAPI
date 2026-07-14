<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'image',
        'status'
    ];
    public function category()
    {
        return $this->belongsTo(category::class);
    }
    public function  cart_item()
    {
        return $this->hasMany(cartitems::class, 'product_id', 'id');
    }
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}
