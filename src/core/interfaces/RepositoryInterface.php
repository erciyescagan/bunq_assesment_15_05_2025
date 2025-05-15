<?php

namespace App\Core\Interfaces;

use PDO;

interface RepositoryInterface {

    public function setConnection(PDO $pdo): void;
 
    public function getTable(): string;

    public function setTable(string $tableName): void;

    public function getPrimaryKey(): string;

    public function select(array $columnsArray = ['*']): self;

    public function from(string $from): self;
 
    public function where(string $key, string $operator, string $value);
 
    public function like(string $key, string $value);

    public function innerJoin(string $pivotTable, string $relatedTable, string $foreignKey, string $localKey): self;
   
    public function findById(int $id): ?array;
  
    public function get(): array;
 
    public function create(array $data): array;
  
    public function delete(int $id): bool;
      
    public function attach(string $pivotTable, string $foreignKey, string $relatedKey, int $modelId, int $relatedId): bool;
   
    public function detach(string $pivotTable, string $foreignKey, string $relatedKey, int $modelId, int $relatedId): bool;
}