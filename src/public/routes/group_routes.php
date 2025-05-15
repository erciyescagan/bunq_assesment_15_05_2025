<?php

use App\Http\Controllers\GroupController;
use App\Http\Requests\GetUsersByGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Services\GroupService;
use App\Repositories\GroupRepository;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$groupRepository = new GroupRepository();
$groupRepository->setConnection($pdo);

$groupService = new GroupService();
$groupService->setRepository($groupRepository);

$controller = new GroupController();
$controller->setService($groupService);


$app->post('/api/v1/groups', function (Request $request, Response $response, $args) use ($controller) {
    $request = json_decode($request->getBody(), true);
    $name = $request['name'] ?? null;
    $data = $controller->create(
        new \App\Http\Requests\CreateGroupRequest([
            'name' => $name,
        ]));
    $payload = !is_array($data->getPayload()) ? $data->getPayload() : json_encode($data->getPayload());
    $response->getBody()->write($payload);

    return $response->withHeader('Content-Type', 'application/json');    
 

});

$app->get('/api/v1/groups', function (Request $request, Response $response, $args) use ($controller) {
    $data = $controller->get();
    $payload = json_encode($data->getPayload());
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/v1/groups/{id}', function ($request, $response, $args) use ($controller) {
    $id = (int)$args['id'];
    $data = $controller->getById($id);
    $payload = json_encode($data->getPayload());
    $response->getBody()->write($payload);
    $response = $response->withHeader('Content-Type', 'application/json');
    $response = $response->withStatus(200);
    return $response;
});

$app->delete('/api/v1/groups/{id}', function (Request $request, Response $response, $args) use ($controller) {
    $id = (int)$args['id'];

    if ($id) {
        $data = $controller->delete($id);
        $payload = json_encode($data->getPayload());
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    } else {
        $response->getBody()->write("Group ID is required!");
        return $response->withStatus(400);
    }
});


$app->get('/api/v1/groups/{groupId}/users', function (Request $request, Response $response, $args) use ($controller) {
    
    $groupId = (int)$args['groupId'];

    $data = $controller->runRelationMethod('getUsersByGroup', new GetUsersByGroupRequest(['id' => $groupId]));
    $payload = json_encode($data->getPayload());
    $response->getBody()->write($payload);

    return $response->withHeader('Content-Type', 'application/json');
});