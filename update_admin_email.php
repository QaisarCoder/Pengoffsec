<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = App\Models\User::where('email', 'admin')->first();
if ($user) {
    $user->email = 'admin@pengoffsec.com';
    $user->save();
    echo "Admin email updated to: admin@pengoffsec.com\n";
} else {
    echo "Admin user not found.\n";
}
