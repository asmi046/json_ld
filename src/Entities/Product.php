<?php

namespace Asmi\JsonLd\Entities;

class Product extends AbstractEntity
{
    protected string $schemaType = 'Product';

    /** @var list<string> */
    protected array $requiredFields = ['name'];

    /**
     * Set product name.
     */
    public function name(string $name): self
    {
        return $this->set('name', $name);
    }

    /**
     * Set product description.
     */
    public function description(string $description): self
    {
        return $this->set('description', $description);
    }

    /**
     * Set product image URL.
     */
    public function image(string $imageUrl): self
    {
        return $this->set('image', $imageUrl);
    }

    /**
     * Set product brand.
     */
    public function brand(Organization|string $brand): self
    {
        if ($brand instanceof Organization) {
            $brand = $brand->toArray();
        }
        return $this->set('brand', $brand);
    }

    /**
     * Set product price.
     */
    public function price(float|int $price): self
    {
        return $this->set('price', $price);
    }

    /**
     * Set product price currency.
     */
    public function priceCurrency(string $currency): self
    {
        return $this->set('priceCurrency', $currency);
    }

    /**
     * Set product URL.
     */
    public function url(string $url): self
    {
        return $this->set('url', $url);
    }

    /**
     * Set product availability.
     */
    public function availability(string $availability): self
    {
        return $this->set('availability', $availability);
    }

    /**
     * Set product rating.
     *
     * @param array<string, mixed> $rating
     */
    public function rating(array $rating): self
    {
        return $this->set('rating', $rating);
    }

    /**
     * Set product review.
     *
     * @param array<string, mixed> $review
     */
    public function review(array $review): self
    {
        return $this->set('review', $review);
    }

    /**
     * Set product manufacturer.
     */
    public function manufacturer(Organization|string $manufacturer): self
    {
        if ($manufacturer instanceof Organization) {
            $manufacturer = $manufacturer->toArray();
        }
        return $this->set('manufacturer', $manufacturer);
    }

    /**
     * Set product SKU.
     */
    public function sku(string $sku): self
    {
        return $this->set('sku', $sku);
    }
}
