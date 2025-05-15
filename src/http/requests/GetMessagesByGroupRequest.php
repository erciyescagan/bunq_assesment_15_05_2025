<?php

namespace App\Http\Requests;

use App\Core\Classes\Request;

class GetMessagesByGroupRequest extends Request {
    protected array $rules = [
        'group_id' => 'required|integer'
    ];
}