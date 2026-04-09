<?php

namespace Asmi\JsonLd\Entities;

class Person extends AbstractEntity
{
    protected string $schemaType = 'Person';

    /** @var list<string> */
    protected array $requiredFields = ['name'];

    /**
     * Set person name.
     */
    public function name(string $name): self
    {
        return $this->set('name', $name);
    }

    /**
     * Set person email.
     */
    public function email(string $email): self
    {
        return $this->set('email', $email);
    }

    /**
     * Set person job title.
     */
    public function jobTitle(string $jobTitle): self
    {
        return $this->set('jobTitle', $jobTitle);
    }

    /**
     * Set person URL.
     */
    public function url(string $url): self
    {
        return $this->set('url', $url);
    }

    /**
     * Set person image URL.
     */
    public function image(string $imageUrl): self
    {
        return $this->set('image', $imageUrl);
    }

    /**
     * Set person telephone.
     */
    public function telephone(string $telephone): self
    {
        return $this->set('telephone', $telephone);
    }

    /**
     * Set person description.
     */
    public function description(string $description): self
    {
        return $this->set('description', $description);
    }

    /**
     * Set person affiliation (Organization).
     */
    public function affiliation(Organization $organization): self
    {
        return $this->set('affiliation', $organization->toArray());
    }

    /**
     * Set person address.
     *
     * @param array<string, mixed>|string $address
     */
    public function address(array|string $address): self
    {
        return $this->set('address', $address);
    }
}
