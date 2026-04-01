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
        // Only add the column if it doesn't exist
        if (!Schema::hasColumn('clients', 'speciality')) {
            Schema::table('clients', function (Blueprint $table) {
                $table->string('speciality')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only drop the column if it exists
        if (Schema::hasColumn('clients', 'speciality')) {
            Schema::table('clients', function (Blueprint $table) {
                $table->dropColumn('speciality');
            });
        }
    }
};
