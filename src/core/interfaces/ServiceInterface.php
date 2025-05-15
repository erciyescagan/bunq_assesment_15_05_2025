<?php

namespace App\Core\Interfaces;
use App\Core\Interfaces\RepositoryInterface;

interface ServiceInterface {
 
    public function getRepository(): RepositoryInterface;

    public function setRepository(RepositoryInterface $repository): void;

    public function getTable(): string;

    public function get(): array;

    public function findById(int $id): array;
 
    public function create(array $data): array;

    public function delete(int $id): bool;


}