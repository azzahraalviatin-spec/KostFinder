<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('kost_id')->constrained('kosts', 'id_kost')->onDelete('cascade');
            $table->foreignId('booking_id')->constrained('bookings', 'id_booking')->onDelete('cascade');
            $table->tinyInteger('rating')->default(5); // 1-5
            $table->tinyInteger('rating_kebersihan')->default(5);
            $table->tinyInteger('rating_fasilitas')->default(5);
            $table->tinyInteger('rating_lokasi')->default(5);
            $table->tinyInteger('rating_harga')->default(5);
            $table->text('komentar')->nullable();
            $table->json('foto_review')->nullable(); // array foto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
