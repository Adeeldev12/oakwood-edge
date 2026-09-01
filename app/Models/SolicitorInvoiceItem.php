<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolicitorInvoiceItem extends Model
{
    //

     protected $fillable = [
        'solicitor_invoice_id',
        'description',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function solicitorInvoice(): BelongsTo
    {
           return $this->belongsTo(SolicitorInvoice::class);
    }
}
