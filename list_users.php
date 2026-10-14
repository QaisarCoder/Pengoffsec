<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$users = App\Models\User::all();
foreach ($users as $user) {
    echo "Email: " . $user->email . " | is_admin: " . ($user->is_admin ? 'true' : 'false') . "\n";
}
