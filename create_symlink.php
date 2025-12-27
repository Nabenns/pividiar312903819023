<?php

$target = __DIR__ . '/storage/app/public';
$link = __DIR__ . '/public/storage';

if (file_exists($link)) {
    echo "The [public/storage] link already exists.\n";
    exit;
}

if (symlink($target, $link)) {
    echo "The [public/storage] link has been connected to [storage/app/public].\n";
} else {
    echo "The link could not be created.\n";
}
