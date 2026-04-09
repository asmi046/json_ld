<?php

namespace Asmi\JsonLd\Exceptions;

use Exception;

class ValidationException extends Exception
{
    /** @var array<string, string> */
    private array $errors = [];

    /**
     * @param array<string, string> $errors
     */
    public function __construct(array $errors = [])
    {
        $this->errors = $errors;
        $message = count($errors) > 0 
            ? 'JSON-LD validation failed: ' . implode(', ', array_map(fn($k, $v) => "$k: $v", array_keys($errors), $errors))
            : 'JSON-LD validation failed';
        parent::__construct($message);
    }

    /**
     * @return array<string, string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
