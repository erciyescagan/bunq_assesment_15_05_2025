<?php

namespace App\Services;

use App\Core\Classes\Service;
use App\Core\Interfaces\RepositoryInterface;
use App\Http\Responses\MessageWithRelationsResponse;

class MessageService extends Service {
    
    public function messagesWithGroup(array $data)
    {
        $table = $this->getRepository()->getTable();

        return $this->getRepository()
                    ->select([
                        $table.'.*', 
                        'groups.name', 
                        'groups.id as group_id'
                        ])
                    ->from($table)
                    ->innerJoin('groups', $table, 'id', 'group_id')
                    ->where('groups.id', '=', $data['group_id'])
                    ->get();
    }

    public function messagesWithUser(array $data)
    {
        $table = $this->getRepository()->getTable();

        return $this->getRepository()
                    ->select([
                        $table.'.*', 
                        'users.username', 
                        'users.id as user_id'
                        ])
                    ->from($table)
                    ->innerJoin('users', $table, 'id', 'user_id')
                    ->where('users.id', '=', $data['user_id'])
                    ->get();
    }

    public function messagesWithGroupAndUser(array $data)
    {
        $table = $this->getRepository()->getTable();

        if(!empty($data)){
            return $this->getRepository()
            ->select([
                $table.'.*', 
                'groups.id as group_id', 
                'groups.name as group_name', 
                'users.id as user_id', 
                'users.username'
                ])
            ->from($table)
            ->innerJoin('groups', $table, 'id', 'group_id')
            ->innerJoin('users', $table, 'id', 'user_id')
            ->where('groups.id', '=', $data['group_id'])
            ->where('users.id', '=', $data['user_id'])
            ->get();
        } else {
            return $this->getRepository()
                        ->select()
                        ->from($table)
                        ->innerJoin('groups', $table, 'id', 'group_id')
                        ->innerJoin('users', $table, 'id', 'user_id')
                        ->get();
        }
      
    }

}