<?php

namespace App\Core\Classes;

use App\Core\Interfaces\ControllerInterface;
use App\Core\Interfaces\RequestInterface;
use App\Core\Interfaces\ServiceInterface;
use Laminas\Diactoros\Response\JsonResponse;

abstract class Controller implements ControllerInterface
{       
    protected ServiceInterface $service;
    
    public function getService(): ServiceInterface 
    {
        return $this->service;
    }   
    public function setService(ServiceInterface $service): void 
    {
        $this->service = $service;
    }  
    public function create(RequestInterface $request): JsonResponse
    {   
        try 
            {
            $request->validate();
            $data = $request->all();
            $saved = $this->getService()->create($data);
            return $this->json($saved);
        } catch (\Exception $e) {
            return $this->json($e->getMessage(), 500);
        }
    }

    public function get(): JsonResponse
    {
        $data = $this->getService()->get();
        return $this->json($data);
    }
    
    public function delete(int $id): JsonResponse
    {
        try {
            $deleted = $this->getService()->delete($id);
            return $this->json(['message' => 'Data id : '.$id.' has been deleted successfully'], 200);
        } catch (\Exception $e) {
            throw new \Exception("Data id : ". $id . " not found");
        }
    }
    public function getById(int $id): JsonResponse
    { 
        $data = $this->getService()->findById($id);
        return $this->json($data, 200);
    }

    public function runRelationMethod(string $relation, RequestInterface $request): JsonResponse
    {
        try {
            return $this->json($this->getService()->$relation($request->all()), 200);
        } catch (\Exception $e) {
            return $this->json($e->getMessage(), 404);
        }
    }
    
    protected function json($data, int $statusCode = 200): JsonResponse
    {
        return new JsonResponse($data, $statusCode);
    }

   

}