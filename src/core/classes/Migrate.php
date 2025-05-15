<?php

namespace App\Core\Classes;

use App\Core\Interfaces\ConnectionInterface;
use App\Core\Interfaces\MigrateInterface;
use Exception;

class Migrate implements MigrateInterface {

    protected ?\PDO $pdo;

    public function __construct(public ConnectionInterface $connectionInterface) 
    {
        $this->connectionInterface = $connectionInterface;
        $this->setConnection($this->connectionInterface);

        if($this->getConnection()) {
            try {
                $this->pdo = $this->connectionInterface->connect();
                return $this->pdo;
            } catch(\PDOException $e) {
                throw new \PDOException("Error occured: ", $e->getMessage());
            }
        }
    }

    public function setConnection(ConnectionInterface $connectionInterface): void
    {
        $this->connectionInterface = $connectionInterface;
    }
    private function getConnection(): ConnectionInterface 
    {
        return $this->connectionInterface;
    }

    public function run(string $query) : void 
    {
        try {
            $this->pdo->exec($query);
            echo "Migartion executed successfully!\n";
        } catch (Exception $e) {
            echo "Migration failed: " . $e->getMessage()."\n"; 
        }
    }
    

};