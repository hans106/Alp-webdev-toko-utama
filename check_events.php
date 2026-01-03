<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$events = \App\Models\Event::all();
foreach($events as $e) {
    echo $e->id . ' | ' . $e->title . ' | ' . $e->image . PHP_EOL;
}
