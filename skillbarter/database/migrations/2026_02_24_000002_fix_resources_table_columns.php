<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('resources', function (Blueprint $table) {
            if (! Schema::hasColumn('resources', 'title')) {
                $table->string('title')->nullable()->after('user_id');
            }
            if (! Schema::hasColumn('resources', 'description')) {
                $table->text('description')->nullable()->after('title');
            }
            if (! Schema::hasColumn('resources', 'category')) {
                $table->string('category', 100)->nullable()->after('description');
            }
            if (! Schema::hasColumn('resources', 'file_path')) {
                $table->string('file_path')->nullable()->after('category');
            }
            if (! Schema::hasColumn('resources', 'filename')) {
                $table->string('filename')->nullable()->after('file_path');
            }
            if (! Schema::hasColumn('resources', 'mime')) {
                $table->string('mime', 100)->nullable()->after('filename');
            }
            if (! Schema::hasColumn('resources', 'size')) {
                $table->integer('size')->nullable()->after('mime');
            }
            if (! Schema::hasColumn('resources', 'type')) {
                $table->string('type', 50)->nullable()->after('size');
            }
        });
    }

    public function down()
    {
        Schema::table('resources', function (Blueprint $table) {
            foreach (['title','description','category','file_path','filename','mime','size','type'] as $col) {
                if (Schema::hasColumn('resources', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
