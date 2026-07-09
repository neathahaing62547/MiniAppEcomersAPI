<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cartitems extends Model
{
       
  protected $table = 'cart_items';

       protected $primaryKey = 'id'; 
          protected $fillable = [
            'cart_id',
            'product_id',
            'quantity'
          ];

      public function cart() {
         return $this->belongsTo(cart::class);
      }
        public function product() {
         return $this->belongsTo(product::class);
      }
     
}
