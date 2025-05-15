<?php

use Dotenv\Dotenv;
require __DIR__ . '/../../vendor/autoload.php';

use App\Core\Classes\Connections\SQLite;
use Slim\Factory\AppFactory;
$dotenv = Dotenv::createImmutable(__DIR__. '/../..');
$dotenv->load();

$app = AppFactory::create();

$connection = new SQLite();
$pdo = $connection->connect();

require __DIR__ . '/routes/api.php';

$app->run();