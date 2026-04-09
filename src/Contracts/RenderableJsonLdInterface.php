<?php

namespace Asmi\JsonLd\Contracts;

interface RenderableJsonLdInterface extends SchemaEntityInterface, EntityBuilderInterface
{
    /**
     * Render the entity as a JSON-LD script tag.
     */
    public function render(): string;

    /**
     * Render the entity as JSON.
     */
    public function toJson(int $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE): string;
}
