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
        Schema::create('pahhos_properties', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userId')->unsigned();
            $table->string('title',255);
            $table->string('slug',255);
            $table->longtext('description');
            $table->text('excerpt');
            $table->string('thumbnail',55);
            $table->enum('priceType',['fixed','unit']);
            $table->decimal('price');
            $table->bigInteger('phone');
            $table->string('ownerName',55);
            $table->string('email',55);
            $table->integer('confirmationRequired');
            $table->integer('status');
            $table->timestamps();
            $table->foreign('userId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pahhos_properties');
    }
};