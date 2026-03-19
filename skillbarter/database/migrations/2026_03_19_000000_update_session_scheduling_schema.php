<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add request_id to sessions table
        Schema::table('sessions', function (Blueprint $table) {
            $table->foreignId('request_id')->nullable()->after('skill_id')->constrained('requests')->nullOnDelete();
        });

        // 2. Update requests status enum to include 'scheduled'
        DB::statement("ALTER TABLE requests MODIFY COLUMN status ENUM('open', 'in_progress', 'accepted', 'scheduled', 'declined', 'completed', 'cancelled') DEFAULT 'open'");
    }

    public function down(): void
    {
        // 1. Rollback enum (remove 'scheduled' if needed, but safer to keep mostly same or restore original)
        DB::statement("ALTER TABLE requests MODIFY COLUMN status ENUM('open', 'in_progress', 'accepted', 'declined', 'completed', 'cancelled') DEFAULT 'open'");

        // 2. Remove request_id from sessions
        Schema::table('sessions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('request_id');
        });
    }
};
