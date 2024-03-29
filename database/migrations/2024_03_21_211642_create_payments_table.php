<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->nullable()->unique();   //by razorpay server
            $table->string('payment_id')->nullable()->unique();  //by razorpay server
            $table->string('receipt_no')->unique();  //by locally our random code
            $table->string('student_name');
            $table->string('email');
            $table->string('mobile');
            $table->Integer('class');
            $table->bigInteger('fees');
            $table->Integer('month');
            $table->bigInteger('total_fees_paid');
            $table->string('currency')->nullable();
            $table->string('payment_status')->default('pending');
            $table->string('address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
