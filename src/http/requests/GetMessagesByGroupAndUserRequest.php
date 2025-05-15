<?php

namespace App\Http\Requests;

use App\Core\Classes\Request;

class GetMessagesByGroupAndUserRequest extends Request {
    protected array $rules = [
        'group_id' => 'required|integer',
        'user_id' => 'required|integer'
    ];
}