<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sessions', function (Blueprint $table) {

            $table->string('meeting_link')->nullable();

            $table->dateTime('start_time')->nullable();

            $table->dateTime('end_time')->nullable();

            // We remove the status column here because the 'sessions' table already has a 'status' string column.
            // When inserting a session, we'll explicitly pass 'status' => 'scheduled'.

        });
    }

    public function down(): void
    {
        Schema::table('sessions', function (Blueprint $table) {

            $table->dropColumn('meeting_link');
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
            $table->dropColumn('status');

        });
    }
};
