<?php

namespace App\Core\Classes;

use App\Core\Interfaces\RequestInterface;

abstract class Request implements RequestInterface 
{
    protected array $data = [];
    protected array $rules = [];
    protected array $errors = [];
    
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function validate(): void
    {
        foreach ($this->rules as $field => $rules) {
            $value = $this->data[$field] ?? null;
            $rules = explode('|', $rules);

            foreach ($rules as $rule) {
                $this->applyRule($field, $value, $rule);
            }
        }

        if (!empty($this->errors)) {
            throw new \InvalidArgumentException(json_encode($this->errors));
        }
    }

    public function get(string $key, $default = []): array
    {
        return $this->data[$key] ?? $default;
    }

    public function all(): array
    {
        return $this->data;
    }

    protected function applyRule(string $field, $value, string $rule): void
    {
        if ($rule === 'required' && empty($value)) {
            $this->addError($field, 'The ' . $field . ' field is required.');
        }

        if ($rule === 'integer' && !filter_var($value, FILTER_VALIDATE_INT)) {
            $this->addError($field, 'The ' . $field . ' field must be an integer.');
        }

        if (str_starts_with($rule, 'max:')) {
            $max = (int)str_replace('max:', '', $rule);
            if (is_string($value) && strlen($value) > $max) {
                $this->addError($field, 'The ' . $field . ' field must not exceed ' . $max . ' characters.');
            }
        }

        if (str_starts_with($rule, 'min:')) {
            $min = (int)str_replace('min:', '', $rule);
            if (is_string($value) && strlen($value) < $min) {
                $this->addError($field, 'The ' . $field . ' field must be at least ' . $min . ' characters.');
            }
        }
    }


    protected function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

}