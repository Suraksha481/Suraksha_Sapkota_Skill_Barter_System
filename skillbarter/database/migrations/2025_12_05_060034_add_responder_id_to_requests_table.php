<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('requests', function (Blueprint $table) {
            if (!Schema::hasColumn('requests', 'responder_id')) {
                $table->foreignId('responder_id')
                      ->nullable()
                      ->constrained('users')
                      ->nullOnDelete();
            }
        });
    }

    public function down()
    {
        Schema::table('requests', function (Blueprint $table) {
            if (Schema::hasColumn('requests', 'responder_id')) {
                $table->dropForeign(['responder_id']);
                $table->dropColumn('responder_id');
            }
        });
    }
};
