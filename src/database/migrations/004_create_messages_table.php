<?php

use App\Core\Classes\Migrate;
use App\Core\Classes\Connections\SQLite;

$sqlite = new SQLite();
$migrate = new Migrate();
$migrate->setConnection($sqlite);

$migrate->run(
    "CREATE TABlE IF NOT EXISTS messages (
    id INTEGER PRIMARY KEY AUTOINCREMENT, 
    content TEXT NOT NULL,
    user_id INTEGER NOT NULL,
    group_id INTEGER NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE
    );
");