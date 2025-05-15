<?php

namespace App\Core\Interfaces;

interface RequestInterface {

    public function __construct(array $data = []);

    public function validate(): void;

    public function all(): array;
    
    public function get(string $key, $default = []): array;
}