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
        Schema::create('session_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('sessions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Data migration: Move existing participant_id to the new pivot table
        $sessions = Illuminate\Support\Facades\DB::table('sessions')->whereNotNull('participant_id')->get();
        foreach ($sessions as $session) {
            Illuminate\Support\Facades\DB::table('session_participants')->insert([
                'session_id' => $session->id,
                'user_id' => $session->participant_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('session_participants');
    }
};
