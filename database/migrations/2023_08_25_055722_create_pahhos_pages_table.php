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
        Schema::create('pahhos_pages', function (Blueprint $table) {
            $table->id();
            $table->integer('userId');
            $table->string('title', 255);
            $table->string('slug',255);
            $table->text('excerpt');
            $table->longtext('description');
            $table->enum('status',['draft','publish','trash']);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pahhos_pages');
    }
};