<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->string('name');
            $table->string('rec_address');
            $table->string('phone');
            $table->integer('quantity');
            $table->integer('price');
            $table->string('status')->default('in progress'); // status pesanan
            $table->string('payment_status')->nullable();     // jika pakai midtrans
            $table->timestamps();

            // Relasi opsional
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
