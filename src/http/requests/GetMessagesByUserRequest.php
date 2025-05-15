<?php

namespace App\Http\Requests;

use App\Core\Classes\Request;

class GetMessagesByUserRequest extends Request {
    protected array $rules = [
        'user_id' => 'required|integer'
    ];
}