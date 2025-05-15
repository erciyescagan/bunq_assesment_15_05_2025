<?php

namespace App\Http\Requests;

use App\Core\Classes\Request;

class GetGroupsByUserRequest extends Request {
    protected array $rules = [
        'id' => 'required'
    ];
}