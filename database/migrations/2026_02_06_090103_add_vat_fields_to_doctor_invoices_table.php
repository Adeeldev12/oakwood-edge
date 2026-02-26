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
        Schema::table('doctor_invoices', function (Blueprint $table) {
            //
            $table->unsignedTinyInteger('vat_rate')->nullable(); // 5,10,20
    $table->decimal('vat_amount', 10, 2)->nullable();
    $table->decimal('total_amount', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctor_invoices', function (Blueprint $table) {
            //
        });
    }
};
