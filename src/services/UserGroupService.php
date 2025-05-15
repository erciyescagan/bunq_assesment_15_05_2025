<?php

namespace App\Services;

use App\Core\Classes\Service;
use App\Core\Interfaces\GroupAuthInterface;
use App\Core\Interfaces\RepositoryInterface;

class UserGroupService extends Service
{
    public function userAttachGroup(array $data): bool
    {
        return $this->getRepository()->attach($this->getTable(), 'user_id', 'group_id', $data['user_id'], $data['group_id']);
    }

    public function userDetachGroup(array $data): bool
    {
        return $this->getRepository()->detach($this->getTable(), 'user_id', 'group_id', $data['user_id'], $data['group_id']);
    }
}