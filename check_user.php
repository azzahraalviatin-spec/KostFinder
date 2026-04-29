<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('role', 'owner')->first();
echo "KOTA: " . $user->kota . "\n";
echo "KECAMATAN: " . $user->kecamatan . "\n";
echo "KELURAHAN: " . $user->kelurahan . "\n";
