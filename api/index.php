<?php

declare(strict_types=1);

$tmpDirectories = [
    '/tmp/app',
    '/tmp/app/public',
    '/tmp/views',
];

foreach ($tmpDirectories as $directory) {
    if (! is_dir($directory)) {
        mkdir($directory, 0777, true);
    }
}

require __DIR__.'/../public/index.php';
