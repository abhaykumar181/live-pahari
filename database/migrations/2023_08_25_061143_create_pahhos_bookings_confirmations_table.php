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
        Schema::create('pahhos_bookings_confirmations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bookingId')->unsigned();
            $table->bigInteger('propertyId')->unsigned();
            $table->enum('confirmation',['pending','confirmed']);
            $table->enum('payment',['pending','paid']);
            $table->timestamps();
            $table->foreign('bookingId')->references('id')->on('pahhos_bookings');
            $table->foreign('propertyId')->references('id')->on('pahhos_properties');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pahhos_bookings_confirmations');
    }
};