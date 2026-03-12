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
        Schema::table('premium_memberships', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->default(0);
            $table->string('transaction_id')->nullable();
            $table->string('payment_method')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('premium_memberships', function (Blueprint $table) {
            $table->dropColumn(['price', 'transaction_id', 'payment_method']);
        });
    }
};
