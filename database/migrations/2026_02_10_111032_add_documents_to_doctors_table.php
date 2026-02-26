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
             // 1. Personal Indemnity Insurance
            $table->string('pii_document')->nullable();
            $table->date('pii_issue_date')->nullable();
            $table->date('pii_expiry_date')->nullable();

            // 2. Public Liability Insurance
            $table->string('pli_document')->nullable();
            $table->date('pli_issue_date')->nullable();
            $table->date('pli_expiry_date')->nullable();

            // 3. ICO Certificate
            $table->string('ico_document')->nullable();
            $table->date('ico_issue_date')->nullable();
            $table->date('ico_expiry_date')->nullable();

            // 4. DBS
            $table->string('dbs_document')->nullable();
            $table->date('dbs_issue_date')->nullable();
            $table->date('dbs_expiry_date')->nullable();

            // 5. CV
            $table->string('cv_document')->nullable();
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
                'pii_document',
                'pii_issue_date',
                'pii_expiry_date',

                'pli_document',
                'pli_issue_date',
                'pli_expiry_date',

                'ico_document',
                'ico_issue_date',
                'ico_expiry_date',

                'dbs_document',
                'dbs_issue_date',
                'dbs_expiry_date',

                'cv_document',
            ]);
        });
    }
};
