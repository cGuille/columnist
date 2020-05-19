<?php

foreach ([__DIR__ . '/../../../..', __DIR__ . '/..'] as $dir) {
    $autoloadFile = $dir . '/vendor/autoload.php';
    if (is_readable($autoloadFile)) {
        require_once $autoloadFile;
        break;
    }
}
