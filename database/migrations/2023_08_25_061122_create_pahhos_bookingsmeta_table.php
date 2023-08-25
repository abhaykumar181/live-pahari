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
        Schema::create('pahhos_bookingsmeta', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bookingId')->unsigned();
            $table->bigInteger('orderId')->unsigned();
            $table->enum('objectType',['package','addon','property']);
            $table->bigInteger('objectId');
            $table->decimal('baseprice');
            $table->enum('priceType',['fixed','unit']);
            $table->decimal('totalPrice');
            $table->timestamps();
            $table->foreign('bookingId')->references('id')->on('pahhos_bookings');
            $table->foreign('orderId')->references('id')->on('pahhos_booking_orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pahhos_bookingsmeta');
    }
};