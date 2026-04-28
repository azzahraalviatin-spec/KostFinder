<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('name', 'like', '%dila%')->orWhere('email', 'like', '%dila%')->first();
if ($user) {
    echo "EMAIL: " . $user->email . "\n";
    echo "KOTA: " . $user->kota . "\n";
    echo "KECAMATAN: " . $user->kecamatan . "\n";
    echo "KELURAHAN: " . $user->kelurahan . "\n";
} else {
    echo "User not found\n";
}
