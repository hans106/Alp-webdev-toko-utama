<?php
// Simple script to move event images from 'Event' -> 'events' and update DB entries.
// Run: php scripts/move_event_images.php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

echo "Starting move_event_images script...\n";

$moved = 0;
$updated = 0;

// 1) Move files in storage/app/public/Event -> storage/app/public/events
$from = storage_path('app/public/Event');
$to   = storage_path('app/public/events');

if (File::exists($from)) {
    if (! File::exists($to)) {
        File::makeDirectory($to, 0755, true);
        echo "Created directory: $to\n";
    }

    $files = File::files($from);
    foreach ($files as $f) {
        $dest = $to . DIRECTORY_SEPARATOR . $f->getFilename();
        if (! File::exists($dest)) {
            File::move($f->getRealPath(), $dest);
            echo "Moved: {$f->getFilename()}\n";
            $moved++;
        } else {
            echo "Skipped (exists): {$f->getFilename()}\n";
        }
    }

    // remove now-empty source dir
    File::deleteDirectory($from);
    echo "Removed source dir: $from\n";
} else {
    echo "No storage/Event directory found at: $from\n";
}

// 2) Also move files in public/storage/Event -> public/storage/events (if exists)
$fromPub = public_path('storage/Event');
$toPub   = public_path('storage/events');
if (File::exists($fromPub)) {
    if (! File::exists($toPub)) {
        File::makeDirectory($toPub, 0755, true);
        echo "Created public dir: $toPub\n";
    }

    $files = File::files($fromPub);
    foreach ($files as $f) {
        $dest = $toPub . DIRECTORY_SEPARATOR . $f->getFilename();
        if (! File::exists($dest)) {
            File::move($f->getRealPath(), $dest);
            echo "Moved public: {$f->getFilename()}\n";
        } else {
            echo "Skipped public (exists): {$f->getFilename()}\n";
        }
    }

    File::deleteDirectory($fromPub);
    echo "Removed public source dir: $fromPub\n";
} else {
    echo "No public/storage/Event directory found at: $fromPub\n";
}

// 3) Update DB: replace entries that begin with 'Event/' (or 'Event\\') to just basename
$rows = DB::table('events')->where('image', 'like', 'Event/%')->orWhere('image', 'like', 'Event\\%')->get();
foreach ($rows as $r) {
    $old = $r->image;
    $new = basename(str_replace('\\', '/', $old));
    DB::table('events')->where('id', $r->id)->update(['image' => $new]);
    echo "Updated DB id={$r->id}: '$old' -> '$new'\n";
    $updated++;
}

echo "Done. Files moved: $moved. DB rows updated: $updated.\n";

if ($moved === 0 && $updated === 0) {
    echo "Nothing changed. If you expected files to move, check permissions and existing paths.\n";
}

return 0;
