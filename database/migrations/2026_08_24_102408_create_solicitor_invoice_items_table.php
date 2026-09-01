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
        Schema::create('solicitor_invoice_items', function (Blueprint $table) {
            $table->id();
             $table->foreignId('solicitor_invoice_id')
            ->constrained('solicitor_invoices')
            ->cascadeOnDelete();

        $table->string('description');

        $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitor_invoice_items');
    }
};
