<?php

namespace Asmi\JsonLd\Entities;

class TouristTrip extends AbstractEntity
{
    protected string $schemaType = 'TouristTrip';

    /** @var list<string> */
    protected array $requiredFields = ['name'];

    /**
     * Set trip name.
     */
    public function name(string $name): self
    {
        return $this->set('name', $name);
    }

    /**
     * Set trip description.
     */
    public function description(string $description): self
    {
        return $this->set('description', $description);
    }

    /**
     * Set trip start date.
     */
    public function startDate(string $startDate): self
    {
        return $this->set('startDate', $startDate);
    }

    /**
     * Set trip end date.
     */
    public function endDate(string $endDate): self
    {
        return $this->set('endDate', $endDate);
    }

    /**
     * Set trip itinerary.
     *
     * @param list<string>|string $itinerary
     */
    public function itinerary(array|string $itinerary): self
    {
        return $this->set('itinerary', $itinerary);
    }

    /**
     * Set offers for the trip.
     *
     * @param array<string, mixed> $offers
     */
    public function offers(array $offers): self
    {
        return $this->set('offers', $offers);
    }

    /**
     * Set target tourist type.
     *
     * @param list<string>|string $touristType
     */
    public function touristType(array|string $touristType): self
    {
        return $this->set('touristType', $touristType);
    }

    /**
     * Set trip provider.
     *
     * @param Organization|array<string, mixed> $provider
     */
    public function provider(Organization|array $provider): self
    {
        if ($provider instanceof Organization) {
            $provider = $provider->toArray();
        }

        return $this->set('provider', $provider);
    }
}