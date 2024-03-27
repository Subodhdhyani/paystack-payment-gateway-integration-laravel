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
            $table->string('payment_id')->unique();
            $table->string('receipt_no')->unique();
            $table->integer('product_id');
            $table->string('product_name');
            $table->bigInteger('quantity');
            $table->bigInteger('amount');
            $table->string('currency');
            $table->string('user_name');
            $table->string('user_email');
            $table->bigInteger('phone');
            $table->string('payment_status');
            $table->string('payment_method');
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
