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
        Schema::create('doctor_invoices', function (Blueprint $table) {
            $table->id();
              $table->string('doctor_name');
            $table->string('our_ref')->unique();
            $table->string('client_name');

            $table->decimal('amount', 10, 2);

            $table->enum('payment_status', ['paid', 'unpaid'])
                  ->default('unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_invoices');
    }
};
