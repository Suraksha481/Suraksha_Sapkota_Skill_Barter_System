<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disputes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_request_id')->constrained('requests')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('reason');
            $table->enum('status', ['open', 'resolved_refunded', 'resolved_dismissed'])->default('open');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disputes');
    }
};
