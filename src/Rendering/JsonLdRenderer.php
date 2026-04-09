<?php

namespace Asmi\JsonLd\Rendering;

use Asmi\JsonLd\Contracts\RenderableJsonLdInterface;

class JsonLdRenderer
{
    /**
     * Render a JSON-LD entity as an HTML script tag.
     */
    public function render(RenderableJsonLdInterface $entity): string
    {
        $json = $entity->toJson();

        $escapeMode = config('jsonld.escape_mode', 'json_encode');
        $content = match ($escapeMode) {
            'none' => $json,
            'json_encode' => $this->escapeForScriptTag($json),
            'htmlspecialchars' => htmlspecialchars($json, ENT_QUOTES, 'UTF-8'),
            default => $json,
        };

        return sprintf(
            '<script type="application/ld+json">%s</script>',
            $content
        );
    }

    /**
     * Escape characters that can prematurely break the script tag.
     */
    protected function escapeForScriptTag(string $json): string
    {
        return str_replace(
            ['<', '>', '&', "'"],
            ['\\u003C', '\\u003E', '\\u0026', '\\u0027'],
            $json
        );
    }
}
