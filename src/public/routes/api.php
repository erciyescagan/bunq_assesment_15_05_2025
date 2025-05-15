<?php

use App\Core\Classes\Connections\SQLite;
use App\Http\Controllers\GroupController;
use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\Group;
use App\Repositories\GroupRepository;
use App\Services\GroupService;
use App\Services\MessageService;
use App\Services\UserService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/group_routes.php';
require __DIR__ . '/user_routes.php';
require __DIR__ . '/message_routes.php';
require __DIR__ . '/group_user_routes.php';




