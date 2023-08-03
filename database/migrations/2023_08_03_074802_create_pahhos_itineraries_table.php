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
        Schema::create('pahhos_itineraries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('packageId')->unsigned();
            $table->integer('day');
            $table->string('title',255);
            $table->longtext('description');
            $table->timestamps();
            $table->foreign('packageId')->references('id')->on('pahhos_packages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pahhos_itineraries');
    }
};
