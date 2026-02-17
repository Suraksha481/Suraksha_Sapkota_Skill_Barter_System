<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('ALTER TABLE users MODIFY role LONGTEXT');
        DB::statement('UPDATE users SET role = JSON_QUOTE(role)');
        DB::statement('UPDATE users SET role = CONCAT("[", role, "]")');
        DB::statement('ALTER TABLE users MODIFY role JSON');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('UPDATE users SET role = JSON_UNQUOTE(JSON_EXTRACT(role, "$[0]"))');
        DB::statement('ALTER TABLE users MODIFY role ENUM("user","admin","moderator","teacher","student") DEFAULT "user"');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};
