<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // student
            $table->foreignId('teacher_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->decimal('amount', 10, 2); // Total amount in NPR
            $table->decimal('admin_share', 10, 2); // 50%
            $table->decimal('teacher_share', 10, 2); // 50%
            $table->string('type'); // subscription, session, etc.
            $table->string('status')->default('completed'); // for tracking admin-to-teacher payout status if needed
            $table->string('khalti_pidx')->nullable();
            $table->string('transaction_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
