<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlists';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'product_id'
    ];
    public function user()
    {
        return $this->belongsTo(auth_user::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class , 'product_id');
    }
}
