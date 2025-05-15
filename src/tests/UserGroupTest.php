<?php

namespace App\Tests;

use App\Core\Classes\Connections\SQLite;
use App\Core\Interfaces\ConnectionInterface;
use App\Core\Interfaces\ControllerInterface;
use App\Core\Interfaces\RepositoryInterface;
use App\Core\Interfaces\ServiceInterface;
use App\Http\Controllers\UserGroupController;
use App\Http\Requests\JoinGroupRequest;
use App\Http\Requests\LeaveGroupRequest;
use App\Repositories\UserGroupRepository;
use App\Services\UserGroupService;
use InvalidArgumentException;
use Laminas\Diactoros\ResponseFactory;
use PHPUnit\Framework\TestCase;
use Slim\App;

class UserGroupTest extends TestCase {

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

        $this->repositoryInterface = new UserGroupRepository();
        $this->repositoryInterface->setConnection($pdo);

        $this->serviceInterface = new UserGroupService();
        $this->serviceInterface->setRepository($this->repositoryInterface);

        $this->controllerInterface = new UserGroupController();
        $this->controllerInterface->setService($this->serviceInterface);
    }

    public function test_user_can_join_group_success() 
    {
        $response = $this->controllerInterface->runRelationMethod(
            'userAttachGroup',
            new JoinGroupRequest([
                'user_id' => 101,
                'group_id' => 100
            ]));
        $this->assertTrue($response->getPayload());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_user_can_join_group_failure()
    {
        $response = $this->controllerInterface->create(new JoinGroupRequest(
                        [
                'user_id' => 101,
                'group_id' => null
            ]
        ));

        $this->assertEquals('{"group_id":["The group_id field is required.","The group_id field must be an integer."]}', $response->getPayload());
        $this->assertEquals(500, $response->getStatusCode());
    }

    public function test_user_can_leave_group_success()
    {
        $response = $this->controllerInterface->runRelationMethod('userDetachGroup',
            new LeaveGroupRequest([
                'user_id' => 101,
                'group_id' => 100
            ]));
        $this->assertTrue($response->getPayload());
        $this->assertEquals(200, $response->getStatusCode());
    }

}