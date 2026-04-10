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

    public function test_facade_local_business(): void
    {
        $business = JsonLd::localBusiness()
            ->name('Acme Office')
            ->openingHours('Mo-Fr 09:00-18:00')
            ->priceRange('$$');

        $rendered = $business->render();

        $this->assertStringContainsString('LocalBusiness', $rendered);
        $this->assertStringContainsString('Acme Office', $rendered);
    }

    public function test_facade_travel_agency(): void
    {
        $agency = JsonLd::travelAgency()
            ->name('Sky Tours')
            ->serviceType('International tours');

        $rendered = $agency->render();

        $this->assertStringContainsString('TravelAgency', $rendered);
        $this->assertStringContainsString('Sky Tours', $rendered);
    }

    public function test_facade_tourist_trip(): void
    {
        $trip = JsonLd::touristTrip()
            ->name('Golden Ring Weekend')
            ->startDate('2026-06-01')
            ->endDate('2026-06-03');

        $rendered = $trip->render();

        $this->assertStringContainsString('TouristTrip', $rendered);
        $this->assertStringContainsString('Golden Ring Weekend', $rendered);
    }

    public function test_facade_make_local_business(): void
    {
        $business = JsonLd::make('LocalBusiness', [
            'name' => 'Acme Office',
            'openingHours' => 'Mo-Fr 09:00-18:00',
        ]);

        $this->assertEquals('LocalBusiness', $business->getType());
        $this->assertEquals('Acme Office', $business->get('name'));
    }

    public function test_facade_make_travel_agency(): void
    {
        $agency = JsonLd::make('TravelAgency', [
            'name' => 'Sky Tours',
            'serviceType' => 'International tours',
        ]);

        $this->assertEquals('TravelAgency', $agency->getType());
        $this->assertEquals('Sky Tours', $agency->get('name'));
    }

    public function test_facade_make_tourist_trip(): void
    {
        $trip = JsonLd::make('TouristTrip', [
            'name' => 'Golden Ring Weekend',
            'startDate' => '2026-06-01',
        ]);

        $this->assertEquals('TouristTrip', $trip->getType());
        $this->assertEquals('Golden Ring Weekend', $trip->get('name'));
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
