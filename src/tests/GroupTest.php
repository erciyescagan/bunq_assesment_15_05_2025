<?php

namespace App\Tests;

use Slim\App;
use App\Core\Classes\Connections\SQLite;
use App\Core\Interfaces\ConnectionInterface;
use App\Core\Interfaces\ControllerInterface;
use App\Core\Interfaces\RepositoryInterface;
use App\Core\Interfaces\ServiceInterface;
use App\Repositories\GroupRepository;
use App\Services\GroupService;
use App\Http\Controllers\GroupController;
use App\Http\Requests\CreateGroupRequest;
use PHPUnit\Framework\TestCase;

class GroupTest extends TestCase
{
    private RepositoryInterface $repositoryInterface;
    private ServiceInterface $serviceInterface;
    private ControllerInterface $controllerInterface;
    private ConnectionInterface $connectionInterface;
    private \PDO $pdo;

    protected function setUp(): void
    {
        $this->connectionInterface = new SQLite();
        $this->pdo = $this->connectionInterface->connect();
        $this->repositoryInterface = new GroupRepository();
        $this->repositoryInterface->setConnection($this->pdo);
        $this->serviceInterface = new GroupService();
        $this->serviceInterface->setRepository($this->repositoryInterface);
        $this->controllerInterface = new GroupController();
        $this->controllerInterface->setService($this->serviceInterface);
    }

    public function test_create_group_success()
    {
        $response = $this->controllerInterface->create(new CreateGroupRequest(['name' => 'Test Group']));
        $keys = array_keys($response->getPayload());
        $this->assertEquals(['id', 'name', 'created_at'], $keys);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_create_group_field_name_can_not_be_empty()
    {
        $response = $this->controllerInterface->create(new CreateGroupRequest(['name' => '']));
        $this->assertEquals('{"name":["The name field is required."]}',$response->getPayload());
        $this->assertEquals(500, $response->getStatusCode());
    }

    public function test_create_group_field_name_not_set()
    {
        $response = $this->controllerInterface->create(new CreateGroupRequest([]));
        $this->assertEquals('{"name":["The name field is required."]}', $response->getPayload());
        $this->assertEquals(500, $response->getStatusCode());
    }

    

}