<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            // Change enum to varchar to allow 'teacher'/'student'
            DB::statement("ALTER TABLE `users` MODIFY `role` VARCHAR(50) NULL DEFAULT NULL;");
        } elseif ($driver === 'sqlite') {
            // For sqlite, attempt to rename and recreate table using Schema builder fallback
            // This is a no-op here; if you use sqlite run migrations manually.
        } else {
            // Postgres
            DB::statement('ALTER TABLE users ALTER COLUMN role TYPE varchar(50);');
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            // revert to previous enum values (user,admin,moderator)
            DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('user','admin','moderator') NOT NULL DEFAULT 'user';");
        } elseif ($driver === 'sqlite') {
            // no-op
        } else {
            // Postgres: change back to text
            DB::statement('ALTER TABLE users ALTER COLUMN role TYPE text;');
        }
    }
};
