<?php

namespace Asmi\JsonLd\Validation;

use Asmi\JsonLd\Contracts\SchemaEntityInterface;
use Asmi\JsonLd\Exceptions\ValidationException;

class EntityValidator
{
    /**
     * Validate an entity.
     */
    public function validate(SchemaEntityInterface $entity): void
    {
        if (!config('jsonld.strict')) {
            return;
        }

        /** @var array<string, string> $errors */
        $errors = [];
        $requiredFields = $entity->getRequiredFields();
        $properties = $entity->getProperties();

        foreach ($requiredFields as $field) {
            $value = $properties[$field] ?? null;

            if ($value === null || $value === '') {
                $errors[$field] = "Required field '{$field}' is missing.";
            }
        }

        if (!empty($errors)) {
            throw new ValidationException($errors);
        }
    }
}
