<?php

namespace Asmi\JsonLd\Tests\Unit;

use Asmi\JsonLd\Entities\RawSchema;
use Asmi\JsonLd\Exceptions\JsonLdException;
use Asmi\JsonLd\Facades\JsonLd;
use Asmi\JsonLd\Tests\TestCase;

class RawSchemaTest extends TestCase
{
    public function test_raw_schema_renders_valid_json_object(): void
    {
        $json = '{"@context":"https://schema.org","@type":"FAQPage","name":"Test"}';

        $rendered = (new RawSchema($json))->render();

        $this->assertStringContainsString('<script type="application/ld+json">', $rendered);
        $this->assertStringContainsString('"FAQPage"', $rendered);
        $this->assertStringContainsString('"Test"', $rendered);
    }

    public function test_raw_schema_preserves_context_and_type(): void
    {
        $schema = new RawSchema('{"@context":"https://schema.org","@type":"Person","name":"John"}');

        $this->assertSame('https://schema.org', $schema->getContext());
        $this->assertSame('Person', $schema->getType());
    }

    public function test_raw_schema_has_no_required_fields(): void
    {
        $schema = new RawSchema('{}');

        $this->assertSame([], $schema->getRequiredFields());
    }

    public function test_raw_schema_to_array_returns_decoded_data(): void
    {
        $schema = new RawSchema('{"@type":"Product","name":"Widget","price":9.99}');

        $array = $schema->toArray();

        $this->assertSame('Widget', $array['name']);
        $this->assertSame(9.99, $array['price']);
        $this->assertSame('Product', $schema->getProperties()['@type']);
    }

    public function test_raw_schema_to_json_normalizes_content(): void
    {
        $schema = new RawSchema('{ "@type" : "Person" , "name":"John" }');

        $json = $schema->toJson();

        $this->assertStringNotContainsString(' ', $json);
        $this->assertStringContainsString('"@type":"Person"', $json);
        $this->assertStringContainsString('"name":"John"', $json);
    }

    public function test_raw_schema_to_json_respects_pretty_print(): void
    {
        config(['jsonld.pretty_print' => true]);

        $json = (new RawSchema('{"@type":"Person","name":"John"}'))->toJson();

        $this->assertStringContainsString("\n", $json);
    }

    public function test_raw_schema_set_get_has_mutators(): void
    {
        $schema = new RawSchema('{"name":"John"}');

        $this->assertTrue($schema->has('name'));
        $this->assertSame('John', $schema->get('name'));
        $this->assertFalse($schema->has('missing'));

        $schema->set('jobTitle', 'Developer');

        $this->assertTrue($schema->has('jobTitle'));
        $this->assertSame('Developer', $schema->get('jobTitle'));
    }

    public function test_raw_schema_escape_mode_escapes_html_breaking_chars(): void
    {
        config(['jsonld.escape_mode' => 'json_encode']);

        $rendered = (new RawSchema('{"@type":"Person","name":"a<b>c"}'))->render();

        $this->assertStringContainsString('\u003C', $rendered);
        $this->assertStringNotContainsString('a<b>c', $rendered);
    }

    public function test_raw_schema_invalid_json_throws_exception(): void
    {
        $this->expectException(JsonLdException::class);
        $this->expectExceptionMessage('Invalid JSON-LD string');

        new RawSchema('{invalid json');
    }

    public function test_raw_schema_empty_string_throws_exception(): void
    {
        $this->expectException(JsonLdException::class);

        new RawSchema('');
    }

    public function test_raw_schema_json_scalar_throws_exception(): void
    {
        $this->expectException(JsonLdException::class);
        $this->expectExceptionMessage('JSON-LD must be a JSON object.');

        new RawSchema('"just a string"');
    }

    public function test_raw_schema_json_null_throws_exception(): void
    {
        $this->expectException(JsonLdException::class);
        $this->expectExceptionMessage('JSON-LD must be a JSON object.');

        new RawSchema('null');
    }

    public function test_raw_schema_json_list_throws_exception(): void
    {
        $this->expectException(JsonLdException::class);
        $this->expectExceptionMessage('JSON-LD must be a JSON object.');

        new RawSchema('[1,2,3]');
    }

    public function test_raw_schema_empty_object_is_allowed(): void
    {
        $schema = new RawSchema('{}');

        $this->assertSame([], $schema->toArray());
        $this->assertStringContainsString('<script type="application/ld+json">', $schema->render());
    }

    public function test_raw_schema_validate_is_noop_and_never_throws(): void
    {
        config(['jsonld.strict' => true]);

        $schema = new RawSchema('{}');

        $schema->validate();

        $this->expectNotToPerformAssertions();
    }

    public function test_facade_raw_returns_raw_schema(): void
    {
        $schema = JsonLd::raw('{"@type":"Person","name":"John"}');

        $this->assertInstanceOf(RawSchema::class, $schema);
        $this->assertSame('Person', $schema->getType());
    }

    public function test_helper_jsonld_raw_returns_raw_schema(): void
    {
        $schema = jsonld_raw('{"@type":"WebSite","name":"Site"}');

        $this->assertInstanceOf(RawSchema::class, $schema);
        $this->assertSame('WebSite', $schema->getType());
    }
}
