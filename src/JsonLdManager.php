<?php

namespace Asmi\JsonLd;

use Asmi\JsonLd\Entities\Article;
use Asmi\JsonLd\Entities\LocalBusiness;
use Asmi\JsonLd\Entities\Organization;
use Asmi\JsonLd\Entities\Person;
use Asmi\JsonLd\Entities\Product;
use Asmi\JsonLd\Entities\TouristTrip;
use Asmi\JsonLd\Entities\TravelAgency;
use Asmi\JsonLd\Entities\WebSite;
use Asmi\JsonLd\Exceptions\JsonLdException;

class JsonLdManager
{
    /**
     * Create a Person entity.
    *
    * @param array<string, mixed> $data
     */
    public function person(array $data = []): Person
    {
        return new Person($data);
    }

    /**
     * Create an Organization entity.
        *
        * @param array<string, mixed> $data
     */
    public function organization(array $data = []): Organization
    {
        return new Organization($data);
    }

    /**
     * Create an Article entity.
        *
        * @param array<string, mixed> $data
     */
    public function article(array $data = []): Article
    {
        return new Article($data);
    }

    /**
     * Create a Product entity.
        *
        * @param array<string, mixed> $data
     */
    public function product(array $data = []): Product
    {
        return new Product($data);
    }

    /**
     * Create a WebSite entity.
        *
        * @param array<string, mixed> $data
     */
    public function website(array $data = []): WebSite
    {
        return new WebSite($data);
    }

    /**
     * Create a LocalBusiness entity.
     *
     * @param array<string, mixed> $data
     */
    public function localBusiness(array $data = []): LocalBusiness
    {
        return new LocalBusiness($data);
    }

    /**
     * Create a TravelAgency entity.
     *
     * @param array<string, mixed> $data
     */
    public function travelAgency(array $data = []): TravelAgency
    {
        return new TravelAgency($data);
    }

    /**
     * Create a TouristTrip entity.
     *
     * @param array<string, mixed> $data
     */
    public function touristTrip(array $data = []): TouristTrip
    {
        return new TouristTrip($data);
    }

    /**
     * Create an entity by type name.
        *
        * @param array<string, mixed> $data
     */
    public function make(string $type, array $data = []): mixed
    {
        return match (strtolower($type)) {
            'person' => $this->person($data),
            'organization' => $this->organization($data),
            'article' => $this->article($data),
            'product' => $this->product($data),
            'website' => $this->website($data),
            'localbusiness' => $this->localBusiness($data),
            'travelagency' => $this->travelAgency($data),
            'touristtrip' => $this->touristTrip($data),
            default => throw new JsonLdException("Unsupported entity type: {$type}"),
        };
    }
}
