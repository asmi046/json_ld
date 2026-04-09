<?php

namespace Asmi\JsonLd\Entities;

class WebSite extends AbstractEntity
{
    protected string $schemaType = 'WebSite';

    /** @var list<string> */
    protected array $requiredFields = ['name', 'url'];

    /**
     * Set website name.
     */
    public function name(string $name): self
    {
        return $this->set('name', $name);
    }

    /**
     * Set website URL.
     */
    public function url(string $url): self
    {
        return $this->set('url', $url);
    }

    /**
     * Set website description.
     */
    public function description(string $description): self
    {
        return $this->set('description', $description);
    }

    /**
     * Set website image URL.
     */
    public function image(string $imageUrl): self
    {
        return $this->set('image', $imageUrl);
    }

    /**
     * Set website logo.
     */
    public function logo(string $logoUrl): self
    {
        return $this->set('logo', $logoUrl);
    }

    /**
     * Set website language.
     */
    public function language(string $language): self
    {
        return $this->set('language', $language);
    }

    /**
     * Set website potentialAction (search action).
     *
     * @param array<string, mixed> $action
     */
    public function potentialAction(array $action): self
    {
        return $this->set('potentialAction', $action);
    }

    /**
     * Set website copyright holder.
     */
    public function copyrightHolder(Organization|Person|string $holder): self
    {
        if ($holder instanceof Organization || $holder instanceof Person) {
            $holder = $holder->toArray();
        }
        return $this->set('copyrightHolder', $holder);
    }

    /**
     * Set website author.
     */
    public function author(Organization|Person|string $author): self
    {
        if ($author instanceof Organization || $author instanceof Person) {
            $author = $author->toArray();
        }
        return $this->set('author', $author);
    }
}
