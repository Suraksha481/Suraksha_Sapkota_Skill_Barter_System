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

            $table->enum('status',[
                'scheduled',
                'live',
                'completed',
                'cancelled'
            ])->default('scheduled');

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
