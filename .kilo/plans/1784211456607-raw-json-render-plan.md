# Plan: Raw/free-form JSON-LD rendering (`JsonLd::raw()`)

## Goal
Add a function that accepts an arbitrary JSON string and renders it as a JSON-LD
`<script type="application/ld+json">…</script>` tag, consistent with the existing
entity pipeline. Input content is preserved; formatting is normalized through the
package's JSON pipeline (re-encoded applying `pretty_print`).

## Confirmed decisions
1. **Output = Normalized.** Decode the input, then re-encode via the same logic as
   `AbstractEntity::toJson()` (default flags `JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE`
   plus `JSON_PRETTY_PRINT` when `config('jsonld.pretty_print')`). `escape_mode` from
   config is applied by the existing `JsonLdRenderer`.
2. **API = Renderable object.** `JsonLd::raw(string $json)` returns a `RawSchema`
   instance implementing `RenderableJsonLdInterface`, so it works with the current
   `@jsonld()` Blade directive and supports `->render()` / `->toJson()` / `->toArray()`.
3. **Validation = JSON validity only.** Decode with `JSON_THROW_ON_ERROR`; on failure
   throw `JsonLdException`. No strict schema validation (no required fields). The
   decoded value must be a JSON **object** (associative array); scalars/arrays/null
   are rejected with `JsonLdException`.

## Naming (chosen)
- Manager/facade method: `raw(string $json): RawSchema`
- Helper function: `jsonld_raw(string $json): RawSchema`
- Class: `Asmi\JsonLd\Entities\RawSchema`

## Tasks (ordered)

### 1. Create `src/Entities/RawSchema.php`
- Implements `Asmi\JsonLd\Contracts\RenderableJsonLdInterface` (which extends
  `SchemaEntityInterface` + `EntityBuilderInterface`).
- Constructor `__construct(string $json)`:
  - `$decoded = json_decode($json, true, 512, JSON_THROW_ON_ERROR);` wrapped in
    `try/catch (\JsonException)` → rethrow as
    `new JsonLdException('Invalid JSON-LD string: ' . $e->getMessage())`.
  - If `!is_array($decoded)` or `array_is_list($decoded)` (i.e. not an associative
    object map) → throw `JsonLdException('JSON-LD must be a JSON object.')`.
    (Use `is_array($decoded) && (!empty($decoded) ? !array_is_list($decoded) : true)`
     to allow `{}`.)
  - Store `$this->data = $decoded;`.
- Methods (honest minimal implementations):
  - `toArray(): array` → return `$this->data` (already contains whatever `@context`
    / `@type` the user supplied; package does NOT inject them).
  - `toJson(int $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE): string`
    → mirror `AbstractEntity::toJson()`: apply `pretty_print` from config, `json_encode`,
    throw `JsonLdException('Failed to encode JSON-LD payload.')` on failure.
  - `render(): string` → `$renderer = new JsonLdRenderer(); return $renderer->render($this);`
    (do NOT call `$this->validate()` — no schema validation for raw).
  - `validate(): void` → no-op (raw has no required fields).
  - `getType(): string` → `$this->data['@type']` if it is a string, else `''`.
  - `getContext(): string` → `$this->data['@context']` if it is a string, else `''`.
  - `getProperties(): array` → `$this->data`.
  - `getRequiredFields(): array` → `[]`.
  - `set(string $key, mixed $value): static` → `$this->data[$key] = $value; return $this;`.
  - `get(string $key): mixed` → `$this->data[$key] ?? null`.
  - `has(string $key): bool` → `isset($this->data[$key])`.

### 2. Register in `src/JsonLdManager.php`
- Add `use Asmi\JsonLd\Entities\RawSchema;`.
- Add method:
  ```php
  public function raw(string $json): RawSchema
  {
      return new RawSchema($json);
  }
  ```

### 3. Facade `src/Facades/JsonLd.php`
- Add PHPDoc `@method static \Asmi\JsonLd\Entities\RawSchema raw(string $json)`.

### 4. Helper `src/Support/helpers.php`
- Append:
  ```php
  function jsonld_raw(string $json): \Asmi\JsonLd\Entities\RawSchema
  {
      return \Asmi\JsonLd\Facades\JsonLd::raw($json);
  }
  ```

### 5. No change needed to Blade directive
- `@jsonld()` already renders anything `instanceof RenderableJsonLdInterface`.
  `RawSchema` satisfies that, so `@jsonld(jsonld_raw($json))` works as-is.
  (Deliberately out of scope: accepting a raw string directly in `@jsonld()`.)

### 6. README.md — add a short "Raw / free-form JSON" section
- Example:
  ```php
  $script = JsonLd::raw('{"@context":"https://schema.org","@type":"FAQPage",...}')->render();
  // or in Blade: @jsonld(jsonld_raw($jsonString))
  ```
- Note: input must be a valid JSON object; content preserved, formatting normalized
  per `pretty_print` config; no strict validation applied.

## Validation / tests
Add `tests/Unit/RawSchemaTest.php`:
- Valid object JSON renders a `<script type="application/ld+json">…</script>` tag and
  preserves provided `@context`/`@type`/fields.
- `toJson()` re-encodes (normalized) and respects `pretty_print` when enabled.
- `toArray()` returns the decoded object.
- Invalid JSON throws `Asmi\JsonLd\Exceptions\JsonLdException`.
- JSON scalar / JSON list / `null` throw `JsonLdException` ("must be a JSON object").
- Facade `JsonLd::raw(...)` and helper `jsonld_raw(...)` return a `RawSchema`.
- `escape_mode` (json_encode) applies: a value containing `<` is emitted as `\u003C`.

Extend `tests/Feature/FacadeTest.php`:
- `test_facade_raw_renders_free_form_json`.

Extend `tests/Feature/BladeDirectiveTest.php`:
- `test_blade_directive_renders_raw_json` via `@jsonld(jsonld_raw($json))`.

Run: `php vendor/bin/phpunit`, then `vendor/bin/phpstan analyse` and
`vendor/bin/pint --test`.

## Risks / notes
- `RawSchema` implements the full `RenderableJsonLdInterface` (incl. builder mutators)
  purely to satisfy the existing directive's `instanceof` check. Mutators (`set/get/has`)
  are provided as honest, functional implementations.
- Package never injects `@context`/`@type` for raw input — the user is fully
  responsible for the structure (this is the point of "free form").
- Existing `AbstractEntity::toJson()` ignores the `json_flags` config value;
  `RawSchema::toJson()` mirrors `AbstractEntity` for consistency (uses the default
  flag set + `pretty_print`), so behavior matches the other entities.
