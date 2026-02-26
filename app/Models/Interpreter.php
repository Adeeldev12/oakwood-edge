<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interpreter extends Model
{
    //
     protected $fillable = [
        'interpreter_name',
        'national_language',
        'mobile_number',
        'email',
        'address',
        'referral',
    ];
}
