<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticateble;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class auth_user extends Authenticateble
{
   use HasApiTokens, Notifiable;
   protected $table = 'user';
   protected $primaryKey = 'id';
   protected  $fillable = [
      'name',
      'email',
      'password',
      'role',
   ];
   public function cart()
   {
      return $this->hasOne(cart::class);
   }
   public function order()
   {
      return $this->hasMany(order::class, 'user_id', 'id');
   }
   public function wishlists()
   {
      return $this->hasMany(Wishlist::class,);
   }
   public function ratings()
   {
      return $this->hasMany(rating::class);
   }
}
