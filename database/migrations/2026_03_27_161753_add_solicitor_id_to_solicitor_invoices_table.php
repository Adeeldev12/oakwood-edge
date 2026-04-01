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
            //.
             $table->foreignId('solicitor_id')
            ->nullable()
            ->constrained('solicitors')
            ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitor_invoices', function (Blueprint $table) {
            //
             $table->dropForeign(['solicitor_id']);
        $table->dropColumn('solicitor_id');
        });
    }
};
