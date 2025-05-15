<?php

namespace App\Repositories;

use App\Core\Classes\Repository;

class UserRepository extends Repository {
    protected string $table = "users"; 
    protected array $allowedColumns = ['id', 'username'];
}