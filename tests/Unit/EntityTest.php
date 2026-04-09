<?php

namespace Asmi\JsonLd\Tests\Unit;

use Asmi\JsonLd\Entities\Article;
use Asmi\JsonLd\Entities\Organization;
use Asmi\JsonLd\Entities\Person;
use Asmi\JsonLd\Entities\Product;
use Asmi\JsonLd\Entities\WebSite;
use Asmi\JsonLd\Exceptions\ValidationException;
use Asmi\JsonLd\Tests\TestCase;

class EntityTest extends TestCase
{
    public function test_person_entity_can_be_created(): void
    {
        $person = new Person();
        $person->name('John Doe')->jobTitle('Developer');

        $this->assertEquals('Person', $person->getType());
        $this->assertEquals('John Doe', $person->get('name'));
        $this->assertEquals('Developer', $person->get('jobTitle'));
    }

    public function test_person_render_html_script_tag(): void
    {
        $person = new Person()
            ->name('John Doe')
            ->jobTitle('Developer');

        $rendered = $person->render();

        $this->assertStringContainsString('<script type="application/ld+json">', $rendered);
        $this->assertStringContainsString('Person', $rendered);
        $this->assertStringContainsString('John Doe', $rendered);
    }

    public function test_person_validation_fails_without_required_name(): void
    {
        $this->expectException(ValidationException::class);
        
        $person = new Person();
        $person->jobTitle('Developer')->render();
    }

    public function test_organization_entity_can_be_created(): void
    {
        $org = new Organization()
            ->name('Acme Corp')
            ->url('https://acme.com')
            ->email('contact@acme.com');

        $this->assertEquals('Organization', $org->getType());
        $this->assertEquals('Acme Corp', $org->get('name'));
        $this->assertEquals('https://acme.com', $org->get('url'));
    }

    public function test_article_entity_can_be_created(): void
    {
        $article = new Article()
            ->headline('My Article')
            ->datePublished('2026-04-09');

        $this->assertEquals('Article', $article->getType());
        $this->assertEquals('My Article', $article->get('headline'));
    }

    public function test_product_entity_can_be_created(): void
    {
        $product = new Product()
            ->name('Awesome Product')
            ->price(99.99)
            ->priceCurrency('USD');

        $this->assertEquals('Product', $product->getType());
        $this->assertEquals('Awesome Product', $product->get('name'));
        $this->assertEquals(99.99, $product->get('price'));
    }

    public function test_website_entity_can_be_created(): void
    {
        $website = new WebSite()
            ->name('My Website')
            ->url('https://example.com');

        $this->assertEquals('WebSite', $website->getType());
        $this->assertEquals('My Website', $website->get('name'));
    }

    public function test_entity_to_array(): void
    {
        $person = new Person()
            ->name('John Doe')
            ->jobTitle('Developer');

        $array = $person->toArray();

        $this->assertArrayHasKey('@context', $array);
        $this->assertArrayHasKey('@type', $array);
        $this->assertArrayHasKey('name', $array);
        $this->assertEquals('https://schema.org', $array['@context']);
        $this->assertEquals('Person', $array['@type']);
        $this->assertEquals('John Doe', $array['name']);
    }

    public function test_entity_to_json(): void
    {
        $person = new Person()
            ->name('John Doe');

        $json = $person->toJson();

        $this->assertIsString($json);
        $this->assertStringContainsString('"@context"', $json);
        $this->assertStringContainsString('"@type"', $json);
        $this->assertStringContainsString('"name"', $json);
    }

    public function test_article_with_author(): void
    {
        $author = new Person()->name('Jane Doe');
        
        $article = new Article()
            ->headline('Article')
            ->datePublished('2026-04-09')
            ->author($author);

        $array = $article->toArray();
        
        $this->assertIsArray($array['author']);
        $this->assertEquals('Jane Doe', $array['author']['name']);
    }

    public function test_null_values_are_filtered(): void
    {
        $person = new Person()
            ->name('John');

        $array = $person->toArray();

        $this->assertArrayNotHasKey('email', $array);
        $this->assertArrayNotHasKey('jobTitle', $array);
    }
}
