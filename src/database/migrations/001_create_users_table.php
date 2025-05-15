<?php

require __DIR__ . '/../../../vendor/autoload.php';

use App\Core\Classes\Migrate;
use App\Core\Classes\Connections\SQLite;

$sqlite = new SQLite();
$migrate = new Migrate();
$migrate->setConnection($sqlite);

$migrate->run(
    "CREATE TABlE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT, 
    username TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) 
");