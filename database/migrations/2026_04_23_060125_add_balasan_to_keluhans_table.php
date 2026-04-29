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
        Schema::table('keluhans', function (Blueprint $table) {
            $table->unsignedBigInteger('booking_id')->nullable()->after('id');
            $table->string('jenis')->nullable()->after('booking_id');
            $table->text('deskripsi')->nullable()->after('jenis');
            $table->string('foto')->nullable()->after('deskripsi');
            $table->enum('status', ['pending','diproses','selesai'])->default('pending')->after('foto');
            $table->text('balasan')->nullable()->after('status');
            $table->timestamp('balasan_at')->nullable()->after('balasan');
        });
    }
    
    public function down(): void
    {
        Schema::table('keluhans', function (Blueprint $table) {
            $table->dropColumn(['booking_id','jenis','deskripsi','foto','status','balasan','balasan_at']);
        });
    }
};
