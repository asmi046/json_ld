<?php

namespace Asmi\JsonLd\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Asmi\JsonLd\Entities\Person person(array $data = [])
 * @method static \Asmi\JsonLd\Entities\Organization organization(array $data = [])
 * @method static \Asmi\JsonLd\Entities\Article article(array $data = [])
 * @method static \Asmi\JsonLd\Entities\Product product(array $data = [])
 * @method static \Asmi\JsonLd\Entities\WebSite website(array $data = [])
 * @method static \Asmi\JsonLd\Entities\LocalBusiness localBusiness(array $data = [])
 * @method static \Asmi\JsonLd\Entities\TravelAgency travelAgency(array $data = [])
 * @method static mixed make(string $type, array $data = [])
 */
class JsonLd extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'jsonld';
    }
}
