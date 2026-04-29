<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('total_bayar', 12, 2)->default(0)->after('status_booking');
            $table->decimal('komisi_admin', 12, 2)->default(0)->after('total_bayar');
            $table->decimal('pendapatan_owner', 12, 2)->default(0)->after('komisi_admin');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'total_bayar',
                'komisi_admin',
                'pendapatan_owner',
            ]);
        });
    }
};