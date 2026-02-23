<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Metadata and display fields
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('category', 100)->nullable();

            // Storage fields
            $table->string('file_path');
            $table->string('filename')->nullable();
            $table->string('mime',100)->nullable();
            $table->integer('size')->nullable();
            $table->string('type',50)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};


