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
            //
             $table->date('due_date')->nullable()->after('client_id');
            $table->text('description')->nullable()->after('due_date');
            $table->decimal('vat_rate', 5, 2)->default(0)->after('description');
            $table->decimal('vat_amount', 10, 2)->default(0)->after('vat_rate');
            $table->decimal('total_amount', 12, 2)->default(0)->after('vat_amount');
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
                'due_date',
                'description',
                'vat_rate',
                'vat_amount',
                'total_amount',
            ]);
        });
    }
};
