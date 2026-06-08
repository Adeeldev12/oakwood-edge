<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    //
      protected $fillable = [
        'user_id',
        'content',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

}
