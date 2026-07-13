<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class rating extends Model
{
    protected $table = 'rating' ; 
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'star',
        'comment'
    ];
    public function user()
    {
        return $this->belongsTo(auth_user::class);
    }
}
