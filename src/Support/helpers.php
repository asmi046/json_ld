<?php

/**
 * Create a Person JSON-LD entity.
 *
 * @param array<string, mixed> $data
 */
function jsonld_person(array $data = []): \Asmi\JsonLd\Entities\Person
{
    return \Asmi\JsonLd\Facades\JsonLd::person($data);
}

/**
 * Create an Organization JSON-LD entity.
 *
 * @param array<string, mixed> $data
 */
function jsonld_organization(array $data = []): \Asmi\JsonLd\Entities\Organization
{
    return \Asmi\JsonLd\Facades\JsonLd::organization($data);
}

/**
 * Create an Article JSON-LD entity.
 *
 * @param array<string, mixed> $data
 */
function jsonld_article(array $data = []): \Asmi\JsonLd\Entities\Article
{
    return \Asmi\JsonLd\Facades\JsonLd::article($data);
}

/**
 * Create a Product JSON-LD entity.
 *
 * @param array<string, mixed> $data
 */
function jsonld_product(array $data = []): \Asmi\JsonLd\Entities\Product
{
    return \Asmi\JsonLd\Facades\JsonLd::product($data);
}

/**
 * Create a WebSite JSON-LD entity.
 *
 * @param array<string, mixed> $data
 */
function jsonld_website(array $data = []): \Asmi\JsonLd\Entities\WebSite
{
    return \Asmi\JsonLd\Facades\JsonLd::website($data);
}

/**
 * Create a LocalBusiness JSON-LD entity.
 *
 * @param array<string, mixed> $data
 */
function jsonld_local_business(array $data = []): \Asmi\JsonLd\Entities\LocalBusiness
{
    return \Asmi\JsonLd\Facades\JsonLd::localBusiness($data);
}

/**
 * Create a TravelAgency JSON-LD entity.
 *
 * @param array<string, mixed> $data
 */
function jsonld_travel_agency(array $data = []): \Asmi\JsonLd\Entities\TravelAgency
{
    return \Asmi\JsonLd\Facades\JsonLd::travelAgency($data);
}

/**
 * Create a JSON-LD entity by type name.
 *
 * @param array<string, mixed> $data
 */
function jsonld_make(string $type, array $data = []): mixed
{
    return \Asmi\JsonLd\Facades\JsonLd::make($type, $data);
}
