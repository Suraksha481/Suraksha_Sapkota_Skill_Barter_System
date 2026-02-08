<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();

            // FIXED foreign keys
            $table->foreignId('organiser_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->foreignId('participant_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->foreignId('skill_id')
                  ->nullable()
                  ->constrained()
                  ->cascadeOnDelete();

            $table->dateTime('scheduled_at')->nullable();
            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sessions');
    }
};
