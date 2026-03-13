<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learning_sessions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();

            $table->string('skill');
            $table->dateTime('start_time');
            $table->dateTime('end_time');

            $table->string('meeting_link')->nullable();

            $table->enum('status',[
                'scheduled',
                'live',
                'completed',
                'cancelled'
            ])->default('scheduled');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learning_sessions');
    }
};
