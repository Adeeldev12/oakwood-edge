<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    //
     use SoftDeletes;
    protected $guarded = [];

     protected $fillable = [
        'name',
        'email',
        'contact_number',
        'expertise',
        'bio',
        'experience_years',
        'is_active',
        // Personal Indemnity Insurance
        'pii_document',
        'pii_issue_date',
        'pii_expiry_date',

        // Public Liability Insurance
        'pli_document',
        'pli_issue_date',
        'pli_expiry_date',

        // ICO Certificate
        'ico_document',
        'ico_issue_date',
        'ico_expiry_date',

        // DBS
        'dbs_document',
        'dbs_issue_date',
        'dbs_expiry_date',

        // CV
        'cv_document',
    ];

     public function invoices()
    {
        return $this->hasMany(DoctorInvoice::class);
    }
}
