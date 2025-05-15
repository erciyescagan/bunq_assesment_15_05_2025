<?php

use App\Core\Classes\Migrate;
use App\Core\Classes\Connections\SQLite;

$sqlite = new SQLite();
$migrate = new Migrate($sqlite);

$migrate->run(
    "CREATE TABlE IF NOT EXISTS groups (
    id INTEGER PRIMARY KEY AUTOINCREMENT, 
    name TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) 
");