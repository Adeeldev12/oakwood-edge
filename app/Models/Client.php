<?php

namespace App\Models;

use App\Observers\ClientNotificationObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Client extends Model
{
    //

    use HasFactory, Notifiable;

    protected $casts = [
        'loi_bundle' => 'array',
        'trial_ends_at' => 'datetime',
    ];

    protected $fillable = [
        'client_name',
        'ref_no',
        'sol_ref',
        'solicitor_id',
        'mobile_number',
        'claim_type',
        'expert_name',
        'instruction_date',
        'invoice_no',
        'invoice_status',
        'appointment_date',
        'appointment_time',
        'venue',
        'medical_attended',
        'report_status',
        'invoice_sent_date',
        'report_sent_date',
        'current_status',
        'email',
        'notes',
        'loi_bundle',
        'medical_records',
        'supporting_records',
        'speciality',
        'date_of_birth',
        'interpreter_required',
        'interpreter_ref',
        'interpreter_name',
        'interpreter_email',
        'interpreter_language',
        'remote_type',
        'remote_link',
        'prison_name',
        'prison_number',
        'prison_address',
        'prison_link',
        'trial_ends_at',
        'interpreter_number',
        'interpreter_pay_by',

    ];

    protected static function booted(): void
{
    static::observe(ClientNotificationObserver::class);
}
    public function solicitor()
    {
        return $this->belongsTo(Solicitor::class);
    }

    public function doctorInvoices()
    {
        return $this->hasMany(DoctorInvoice::class);
    }

    public function solicitorInvoices()
    {
        return $this->hasMany(SolicitorInvoice::class);
    }

    public function interpreter()
    {
        return $this->belongsTo(Interpreter::class);
    }

     // ✅ ADD HERE
    public function isTrialExpiringSoon()
    {
        return $this->trial_ends_at &&
            now()->diffInDays($this->trial_ends_at, false) <= 2 &&
            now()->lessThanOrEqualTo($this->trial_ends_at);
    }

    public function isTrialExpired()
    {
        return $this->trial_ends_at &&
            $this->trial_ends_at->isPast();
    }
}
