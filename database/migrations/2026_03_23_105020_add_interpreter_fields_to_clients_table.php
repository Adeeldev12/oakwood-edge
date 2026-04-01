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
             $table->date('date_of_birth')->nullable();

            $table->boolean('interpreter_required')->default(false);

            $table->string('interpreter_name')->nullable();
            $table->string('interpreter_email')->nullable();
            $table->string('interpreter_language')->nullable();
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
                'date_of_birth',
                'interpreter_required',
                'interpreter_name',
                'interpreter_email',
                'interpreter_language',
            ]);
        });
    }
};
