<?php

namespace Asmi\JsonLd\Contracts;

interface EntityBuilderInterface
{
    /**
     * Set a property on the entity.
     */
    public function set(string $key, mixed $value): static;

    /**
     * Get a property from the entity.
     */
    public function get(string $key): mixed;

    /**
     * Get all properties.
        *
        * @return array<string, mixed>
     */
    public function getProperties(): array;

    /**
     * Check if a property exists.
     */
    public function has(string $key): bool;

    /**
     * Render the entity.
     */
    public function render(): string;
}
