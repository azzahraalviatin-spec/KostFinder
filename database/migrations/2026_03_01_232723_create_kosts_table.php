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
    Schema::create('kosts', function (Blueprint $table) {
        $table->id('id_kost');
        $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
        $table->string('nama_kost', 150);
        $table->text('alamat');
        $table->string('kota', 100);
        $table->enum('tipe_kost', ['Putra', 'Putri', 'Campur']);
        $table->text('deskripsi')->nullable();
        $table->decimal('latitude', 10, 8)->nullable();
        $table->decimal('longitude', 11, 8)->nullable();
        $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kosts');
    }
};
