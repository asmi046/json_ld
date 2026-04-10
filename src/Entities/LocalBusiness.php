<?php

namespace Asmi\JsonLd\Entities;

class LocalBusiness extends Organization
{
    protected string $schemaType = 'LocalBusiness';

    /**
     * Set local business opening hours.
     */
    public function openingHours(string $hours): self
    {
        return $this->set('openingHours', $hours);
    }

    /**
     * Set local business price range.
     */
    public function priceRange(string $priceRange): self
    {
        return $this->set('priceRange', $priceRange);
    }

    /**
     * Set local business geo coordinates.
     *
     * @param array<string, mixed> $geo
     */
    public function geo(array $geo): self
    {
        return $this->set('geo', $geo);
    }

    /**
     * Set local business payment accepted methods.
     *
     * @param list<string>|string $paymentAccepted
     */
    public function paymentAccepted(array|string $paymentAccepted): self
    {
        return $this->set('paymentAccepted', $paymentAccepted);
    }
}
