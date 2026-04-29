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
        Schema::table('rooms', function (Blueprint $table) {
            $table->decimal('harga_harian', 12, 2)->nullable()->after('harga_per_bulan');
            $table->boolean('aktif_harian')->default(false)->after('harga_harian');
            $table->boolean('aktif_bulanan')->default(true)->after('aktif_harian');
        });
    }
    
    public function down()
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['harga_harian','aktif_harian','aktif_bulanan']);
        });
    }
};
