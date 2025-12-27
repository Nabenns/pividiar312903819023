<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Starting symlink creation...\n";

$target = __DIR__ . '/storage/app/public';
$link = __DIR__ . '/public/storage';

echo "Target: $target\n";
echo "Link: $link\n";

if (file_exists($link)) {
    echo "The [public/storage] link already exists.\n";
    exit;
}

if (!function_exists('symlink')) {
    echo "Error: symlink() function is disabled.\n";
    exit;
}

if (symlink($target, $link)) {
    echo "Success: The [public/storage] link has been connected to [storage/app/public].\n";
} else {
    echo "Error: The link could not be created. Check permissions.\n";
    print_r(error_get_last());
}
