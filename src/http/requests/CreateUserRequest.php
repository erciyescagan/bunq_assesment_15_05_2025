<?php

namespace App\Http\Requests;
use App\Core\Classes\Request;

class CreateUserRequest extends Request {
    protected array $rules = [
        'username' => 'required|string|max:255',
    ];

}