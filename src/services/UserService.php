<?php

namespace App\Services;

use App\Core\Classes\Service;

class UserService extends Service {

    public function getGroupsByUser(array $data)
    {
        $table = $this->getRepository()->getTable();
        $primaryKey = $this->getRepository()->getPrimaryKey();

        return $this->getRepository()
                    ->select([
                        $table.'.*', 
                        'groups.name as groupName', 
                        'groups.id as group_id'
                        ])
                    ->from($table)
                    ->innerJoin('group_users', 'groups', 'group_id', 'id')
                    ->innerJoin('groups', 'group_users', 'id', 'group_id')
                    ->where($table.".".$primaryKey, "=", $data['id'])
                    ->get();
 }
    
}