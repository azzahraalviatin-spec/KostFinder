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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('whatsapp_cs')->nullable();
            $table->string('email_support')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('tiktok_link')->nullable();
            $table->decimal('komisi_admin', 5, 2)->default(0);
            $table->boolean('notif_booking')->default(true);
            $table->boolean('notif_user')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['whatsapp_cs', 'email_support', 'instagram_link', 'tiktok_link', 'komisi_admin', 'notif_booking', 'notif_user']);
        });
    }
};
