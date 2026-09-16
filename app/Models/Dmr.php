<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dmr extends Model
{
    //
     protected $fillable = [
        'solicitor_id',
        'year',
        'month',
        'cases',
    ];

    public function solicitor()
    {
        return $this->belongsTo(Solicitor::class);
    }
}
