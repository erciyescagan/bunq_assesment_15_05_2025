<?php

use App\Http\Controllers\UserController;
use App\Http\Requests\GetGroupsByUserRequest;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Http\Responses\UserResponse;


$userRepository = new UserRepository();
$userRepository->setConnection($pdo);

$userService = new UserService();
$userService->setRepository($userRepository);

$controller = new UserController();
$controller->setService($userService);

$app->post('/api/v1/users', function (Request $request, Response $response, $args) use ($controller) {
    $request = json_decode($request->getBody(), true);
    $username = $request['username'] ?? null;
    $data = $controller->create(
        new \App\Http\Requests\CreateUserRequest([
            'username' => $username,
        ]));
    $payload = !is_array($data->getPayload()) ? $data->getPayload() : json_encode($data->getPayload());
    $response->getBody()->write($payload);

    return $response->withHeader('Content-Type', 'application/json');    
  
});

$app->get('/api/v1/users', function (Request $request, Response $response, $args) use ($controller) {
    $data = $controller->get();
    $payload = json_encode($data->getPayload());
    $response->getBody()->write($payload);
    $response = $response->withStatus(200);
    $response = $response->withHeader('Content-Type', 'application/json');
    $response = $response->withHeader('X-Total-Count', count(json_decode($payload)));
    return $response;
});

$app->delete('/api/v1/users/{id}', function (Request $request, Response $response, $args) use ($controller) {
    $id = (int)$args['id'];

    if ($id) {
        $data = $controller->delete($id);
        $payload = json_encode($data);
        $response->getBody()->write($payload);
        $response = $response->withHeader('Content-Type', 'application/json');
        $response = $response->withStatus(200);
        return $response;
    } else {
        $response->getBody()->write("User ID is required!");
        return $response->withStatus(400);
    }
});

$app->get('/api/v1/users/{id}', function (Request $request, Response $response, $args) use ($controller) {
    $id = (int)$args['id'];
    $data = $controller->getById($id);
    $payload = json_encode($data->getPayload());
    $response->getBody()->write($payload);
    $response = $response->withHeader('Content-Type', 'application/json');
    $response = $response->withStatus(200);
    return $response;
});

$app->get('/api/v1/users/{userId}/groups', function (Request $request, Response $response, $args) use ($controller) {
    $userId = (int)$args['userId'];
    
    $data = $controller->runRelationMethod('getGroupsByUser', new GetGroupsByUserRequest(['id' => $userId]));
    $payload = json_encode($data->getPayload());
    $response->getBody()->write($payload);

    return $response->withHeader('Content-Type', 'application/json');
});
