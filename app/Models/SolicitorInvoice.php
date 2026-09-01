<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SolicitorInvoice extends Model
{
    protected $table = 'solicitor_invoices';

    protected $casts = [
        'client_invoice_files' => 'array',
    ];

    protected $fillable = [
        'ref',
        'solicitor_address',
        'client_id',
        'expert_type',
        'amount',
        'payment_status',
        'client_invoice_files',
        'due_date',
        'description',
        'vat_rate',
        'vat_amount',
        'total_amount',
        'solicitor_id',
        'doctor_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function solicitor()
{
    return $this->belongsTo(Solicitor::class);
}

public function items(): HasMany
{
    return $this->hasMany(SolicitorInvoiceItem::class);
}

public function doctor()
{
    return $this->belongsTo(Doctor::class);
}

}
