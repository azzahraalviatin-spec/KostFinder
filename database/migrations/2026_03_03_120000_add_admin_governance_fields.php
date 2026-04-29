<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('status_akun', ['aktif', 'nonaktif'])->default('aktif')->after('role');
        });

        Schema::table('kosts', function (Blueprint $table) {
            $table->boolean('is_verified')->default(false)->after('status');
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('target_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action', 120);
            $table->string('target_type', 80)->nullable();
            $table->unsignedBigInteger('target_id')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        DB::table('users')->update(['status_akun' => 'aktif']);
        DB::table('kosts')->update(['is_verified' => false]);
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');

        Schema::table('kosts', function (Blueprint $table) {
            $table->dropColumn('is_verified');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status_akun');
        });
    }
};
