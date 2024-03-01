<?php

require_once __DIR__ . '/vendor/autoload.php';

use Ramsey\Uuid\Uuid;

$uuid = Uuid::uuid7();
echo $uuid->toString() . PHP_EOL;