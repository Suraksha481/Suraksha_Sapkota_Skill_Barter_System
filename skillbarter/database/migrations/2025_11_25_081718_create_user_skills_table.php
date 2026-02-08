<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('user_skills', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('skill_id')
                ->constrained()
                ->cascadeOnDelete();

        // Core role of the skill
            $table->enum('type', ['teach', 'learn']);

        // Skill proficiency
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])
                ->default('beginner');

        // Optional future monetization / sessions
            $table->decimal('price', 10, 2)->nullable();
            $table->string('location')->nullable();

            $table->timestamps();

        // Prevent duplicates
            $table->unique(['user_id', 'skill_id', 'type'], 'user_skill_unique');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('user_skills');
    }
};
