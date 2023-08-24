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
        Schema::create('pahhos_packages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userId')->unsigned();
            $table->string('title',255);
            $table->string('slug',255);
            $table->longtext('description');
            $table->longtext('howToReach');
            $table->longtext('extraDetails');
            $table->text('excerpt');
            $table->string('thumbnail',55);
            $table->decimal('price');
            $table->integer('days');
            $table->timestamps();
            $table->foreign('userId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pahhos_packages');
    }
};
