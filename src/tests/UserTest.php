<?php

namespace App\Tests;

use App\Core\Classes\Connections\SQLite;
use App\Core\Interfaces\ConnectionInterface;
use App\Core\Interfaces\ControllerInterface;
use App\Core\Interfaces\RepositoryInterface;
use App\Core\Interfaces\ServiceInterface;
use App\Http\Controllers\UserController;
use App\Http\Requests\CreateUserRequest;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Laminas\Diactoros\ResponseFactory;
use PHPUnit\Framework\TestCase;
use Slim\App;

class UserTest extends TestCase {

    private App $app;
    private ConnectionInterface $connectionInterface;
    private RepositoryInterface $repositoryInterface;
    private ServiceInterface $serviceInterface;
    private ControllerInterface $controllerInterface;

    protected function setUp(): void
    {
        $this->app = new App(new ResponseFactory());

        $this->connectionInterface = new SQLite();
        $pdo = $this->connectionInterface->connect();

        $this->repositoryInterface = new UserRepository();
        $this->repositoryInterface->setConnection($pdo);

        $this->serviceInterface = new UserService();
        $this->serviceInterface->setRepository($this->repositoryInterface);

        $this->controllerInterface = new UserController();
        $this->controllerInterface->setService($this->serviceInterface);
    }

    public function test_create_user_success()
    {
        $response = $this->controllerInterface->create(
            new CreateUserRequest(
                [   
                    'username' => 'test_user'
                ]
        ));
        $payload = $response->getPayload();
        $this->assertEquals(true, $payload['status']['success']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_create_message_field_username_can_not_be_empty() 
    {
        $response = $this->controllerInterface->create(new CreateUserRequest([]));
        $payload = $response->getPayload();
        $this->assertFalse(false, $payload['status']['success']);
        $this->assertTrue(true, empty($payload['data']));
        $this->assertTrue(true, isset($payload['errors']));
        $this->assertEquals(500, $response->getStatusCode());
    }
    
}