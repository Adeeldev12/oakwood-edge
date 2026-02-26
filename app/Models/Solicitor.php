<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solicitor extends Model
{
    //

      use SoftDeletes;
    protected $guarded = [];

    protected $fillable = [
    'name',
    'email',
    'phone',
];

  public function clients()
    {
        return $this->hasMany(Client::class);
    }

}
