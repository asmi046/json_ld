<?php

namespace Asmi\JsonLd\Entities;

use Asmi\JsonLd\Contracts\RenderableJsonLdInterface;
use Asmi\JsonLd\Exceptions\JsonLdException;
use Asmi\JsonLd\Rendering\JsonLdRenderer;
use JsonException;

class RawSchema implements RenderableJsonLdInterface
{
    /** @var array<string, mixed> */
    protected array $data;

    /**
     * Create a raw schema from a free-form JSON string.
     *
     * @throws JsonLdException When the string is not valid JSON or not a JSON object.
     */
    public function __construct(string $json)
    {
        try {
            $decoded = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new JsonLdException('Invalid JSON-LD string: ' . $e->getMessage());
        }

        if (!is_array($decoded) || (!empty($decoded) && array_is_list($decoded))) {
            throw new JsonLdException('JSON-LD must be a JSON object.');
        }

        /** @var array<string, mixed> $decoded */
        $this->data = $decoded;
    }

    /**
     * Set a property on the schema.
     */
    public function set(string $key, mixed $value): static
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Get a property from the schema.
     */
    public function get(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Check if a property exists.
     */
    public function has(string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * Get all properties.
     *
     * @return array<string, mixed>
     */
    public function getProperties(): array
    {
        return $this->data;
    }

    /**
     * Get the schema as an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * Get the entity type (the "@type" value if present).
     */
    public function getType(): string
    {
        $type = $this->data['@type'] ?? '';

        return is_string($type) ? $type : '';
    }

    /**
     * Get the entity context (the "@context" value if present).
     */
    public function getContext(): string
    {
        $context = $this->data['@context'] ?? '';

        return is_string($context) ? $context : '';
    }

    /**
     * Get required fields for this schema.
     *
     * @return list<string>
     */
    public function getRequiredFields(): array
    {
        return [];
    }

    /**
     * Validate the schema.
     *
     * Raw schemas are free-form, so no required-field validation applies.
     */
    public function validate(): void
    {
        // No-op: free-form JSON is not subject to schema validation.
    }

    /**
     * Render the schema as JSON.
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
     * Render the schema as an HTML script tag.
     */
    public function render(): string
    {
        $renderer = new JsonLdRenderer();

        return $renderer->render($this);
    }
}
