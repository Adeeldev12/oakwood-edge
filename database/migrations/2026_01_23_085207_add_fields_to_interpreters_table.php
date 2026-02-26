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
        Schema::table('interpreters', function (Blueprint $table) {
            //
             $table->string('interpreter_name');
            $table->string('national_language');
            $table->string('mobile_number');
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('referral')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interpreters', function (Blueprint $table) {
            //
            $table->dropColumn([
                'interpreter_name',
                'national_language',
                'mobile_number',
                'email',
                'address',
                'referral',
            ]);
        });
    }
};
