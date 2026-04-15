<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ActivityLog;

class DeleteOldActivities extends Command
{
    protected $signature = 'activities:clean';
    protected $description = 'Hapus log aktivitas yang lebih dari 7 hari';

    public function handle()
    {
        $deleted = ActivityLog::where('created_at', '<', now()->subDays(7))->delete();
        $this->info("Berhasil hapus {$deleted} log aktivitas lama.");
    }
}