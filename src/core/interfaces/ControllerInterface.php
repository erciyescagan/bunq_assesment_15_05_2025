<?php

namespace App\Core\Interfaces;

use Laminas\Diactoros\Response\JsonResponse;

interface ControllerInterface {
 
    public function getService(): ServiceInterface;

    public function setService(ServiceInterface $serviceInterface): void;

    public function create(RequestInterface $requestInterface): JsonResponse;

    public function get(): JsonResponse;
  
    public function delete(int $id): JsonResponse;
  
    public function getById(int $id): JsonResponse;
    
    public function runRelationMethod(string $relation, RequestInterface $request): JsonResponse;


}