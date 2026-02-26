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
        Schema::table('solicitor_invoices', function (Blueprint $table) {
            $table->string('ref')->unique();

            $table->text('solicitor_address')->nullable();

            $table->string('client_name');

            $table->enum('expert_type', [
                'psychiatrist',
                'psychologist',
                'gp',
                'orthopaedic',
                'social_work',
                'probation_report',
                'country_expert',
                'cbt',
            ]);

            $table->decimal('amount', 10, 2);

            // Invoice payment status
            $table->enum('payment_status', ['paid', 'unpaid'])
                  ->default('unpaid');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitor_invoices', function (Blueprint $table) {
            //
             $table->dropColumn([
                'ref',
                'solicitor_address',
                'client_name',
                'expert_type',
                'amount',
                'payment_status',
            ]);
        });
    }
};
