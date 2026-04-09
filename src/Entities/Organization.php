<?php

namespace Asmi\JsonLd\Entities;

class Organization extends AbstractEntity
{
    protected string $schemaType = 'Organization';

    /** @var list<string> */
    protected array $requiredFields = ['name'];

    /**
     * Set organization name.
     */
    public function name(string $name): self
    {
        return $this->set('name', $name);
    }

    /**
     * Set organization URL.
     */
    public function url(string $url): self
    {
        return $this->set('url', $url);
    }

    /**
     * Set organization logo URL.
     */
    public function logo(string $logoUrl): self
    {
        return $this->set('logo', $logoUrl);
    }

    /**
     * Set organization description.
     */
    public function description(string $description): self
    {
        return $this->set('description', $description);
    }

    /**
     * Set organization contact point.
     *
     * @param array<string, mixed> $contactPoint
     */
    public function contactPoint(array $contactPoint): self
    {
        return $this->set('contactPoint', $contactPoint);
    }

    /**
     * Set organization email.
     */
    public function email(string $email): self
    {
        return $this->set('email', $email);
    }

    /**
     * Set organization telephone.
     */
    public function telephone(string $telephone): self
    {
        return $this->set('telephone', $telephone);
    }

    /**
     * Set organization address.
     *
     * @param array<string, mixed>|string $address
     */
    public function address(array|string $address): self
    {
        return $this->set('address', $address);
    }

    /**
     * Set organization location.
     *
     * @param array<string, mixed>|string $location
     */
    public function location(array|string $location): self
    {
        return $this->set('location', $location);
    }

    /**
     * Set organization sameAs (social media links).
     *
     * @param list<string> $links
     */
    public function sameAs(array $links): self
    {
        return $this->set('sameAs', $links);
    }
}
