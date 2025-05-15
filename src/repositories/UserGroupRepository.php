<?php

namespace App\Repositories;

use App\Core\Classes\Repository;

class UserGroupRepository extends Repository {
    protected string $table = 'group_users';
    protected array $allowedColumns = ['user_id', 'group_id'];
}