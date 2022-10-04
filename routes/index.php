<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/routing/config.php';

use App\InitRouting;

$config = new InitRouting();

$config->startRouting();
