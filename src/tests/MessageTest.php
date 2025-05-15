<?php

namespace App\Tests;

use App\Core\Interfaces\ConnectionInterface;
use App\Core\Interfaces\ControllerInterface;
use App\Core\Interfaces\RepositoryInterface;
use App\Core\Interfaces\ServiceInterface;
use PHPUnit\Framework\TestCase;
use Slim\App;
use Laminas\Diactoros\ResponseFactory;
use App\Core\Classes\Connections\SQLite;
use App\Repositories\MessageRepository;
use App\Services\MessageService;
use App\Http\Controllers\MessageController;
use App\Http\Requests\SendMessageRequest;
use InvalidArgumentException;

class MessageTest extends TestCase
{
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

        $this->repositoryInterface = new MessageRepository();
        $this->repositoryInterface->setConnection($pdo);

        $this->serviceInterface = new MessageService();
        $this->serviceInterface->setRepository($this->repositoryInterface);

        $this->controllerInterface = new MessageController();
        $this->controllerInterface->setService($this->serviceInterface);
    }

    public function test_create_message_success()
    {
        $response = $this->controllerInterface->create(
            new SendMessageRequest(
            [   
                'user_id' => 1,
                'group_id' => 1,
                'content' => 'Test Message By UnitTest'
            ]
        ));

        $keys = array_keys($response->getPayload());
        $this->assertEquals(['id', 'content', 'user_id', 'group_id', 'created_at'], $keys);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_create_message_field_content_can_not_be_empty()
    {
        $response = $this->controllerInterface->create(
            new SendMessageRequest(
                [
                    'user_id' => 1,
                    'group_id' => 1,
                    'content' => null
                ], []
            ));
        $this->assertEquals('{"content":["The content field is required."]}', $response->getPayload());
        $this->assertEquals(500, $response->getStatusCode());
    }

    public function test_create_message_field_user_id_can_not_be_empty()
    {
        $response = $this->controllerInterface->create(
            new SendMessageRequest(
                [
                    'user_id' => null,
                    'group_id' => 1,
                    'content' => "Test message by unitTest"
                ], []
            ));
        $this->assertEquals('{"user_id":["The user_id field is required.","The user_id field must be an integer."]}', $response->getPayload());
        $this->assertEquals(500, $response->getStatusCode());
    }


    public function test_create_message_field_group_id_can_not_be_empty()
    {
        $response = $this->controllerInterface->create(
            new SendMessageRequest(
                [
                    'user_id' => 1,
                    'group_id' => null,
                    'content' => "Test message by unitTest"
                ]
            ));

        $this->assertEquals('{"group_id":["The group_id field is required.","The group_id field must be an integer."]}', $response->getPayload());
        $this->assertEquals(500, $response->getStatusCode());
    }
}