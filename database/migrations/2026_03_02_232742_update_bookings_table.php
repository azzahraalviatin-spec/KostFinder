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
        Schema::table('bookings', function (Blueprint $table) {
            $table->text('catatan')->nullable()->after('durasi_sewa');
            $table->enum('status_booking', ['pending','diterima','ditolak','selesai'])
                  ->default('pending')->change();
        });
    }
    
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('catatan');
        });
    }
};
