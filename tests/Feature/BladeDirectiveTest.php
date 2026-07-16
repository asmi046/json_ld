<?php

namespace Asmi\JsonLd\Tests\Feature;

use Asmi\JsonLd\Facades\JsonLd;
use Asmi\JsonLd\Tests\TestCase;
use Illuminate\Support\Facades\Blade;

class BladeDirectiveTest extends TestCase
{
    public function test_blade_directive_renders_json_ld(): void
    {
        $compiled = Blade::compileString('@jsonld($person)');

        $this->assertStringContainsString('instanceof', $compiled);
        $this->assertStringContainsString('render()', $compiled);
    }

    public function test_blade_directive_handles_null_without_failing(): void
    {
        $compiled = Blade::compileString('@jsonld($entity)');

        $entity = null;
        ob_start();
        eval('?>' . $compiled);
        $output = ob_get_clean();

        $this->assertSame('', $output);
    }

    public function test_blade_directive_renders_entity_output(): void
    {
        $compiled = Blade::compileString('@jsonld($entity)');

        $entity = JsonLd::person()
            ->name('John Doe')
            ->jobTitle('Developer');

        ob_start();
        eval('?>' . $compiled);
        $output = ob_get_clean();

        $this->assertStringContainsString('<script type="application/ld+json">', $output);
        $this->assertStringContainsString('John Doe', $output);
    }

    public function test_blade_directive_renders_raw_json(): void
    {
        $compiled = Blade::compileString('@jsonld(jsonld_raw($json))');

        $json = '{"@context":"https://schema.org","@type":"WebPage","name":"Page"}';

        ob_start();
        eval('?>' . $compiled);
        $output = ob_get_clean();

        $this->assertStringContainsString('<script type="application/ld+json">', $output);
        $this->assertStringContainsString('"WebPage"', $output);
        $this->assertStringContainsString('"Page"', $output);
    }
}
