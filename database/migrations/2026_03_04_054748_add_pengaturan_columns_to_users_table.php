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
    Schema::table('users', function (Blueprint $table) {
        $table->boolean('notif_info_umum')->default(false);
        $table->boolean('notif_data_diri')->default(true);
        $table->boolean('notif_aktivitas')->default(true);
        $table->boolean('notif_pencarian')->default(true);
        $table->boolean('notif_chat')->default(true);
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['notif_info_umum','notif_data_diri','notif_aktivitas','notif_pencarian','notif_chat']);
    });
}
};
