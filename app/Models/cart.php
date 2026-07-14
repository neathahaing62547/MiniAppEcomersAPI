<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cart extends Model
{        
  protected $table = 'carts';

       protected $primaryKey = 'id'; 
          protected $fillable = [
            'user_id',
          ];
   public function cart_items() {   
       return $this->hasMany(cartitems::class);
   }
   public function user() {
       return $this->belongsTo(auth_user::class, 'user_id');
   }
}
