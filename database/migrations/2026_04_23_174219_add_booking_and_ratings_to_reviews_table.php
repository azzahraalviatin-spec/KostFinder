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
        Schema::table('reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('reviews', 'booking_id')) {
                $table->unsignedBigInteger('booking_id')->nullable()->after('kost_id');
            }
            if (!Schema::hasColumn('reviews', 'rating_kebersihan')) {
                $table->integer('rating_kebersihan')->nullable()->after('rating');
                $table->integer('rating_fasilitas')->nullable()->after('rating_kebersihan');
                $table->integer('rating_lokasi')->nullable()->after('rating_fasilitas');
                $table->integer('rating_harga')->nullable()->after('rating_lokasi');
                $table->json('foto_review')->nullable()->after('komentar');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn([
                'booking_id',
                'rating_kebersihan',
                'rating_fasilitas',
                'rating_lokasi',
                'rating_harga',
                'foto_review'
            ]);
        });
    }
};
