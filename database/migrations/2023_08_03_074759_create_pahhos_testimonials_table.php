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
        Schema::create('pahhos_testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name',55);
            $table->string('title',255);
            $table->text('testimonial');
            $table->integer('status');
            $table->string('thumbnail',55)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pahhos_testimonials');
    }
};
