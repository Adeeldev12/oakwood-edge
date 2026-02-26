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
             // For storing file paths
            $table->string('medical_records')->nullable();
            $table->string('supporting_records')->nullable()->after('medical_records');

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
                'medical_records',
                'supporting_records',
            ]);
        });
    }
};
