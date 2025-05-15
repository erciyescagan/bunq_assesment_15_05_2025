<?php

namespace App\Core\Classes;

use App\Core\Interfaces\RepositoryInterface;
use App\Core\Interfaces\ServiceInterface;

abstract class Service implements ServiceInterface {
    
    protected RepositoryInterface $repository;
    protected string $table;
    
    public function getRepository(): RepositoryInterface 
    {
        return $this->repository;
    }
    public function setRepository(RepositoryInterface $repository): void 
    {
        $this->repository = $repository;
    }

    public function getTable(): string
    {
        return $this->getRepository()->getTable();
    }

    public function get(): array 
    {   
        return $this->getRepository()->get();
    }
    public function findById(int $id): array 
    {   
        $data = $this->getRepository()->findById($id);
        return !empty($data) ? $data : [];        
    }

    public function create(array $data): array
    {
        return $this->getRepository()->create($data);
    }

    public function delete(int $id): bool 
    {
        return $this->getRepository()->delete($id);
    }    
}