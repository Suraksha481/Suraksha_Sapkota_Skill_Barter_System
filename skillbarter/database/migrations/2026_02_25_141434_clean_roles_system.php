<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('users', function (Blueprint $table) {

            // Remove old role columns if exist
            if (Schema::hasColumn('users', 'roles')) {
                $table->dropColumn('roles');
            }

            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['student','teacher','admin'])
                      ->default('student');
            }

            if (!Schema::hasColumn('users', 'is_teacher_approved')) {
                $table->boolean('is_teacher_approved')
                      ->default(false);
            }

            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')
                      ->default(true);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
