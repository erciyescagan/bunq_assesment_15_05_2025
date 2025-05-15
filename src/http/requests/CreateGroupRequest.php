<?php

namespace App\Http\Requests;
use App\Core\Classes\Request;

class CreateGroupRequest extends Request {
    protected array $rules = [
        'name' => 'required|string|max:255',
    ];
}