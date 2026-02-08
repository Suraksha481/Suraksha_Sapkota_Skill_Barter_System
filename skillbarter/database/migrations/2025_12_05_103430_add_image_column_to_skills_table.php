<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageColumnToSkillsTable extends Migration
{
    public function up()
    {
        Schema::table('skills', function (Blueprint $table) {
            // Add image column to the skills table
            $table->string('image')->nullable()->after('description'); // image column
        });
    }

    public function down()
    {
        Schema::table('skills', function (Blueprint $table) {
            // Remove image column if rolled back
            $table->dropColumn('image');
        });
    }
}

