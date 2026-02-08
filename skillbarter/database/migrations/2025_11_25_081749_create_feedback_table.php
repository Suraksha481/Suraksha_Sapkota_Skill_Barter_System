<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('feedback', function (Blueprint $table) {
        $table->id();
        $table->foreignId('target_id'); // ID of user, skill, etc.
        $table->string('target_type');  // 'user', 'skill', etc.
        $table->foreignId('author_id')->constrained('users')->cascadeOnDelete(); // who gave feedback
        $table->tinyInteger('rating'); // 1-5 stars
        $table->text('comment')->nullable();
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
