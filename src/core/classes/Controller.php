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
            return $this->json($saved, 200);
        } catch (\Exception $e) {
            return $this->json(json_decode($e->getMessage(),true), 500);
        }
    }

    public function get(): JsonResponse
    {
        $data = $this->getService()->get();
        return $this->json($data, 200);
    }
    
    public function delete(int $id): JsonResponse
    {
        $this->getService()->delete($id);
        return $this->json(['message' => 'Data id : '.$id.' has been deleted'], 200);
    }
    public function getById(int $id): JsonResponse
    { 
        $data = $this->getService()->findById($id);
        return $this->json($data, 200);
    }

    public function runRelationMethod(string $relation, RequestInterface $request): JsonResponse
    {
        try {
            $data = $this->getService()->$relation($request->all());
            return $this->json([$data], 200);
        } catch (\Exception $e) {
            return $this->json([$e->getMessage()], 500); 
        }
    }
    
    protected function json(array $data, $statusCode): JsonResponse
    {   
        return $this->setResponse($data, $statusCode);
    }

    private function setResponse(array $data, int $statusCode): JsonResponse
    {
        $data = $this->setResponseData($data, $statusCode);
        return new JsonResponse($data, $statusCode);
    }

    private function setResponseData(array $data, int $statusCode): array
    {
        $tempData = $data;
        $data = [];
        $data['status']['success'] = in_array($statusCode, [200,201]) ? true : false;
        $data['status']['code'] = $statusCode;
        if(!in_array($statusCode, [200,201])) {
            $data['errors'] = $tempData;
            $data['data'] = [];
        }
        return $data;
    }

   

}