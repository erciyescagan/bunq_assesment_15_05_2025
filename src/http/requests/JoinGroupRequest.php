<?php

namespace App\Http\Requests;

use App\Core\Classes\Request;

class JoinGroupRequest extends Request {
    protected array $rules = [
        'user_id' => 'required|integer',
        'group_id' => 'required|integer'
    ];
}