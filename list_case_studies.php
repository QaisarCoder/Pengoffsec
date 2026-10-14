<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$caseStudies = App\Models\CaseStudy::all();
foreach ($caseStudies as $case) {
    echo "ID: " . $case->id . " | Slug: " . $case->slug . "\n";
}
