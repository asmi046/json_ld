<?php

namespace Asmi\JsonLd\Contracts;

interface SchemaEntityInterface
{
    /**
     * Get the entity as an array.
    *
    * @return array<string, mixed>
     */
    public function toArray(): array;

    /**
     * Validate the entity.
     */
    public function validate(): void;

    /**
     * Get the entity type (e.g., 'Person', 'Organization').
     */
    public function getType(): string;

    /**
     * Get the entity context URL.
     */
    public function getContext(): string;

    /**
     * Get all entity properties.
     *
     * @return array<string, mixed>
     */
    public function getProperties(): array;

    /**
     * Get required fields for this entity.
     *
     * @return list<string>
     */
    public function getRequiredFields(): array;
}
