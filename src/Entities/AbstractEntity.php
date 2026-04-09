<?php

namespace Asmi\JsonLd\Entities;

use Asmi\JsonLd\Exceptions\JsonLdException;
use Asmi\JsonLd\Contracts\RenderableJsonLdInterface;
use Asmi\JsonLd\Rendering\JsonLdRenderer;
use Asmi\JsonLd\Validation\EntityValidator;

abstract class AbstractEntity implements RenderableJsonLdInterface
{
    /** @var array<string, mixed> */
    protected array $properties = [];

    /** @var list<string> */
    protected array $requiredFields = [];

    protected string $schemaType = '';
    protected string $context = 'https://schema.org';

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data = [])
    {
        $this->properties = $data;
    }

    /**
     * Set a property on the entity using fluent API.
     *
     * @param array<int, mixed> $arguments
     */
    public function __call(string $method, array $arguments): static
    {
        $this->set($method, $arguments[0] ?? null);

        return $this;
    }

    /**
     * Set a property.
     */
    public function set(string $key, mixed $value): static
    {
        if ($value !== null) {
            $this->properties[$key] = $value;
        }

        return $this;
    }

    /**
     * Get a property.
     */
    public function get(string $key): mixed
    {
        return $this->properties[$key] ?? null;
    }

    /**
     * Check if a property exists.
     */
    public function has(string $key): bool
    {
        return isset($this->properties[$key]);
    }

    /**
     * Get all properties.
     *
     * @return array<string, mixed>
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * Get entity type.
     */
    public function getType(): string
    {
        return $this->schemaType;
    }

    /**
     * Get context URL.
     */
    public function getContext(): string
    {
        return $this->context;
    }

    /**
     * Convert entity to array with @context and @type.
        *
        * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            '@context' => $this->context,
            '@type' => $this->schemaType,
        ];

        // Add properties, filtering null values
        foreach ($this->properties as $key => $value) {
            if ($value !== null && $value !== '') {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    /**
     * Render as JSON.
     */
    public function toJson(int $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE): string
    {
        $flags = $flags | (config('jsonld.pretty_print') ? JSON_PRETTY_PRINT : 0);
        $json = json_encode($this->toArray(), $flags);

        if ($json === false) {
            throw new JsonLdException('Failed to encode JSON-LD payload.');
        }

        return $json;
    }

    /**
     * Validate the entity.
     */
    public function validate(): void
    {
        $validator = new EntityValidator();
        $validator->validate($this);
    }

    /**
     * Render as HTML script tag.
     */
    public function render(): string
    {
        $this->validate();
        $renderer = new JsonLdRenderer();
        return $renderer->render($this);
    }

    /**
     * Get required fields for this entity type.
     *
     * @return list<string>
     */
    public function getRequiredFields(): array
    {
        return $this->requiredFields;
    }
}
