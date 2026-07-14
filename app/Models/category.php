<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
     protected $table = 'categories';
     protected $primaryKey = 'id';

       protected  $fillable = [
        'name',
        'description',
        'status',
       ];
        public function product() {
            return $this->hasMany(product::class);
        }
}
