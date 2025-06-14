<?php

require __DIR__ . '/../../../vendor/autoload.php';

use App\Core\Classes\Migrate;
use App\Core\Classes\Connections\SQLite;

$sqlite = new SQLite();
$migrate = new Migrate($sqlite);
$migrate->run(
    "CREATE TABlE IF NOT EXISTS group_users (
    user_id INTEGER NOT NULL,
    group_id INTEGER NOT NULL,
    PRIMARY KEY (user_id, group_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE
    ) 
");