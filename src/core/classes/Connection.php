<?php

namespace App\Core\Classes;

use App\Core\Interfaces\ConnectionInterface;

abstract class Connection implements ConnectionInterface {

    protected ?\PDO $pdo = null;
    protected string $dsn = 'null';
    protected array $attributes = [];

    public function connect(): \PDO
    {
        if ($this->pdo === null) {
            $this->pdo = new \PDO($this->dsn);
            if(!empty($this->attributes)) {
                $key = key($this->attributes);
                $this->pdo->setAttribute($key, $this->attributes[$key]);
            }
        }
        return $this->pdo;
    }}