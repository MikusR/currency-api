<?php

declare(strict_types=1);

use App\Application;

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();


$app = new Application();
$app->run();