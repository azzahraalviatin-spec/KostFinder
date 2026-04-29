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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id('id_room');
            $table->foreignId('kost_id')->constrained('kosts', 'id_kost')->onDelete('cascade');
            $table->string('nomor_kamar', 50);
            $table->integer('harga_per_bulan');
            $table->enum('status_kamar', ['tersedia', 'terisi'])->default('tersedia');
            $table->text('fasilitas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
