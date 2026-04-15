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
        Schema::create('kost_images', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('kost_id');
            $table->string('image_path');
            $table->integer('sort_order')->default(0);

            $table->timestamps();

            $table->foreign('kost_id')
                  ->references('id_kost')
                  ->on('kosts')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kost_images');
    }
};