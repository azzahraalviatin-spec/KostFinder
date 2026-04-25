<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Cek dulu — hanya tambah kalau belum ada
            if (!Schema::hasColumn('bookings', 'total_harga')) {
                $table->unsignedBigInteger('total_harga')->default(0)->after('durasi_sewa');
            }
            if (!Schema::hasColumn('bookings', 'komisi_admin')) {
                $table->unsignedBigInteger('komisi_admin')->default(0)->after('total_harga');
            }
            if (!Schema::hasColumn('bookings', 'pendapatan_owner')) {
                $table->unsignedBigInteger('pendapatan_owner')->default(0)->after('komisi_admin');
            }
            if (!Schema::hasColumn('bookings', 'selesai') && !Schema::hasColumn('bookings', 'status_booking')) {
                // status_booking sudah ada dari migration awal
            }
        });

        // Tambah 'selesai' ke enum status_booking kalau belum ada
        // (MySQL cara ubah enum)
        \DB::statement("ALTER TABLE bookings MODIFY COLUMN status_booking ENUM('pending','diterima','ditolak','selesai') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['komisi_admin', 'pendapatan_owner']);
        });
        \DB::statement("ALTER TABLE bookings MODIFY COLUMN status_booking ENUM('pending','diterima','ditolak','selesai') NOT NULL DEFAULT 'pending'");
    }
};