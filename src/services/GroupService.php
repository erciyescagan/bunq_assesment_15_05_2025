<?php

namespace App\Services;

use App\Core\Classes\Service;

class GroupService extends Service {
    
    public function getUsersByGroup(array $data)
    {
        $table = $this->getRepository()->getTable();
        $primaryKey = $this->getRepository()->getPrimaryKey();
        $data = $this->getRepository()
                    ->select([
                        $table.".id as group_id", 
                        $table.".name as group_name", 
                        $table.'.created_at', 
                        "users.id as user_id", 
                        'users.username'])
                    ->from($table)
                    ->innerJoin('group_users', 'groups', 'group_id', 'id')
                    ->innerJoin('users', 'group_users', 'id', 'user_id')
                    ->where($table.".".$primaryKey, "=", $data['id'])
                    ->get();
        return !is_null($data) ? $data : [];
    
     }
    
}