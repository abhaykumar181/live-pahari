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
        Schema::create('pahhos_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('bookingCode',55);
            $table->bigInteger('packageId');
            $table->string('name',55);
            $table->string('email',55);
            $table->integer('phone');
            $table->integer('guests');
            $table->date('checkInDate');
            $table->date('checkOutDate');
            $table->enum('status',['active','cancelled','archived']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pahhos_bookings');
    }
};