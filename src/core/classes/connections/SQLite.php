<?php
namespace App\Core\Classes\Connections;

use App\Core\Classes\Connection;
use App\Core\Interfaces\ConnectionInterface;

class SQLite extends Connection {
    protected ?\PDO $pdo = null;
    protected string $dsn = '';
    protected array $attributes = [];

    public function __construct()
    {
        $db_host = $_ENV['DB_HOST'] ?? 'sqlite:';
        $db_path = $_ENV['DB_PATH'] ?? '/../../../database/';
        $db_name = $_ENV['DB_NAME'] ?? 'database.sqlite';
        $this->dsn = $db_host . __DIR__ . $db_path . $db_name;
        $this->attributes = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ];
    }
 
}