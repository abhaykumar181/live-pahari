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
        Schema::create('pahhos_booking_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bookingId')->unsigned();
            $table->decimal('unitPrice');
            $table->integer('quantity');
            $table->decimal('price');
            $table->enum('status',['paid','unpaid']);
            $table->timestamps();
            $table->foreign('bookingId')->references('id')->on('pahhos_bookings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pahhos_booking_orders');
    }
};