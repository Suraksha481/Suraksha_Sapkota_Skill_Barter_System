<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void
    {
        // Convert existing JSON role arrays to single string (pick first role)
        if (Schema::hasColumn('users', 'role')) {
            $users = DB::table('users')->select('id', 'role')->get();
            foreach ($users as $u) {
                $role = null;
                if (is_null($u->role)) {
                    $role = null;
                } else {
                    // Try decode JSON; if fail treat as string
                    $decoded = json_decode($u->role, true);
                    if (is_array($decoded) && count($decoded) > 0) {
                        $role = $decoded[0];
                    } else {
                        $role = $u->role;
                    }
                }
                DB::table('users')->where('id', $u->id)->update(['role' => $role]);
            }

            // Column type change deferred to a dedicated migration (avoid doctrine/dbal requirement)
        }
    }

    public function down(): void
    {
        // revert to text column
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->text('role')->nullable()->change();
            });
        }
    }
};
