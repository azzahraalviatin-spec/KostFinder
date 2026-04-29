<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('metode_pembayaran')->nullable()->after('catatan');
            $table->string('bukti_pembayaran')->nullable()->after('metode_pembayaran');
            $table->enum('status_pembayaran', ['belum', 'menunggu', 'lunas', 'ditolak'])->default('belum')->after('bukti_pembayaran');
            $table->decimal('total_harga', 12, 0)->nullable()->after('status_pembayaran');
            $table->date('tanggal_selesai')->nullable()->after('tanggal_masuk');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'bukti_pembayaran', 'status_pembayaran', 'total_harga', 'tanggal_selesai']);
        });
    }
};