<?php

use App\Http\Controllers\MessageController;
use App\Http\Requests\GetMessagesByGroupAndUserRequest;
use App\Http\Requests\GetMessagesByGroupRequest;
use App\Http\Requests\GetMessagesByUserRequest;
use App\Repositories\MessageRepository;
use App\Services\MessageService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$repository = new MessageRepository();
$repository->setConnection($pdo);

$messageService = new MessageService();
$messageService->setRepository($repository);

$controller = new MessageController();
$controller->setService($messageService);

$app->post('/api/v1/messages', function (Request $request, Response $response, $args) use ($controller) {
    $request = json_decode($request->getBody(), true);
    $user_id = $request['user_id'] ?? null;
    $group_id = $request['group_id'] ?? null;
    $content = $request['content'] ?? null;

    $data = $controller->create(
        new \App\Http\Requests\SendMessageRequest([
            'user_id' => $user_id,
            'group_id' => $group_id,
            'content' => $content,
        ])
    );
    $payload = !is_array($data->getPayload()) ? $data->getPayload() : json_encode($data->getPayload());
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');    
});

$app->get('/api/v1/messages/group/{groupId}', function (Request $request, Response $response, $args) use ($controller) {
    $groupId = (int)$args['groupId'];

    $data = $controller->runRelationMethod('messagesWithGroup', new GetMessagesByGroupRequest(['group_id' => $groupId]));
    $payload = json_encode($data->getPayload());
    $response->getBody()->write($payload);
    $response = $response->withStatus(200);
    $response = $response->withHeader('Content-Type', 'application/json');
    return $response->withHeader('X-Total-Count', count($data->getPayload()));
});

$app->get('/api/v1/messages/user/{userId}', function (Request $request, Response $response, $args) use ($controller) {
    $userId = (int)$args['userId'];
    if ($userId) {
        $data = $controller->runRelationMethod('messagesWithUser', new GetMessagesByUserRequest(['user_id' => $userId]));
        $payload = json_encode($data->getPayload());
        $response->getBody()->write($payload);
        $response = $response->withStatus(200);
        $response = $response->withHeader('Content-Type', 'application/json');
        $response = $response->withHeader('X-Total-Count', count($data->getPayload()));
        return $response;
    } else {
        $response->getBody()->write("User ID is required!");
        return $response->withStatus(400);
    }
});

$app->get('/api/v1/messages/user/{userId}/group/{groupId}', function (Request $request, Response $response, $args) use ($controller) {
    $userId = (int)$args['userId'];
    $groupId = (int)$args['groupId'];

        if(empty($userId)) {
            $response->getBody()->write('User ID is required');
            return $response->withStatus(400);
        }
        if(empty($groupId)) {
            $response->getBody()->write('Group ID is required');
            $response = $response->withStatus(400);
        }
    
        $data = $controller->runRelationMethod('messagesWithGroupAndUser', new GetMessagesByGroupAndUserRequest(['group_id' => $groupId, 'user_id' => $userId]));
        $payload = json_encode($data->getPayload());
        $response->getBody()->write($payload);
        $response = $response->withStatus(200);
        $response = $response->withHeader('Content-Type', 'application/json');
        $response = $response->withHeader('X-Total-Count', count($data->getPayload()));
        return $response;
});

$app->get('/api/v1/messages', function(Request $request, Response $response, $args) use ($controller) {

    $data = $controller->get();
    $payload = json_encode($data->getPayload());
    $response->getBody()->write($payload);
    $response = $response->withStatus(200);
    $response = $response->withHeader('Content-Type', 'application/json');
    $response = $response->withHeader('X-Total-Count', count($data->getPayload()));
    return $response;
});


$app->delete('/api/v1/messages/{id}', function(Request $request, Response $response, $args) use ($controller) {
    $id = (int) $args['id'];
    $data = $controller->delete($id);
    $payload = json_encode($data->getPayload());
    $response->getBody()->write($payload);
    $response = $response->withStatus(200);
    $response = $response->withHeader('Content-Type', 'application/json');
    return $response;
});