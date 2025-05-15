<?php

namespace App\Core\Classes;

use App\Core\Interfaces\RepositoryInterface;
use PDO;
use PDOException;

abstract class Repository implements RepositoryInterface {
   
    protected string $table = "";
   
    protected array $whereClauses = [];

    protected array $joinClauses = [];

    protected PDO $pdo;
    
    protected string $primaryKey;

    protected array $allowedColumns;

    public function __construct(string $primaryKey = "id")
    {
        $this->primaryKey = $primaryKey;
    }

    public function setPrimaryKey(string $primaryKey): void
    {
        $this->primaryKey = $primaryKey;
    }
 
    public int $modelId;

    public string $query = '';

    public function setConnection(PDO $pdo): void 
    {
        $this->pdo = $pdo;
    }
   
    public function getTable(): string 
    {
        return $this->table;
    }

    public function setTable(string $tableName): void
    {
         $this->table = $tableName;
    }
    public function getPrimaryKey(): string 
    {
        return $this->primaryKey;
    }

    public function select(array $columnsArray = ['*']): self
    {
        $columnsList = implode(', ', $columnsArray);
        $this->query .= "SELECT {$columnsList}";
        return $this;
    }

    public function from(string $from): self 
    {
        $this->query .= " FROM {$from}";
        return $this;
    }

    public function where(string $key, string $operator, string $value): self 
    {
        $this->whereClauses[] = [$key, $operator, $value];
        return $this;
    }

    public function like(string $key, string $value): self 
    {
        $this->whereClauses[] = [$key, "LIKE", $value];
        return $this;
    }

    public function innerJoin(string $pivotTable, string $relatedTable, string $foreignKey, string $localKey): self
    {
        $this->joinClauses[] = "INNER JOIN {$pivotTable} ON {$pivotTable}.{$foreignKey} = {$relatedTable}.{$localKey}";
        return $this;
    }

    public function findById(int $id): ?array 
    {        
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTable()} WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $data =  $stmt->fetch(PDO::FETCH_ASSOC);
        if (is_array($data)) {
            return $data;
        } else {
           return null;
        }
    }   

    public function get($columns = ['*']): array
    {
        $this->buildQuery($columns);
        $results = $this->executeQuery();
        $this->resetState();
        return $results;
    }

    public function create(array $data): array 
    {
        $fields = array_keys($data);
        $placeholders = array_fill(0, count($fields), '?');
        $values = array_values($data);

        $this->query = "INSERT INTO {$this->getTable()} (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = $this->pdo->prepare($this->query);
        try{
            $stmt->execute($values);
            return $this->findById($this->pdo->lastInsertId());
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
        
    }

    public function delete(int $id): bool 
    {
        $this->query = "DELETE FROM {$this->getTable()} WHERE id = ?";
        $stmt = $this->pdo->prepare($this->query);
        return $stmt->execute([$id]);
    }  

    public function attach(string $pivotTable, string $foreignKey, string $relatedKey, int $modelId, int $relatedId): bool
    {
        $query = "INSERT INTO {$pivotTable} ({$foreignKey}, {$relatedKey}) VALUES (?, ?)";
        
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([$modelId, $relatedId]);
    }

    public function detach(string $pivotTable, string $foreignKey, string $relatedKey, int $modelId, int $relatedId): bool
    {
        $query = "DELETE FROM {$pivotTable} WHERE {$foreignKey} = ? AND {$relatedKey} = ?";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([$modelId, $relatedId]);
    }

    private function buildQuery(array $columns): void
    {
        if (strlen($this->query) == 0) {
            $this->select($columns);
            $this->from($this->getTable());
        }

        if (!empty($this->joinClauses)) {
            $this->query .= ' ' . implode(' ', $this->joinClauses);
        }

        if (!empty($this->whereClauses)) {
            $clauses = array_map(function ($condition) {
                [$key, $operator, $value] = $condition;
                return "{$key} {$operator} ?";
            }, $this->whereClauses);

            $this->query .= " WHERE " . implode(' AND ', $clauses);
        }
    }

    private function executeQuery(): array
    {
        $values = array_column($this->whereClauses, 2);
        $stmt = $this->pdo->prepare($this->query);
        $stmt->execute($values);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function resetState(): void
    {
        $this->whereClauses = [];
        $this->joinClauses = [];
    }
    
}