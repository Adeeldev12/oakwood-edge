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
             $table->string('remote_type')->nullable();
            $table->string('remote_link')->nullable();

            $table->string('prison_name')->nullable();
            $table->string('prison_number')->nullable();
            $table->text('prison_address')->nullable();
            $table->string('prison_link')->nullable();
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
                'venue',
                'remote_type',
                'remote_link',
                'prison_name',
                'prison_number',
                'prison_address',
                'prison_link',
            ]);
        });
    }
};
