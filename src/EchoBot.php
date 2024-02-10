<?php

namespace m039;

require __DIR__ . '/../vendor/autoload.php';

$config = Config::findConfig();
if (!$config) {
    die("Can't find a config.\n");
}

echo "Test: " . $config->get("TEST") . "\n";