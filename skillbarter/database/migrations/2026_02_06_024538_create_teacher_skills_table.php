<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('teacher_skills', function (Blueprint $table) {
            $table->id();

            $table->foreignId('teacher_profile_id')
                  ->constrained('teacher_profiles')
                  ->cascadeOnDelete();

            $table->foreignId('skill_id')
                  ->constrained('skills')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('teacher_skills');
    }
};
