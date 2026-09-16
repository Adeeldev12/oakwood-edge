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
        Schema::create('dmrs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitor_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->unsignedSmallInteger('year');

    $table->unsignedTinyInteger('month');

    $table->unsignedInteger('cases')->default(0);

    $table->timestamps();

    $table->unique([
        'solicitor_id',
        'year',
        'month',
    ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dmrs');
    }
};
