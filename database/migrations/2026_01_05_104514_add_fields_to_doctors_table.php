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
        Schema::table('doctors', function (Blueprint $table) {
            //
             $table->string('name')->after('id');
            $table->string('email')->unique()->after('name');
            $table->string('contact_number', 20)->nullable()->after('email');
            $table->string('expertise')->after('contact_number');

            // Recommended additional fields
            $table->text('bio')->nullable()->after('expertise');
            $table->integer('experience_years')->nullable()->after('bio');
            $table->boolean('is_active')->default(true)->after('experience_years');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            //
            $table->dropColumn([
                'name',
                'email',
                'contact_number',
                'expertise',
                'bio',
                'experience_years',
                'is_active',
            ]);
        });
    }
};
