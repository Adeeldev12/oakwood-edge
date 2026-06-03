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
             $table->string('interpreter_number')->nullable();

            $table->enum('interpreter_pay_by', ['us', 'solicitor'])
                  ->nullable()
                  ->after('interpreter_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            //
              $table->dropColumn([
                'interpreter_number',
                'interpreter_pay_by',
            ]);
        });
    }
};
