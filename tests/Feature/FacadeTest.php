<?php

namespace Asmi\JsonLd\Tests\Feature;

use Asmi\JsonLd\Exceptions\ValidationException;
use Asmi\JsonLd\Facades\JsonLd;
use Asmi\JsonLd\Tests\TestCase;

class FacadeTest extends TestCase
{
    public function test_facade_person_fluent_api(): void
    {
        $person = JsonLd::person()
            ->name('John Doe')
            ->jobTitle('Developer')
            ->email('john@example.com');

        $this->assertEquals('John Doe', $person->get('name'));
        $this->assertEquals('Developer', $person->get('jobTitle'));
    }

    public function test_facade_person_make_factory(): void
    {
        $person = JsonLd::make('Person', [
            'name' => 'John Doe',
            'jobTitle' => 'Developer',
        ]);

        $this->assertEquals('John Doe', $person->get('name'));
        $this->assertEquals('Developer', $person->get('jobTitle'));
    }

    public function test_facade_organization(): void
    {
        $org = JsonLd::organization()
            ->name('Acme Corp')
            ->url('https://acme.com');

        $renderered = $org->render();
        
        $this->assertStringContainsString('Organization', $renderered);
        $this->assertStringContainsString('Acme Corp', $renderered);
    }

    public function test_facade_article(): void
    {
        $article = JsonLd::article()
            ->headline('Test Article')
            ->datePublished('2026-04-09');

        $this->assertStringContainsString('Article', $article->render());
    }

    public function test_facade_product(): void
    {
        $product = JsonLd::product()
            ->name('Product Name')
            ->price(10.99)
            ->priceCurrency('USD');

        $rendered = $product->render();
        
        $this->assertStringContainsString('Product', $rendered);
        $this->assertStringContainsString('10.99', $rendered);
    }

    public function test_facade_website(): void
    {
        $website = JsonLd::website()
            ->name('My Site')
            ->url('https://example.com');

        $rendered = $website->render();
        
        $this->assertStringContainsString('WebSite', $rendered);
        $this->assertStringContainsString('https://example.com', $rendered);
    }

    public function test_make_with_invalid_type_throws_exception(): void
    {
        $this->expectException(\Asmi\JsonLd\Exceptions\JsonLdException::class);
        JsonLd::make('InvalidType');
    }

    public function test_strict_validation_fails(): void
    {
        $this->expectException(ValidationException::class);

        $person = JsonLd::person();
        $person->render();
    }
}
