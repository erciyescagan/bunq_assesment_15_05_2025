<?php

namespace App\Core\Interfaces;

/**
 * Interface ConnectionInterface
 *
 * This interface defines a contract for establishing a database connection.
 */
interface ConnectionInterface
{
    /**
     * Establishes a connection and returns a PDO instance.
     *
     * @return \PDO The PDO instance representing the database connection.
     */
    public function connect() : \PDO;
}
