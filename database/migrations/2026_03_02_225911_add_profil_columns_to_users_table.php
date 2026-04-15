<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('foto_profil')->nullable()->after('email');
            $table->string('telepon', 20)->nullable()->after('foto_profil');
            $table->string('kota', 100)->nullable()->after('telepon');
            $table->boolean('notif_booking')->default(true)->after('kota');
            $table->boolean('notif_cancel')->default(true)->after('notif_booking');
            $table->boolean('notif_pembayaran')->default(true)->after('notif_cancel');
            $table->boolean('notif_promo')->default(false)->after('notif_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['foto_profil','telepon','kota','notif_booking','notif_cancel','notif_pembayaran','notif_promo']);
        });
    }
};