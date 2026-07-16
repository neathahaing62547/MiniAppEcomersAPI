<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class announcements extends Model
{
     protected $table = 'announcements';
     protected $primaryKey = 'id';
     protected $fillable = [
        'title',
        'message',
        'status',
     ];
    
}
