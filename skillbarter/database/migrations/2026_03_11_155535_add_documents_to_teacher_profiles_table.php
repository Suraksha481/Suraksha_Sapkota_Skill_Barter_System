<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teacher_profiles', function (Blueprint $table) {
            $table->string('bank_account')->nullable();
            $table->string('cv_path')->nullable();
            $table->string('certificate_path')->nullable();
            $table->string('citizenship_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teacher_profiles', function (Blueprint $table) {
            $table->dropColumn(['bank_account', 'cv_path', 'certificate_path', 'citizenship_path']);
        });
    }
};
