<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            //
            // $table->id();

            $table->string('client_name');
            $table->string('ref_no')->nullable();
            $table->string('sol_ref')->nullable();
            $table->string('solicitor_name')->nullable();
            $table->string('mobile_number')->nullable();

            $table->string('claim_type')->nullable(); // Psychiatrist, GP, Psychologist
            $table->string('expert_name')->nullable();

            $table->date('instruction_date')->nullable();

            $table->string('invoice_no')->nullable();
            $table->string('invoice_status')->nullable();

            $table->date('appointment_date')->nullable();
            $table->string('appointment_time')->nullable();
            // string because some entries are ranges

            $table->string('venue')->nullable(); // Remote / In-person
            $table->string('medical_attended')->nullable(); // yes / no
            $table->string('report_status')->nullable(); // sent / pending

            $table->date('invoice_sent_date')->nullable();
            $table->date('report_sent_date')->nullable();

            $table->string('current_status')->nullable(); // Done, Waiting Payment
            $table->string('email')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            //
        });
    }
};
