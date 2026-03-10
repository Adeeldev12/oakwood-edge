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
             $table->string('interpreter_ref')->nullable()->after('client_name');

        $table->foreignId('interpreter_id')
            ->nullable()
            ->constrained('interpreters')
            ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            //
             $table->dropForeign(['interpreter_id']);
        $table->dropColumn(['interpreter_ref', 'interpreter_id']);
        });
    }
};
