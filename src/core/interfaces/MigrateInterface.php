<?php

namespace App\Core\Interfaces;
use App\Core\Interfaces\ConnectionInterface;

interface MigrateInterface {
 
    public function setConnection(ConnectionInterface $connectionInterface): void;
    public function run(string $query) : void;
}