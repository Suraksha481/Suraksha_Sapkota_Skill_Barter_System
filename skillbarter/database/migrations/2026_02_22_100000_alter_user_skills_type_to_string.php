<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        // Make column flexible string to avoid enum mismatches and normalize old values
        // Use raw statement to avoid requiring doctrine/dbal for column modification
        DB::statement("ALTER TABLE `user_skills` MODIFY `type` VARCHAR(32) NOT NULL");

        // Normalize historical values that used different labels
        DB::table('user_skills')->where('type', 'learn')->update(['type' => 'request']);
        DB::table('user_skills')->where('type', 'teach')->update(['type' => 'offer']);
    }

    public function down(): void
    {
        // Attempt to convert back to enum('offer','request') if desired
        // First normalize any unexpected values to one of the allowed options
        DB::table('user_skills')->whereNotIn('type', ['offer','request'])->update(['type' => 'request']);

        // Then alter column back to enum using raw SQL
        DB::statement("ALTER TABLE `user_skills` MODIFY `type` ENUM('offer','request') NOT NULL");
    }
};
