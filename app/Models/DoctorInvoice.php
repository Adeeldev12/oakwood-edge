<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorInvoice extends Model
{
    //
    protected $table = 'doctor_invoices';

    protected $casts = [
        'doctor_invoice_files' => 'array',
    ];

    protected $fillable = [
        'our_ref',
        'doctor_id',
        'client_id',
        'amount',
        'payment_status',
        'doctor_invoice_files',
        'vat_rate',
        'vat_amount',
        'total_amount',
        'pdf_path',
        'description',
    'due_date',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
