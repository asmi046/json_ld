<?php

namespace Asmi\JsonLd\Entities;

class TravelAgency extends LocalBusiness
{
    protected string $schemaType = 'TravelAgency';

    /**
     * Set area served by the agency.
     *
     * @param list<string>|string $areaServed
     */
    public function areaServed(array|string $areaServed): self
    {
        return $this->set('areaServed', $areaServed);
    }

    /**
     * Set travel service type.
     */
    public function serviceType(string $serviceType): self
    {
        return $this->set('serviceType', $serviceType);
    }
}
