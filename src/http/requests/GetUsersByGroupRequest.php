<?php

namespace App\Http\Requests;

use App\Core\Classes\Request;

class GetUsersByGroupRequest extends Request {
    protected array $rules = [
        'id' => 'required|integer'
    ];
}