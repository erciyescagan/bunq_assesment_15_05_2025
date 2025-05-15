<?php

namespace App\Core\Public\Routes;
use App\Core\Classes\Route;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Repositories\UserGroupRepository;
use App\Services\UserGroupService;
use App\Http\Controllers\UserGroupController;
use App\Http\Requests\JoinGroupRequest;
use App\Http\Requests\LeaveGroupRequest;

$userGroupRepository = new UserGroupRepository();
$userGroupRepository->setConnection($pdo);

$userGroupService = new UserGroupService();
$userGroupService->setRepository($userGroupRepository);

$controller = new UserGroupController();
$controller->setService($userGroupService);



$app->post('/api/v1/groups/{groupId}/users', function (Request $request, Response $response, $args) use ($controller) {
    $groupId = (int) $args['groupId'];
    $body = json_decode($request->getBody(), true);
    $userId = (int) $body['user_id'];
    $data = $controller->runRelationMethod("userAttachGroup", new JoinGroupRequest(['group_id' => $groupId, 'user_id' => $userId]));
    $payload = json_encode($data->getPayload());
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});


$app->delete('/api/v1/groups/{groupId}/users/{userId}', function(Request $request, Response $response, $args) use ($controller) {
    $userId = (int) $args['userId'];
    $groupId = (int) $args['groupId'];

    $data = $controller->runRelationMethod("userDetachGroup", new LeaveGroupRequest(['group_id' => $groupId, 'user_id' => $userId]));
    if ($data->getPayload()) {
        $response->getBody()->write(json_encode([
            'status' => 'success',
            'message' => 'User left group successfully.'
        ]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }
    
    $response->getBody()->write(json_encode([
        'status' => 'error',
        'message' => 'Failed to leave group.'
    ]));     
    return $response->withHeader('Content-Type', 'application/json')->withStatus(500);


});
