<?php

namespace Asmi\JsonLd\Entities;

class Article extends AbstractEntity
{
    protected string $schemaType = 'Article';

    /** @var list<string> */
    protected array $requiredFields = ['headline', 'datePublished'];

    /**
     * Set article headline.
     */
    public function headline(string $headline): self
    {
        return $this->set('headline', $headline);
    }

    /**
     * Set article description.
     */
    public function description(string $description): self
    {
        return $this->set('description', $description);
    }

    /**
     * Set article image URL.
     */
    public function image(string $imageUrl): self
    {
        return $this->set('image', $imageUrl);
    }

    /**
     * Set article author.
        *
        * @param Person|Organization|array<string, mixed> $author
     */
    public function author(Person|Organization|array $author): self
    {
        if ($author instanceof Person || $author instanceof Organization) {
            $author = $author->toArray();
        }
        return $this->set('author', $author);
    }

    /**
     * Set article published date.
     */
    public function datePublished(string $date): self
    {
        return $this->set('datePublished', $date);
    }

    /**
     * Set article modified date.
     */
    public function dateModified(string $date): self
    {
        return $this->set('dateModified', $date);
    }

    /**
     * Set article URL.
     */
    public function url(string $url): self
    {
        return $this->set('url', $url);
    }

    /**
     * Set article article body.
     */
    public function articleBody(string $body): self
    {
        return $this->set('articleBody', $body);
    }

    /**
     * Set article keywords.
     *
     * @param list<string>|string $keywords
     */
    public function keywords(array|string $keywords): self
    {
        return $this->set('keywords', $keywords);
    }

    /**
     * Set article publisher.
     *
     * @param Organization|array<string, mixed> $publisher
     */
    public function publisher(Organization|array $publisher): self
    {
        if ($publisher instanceof Organization) {
            $publisher = $publisher->toArray();
        }
        return $this->set('publisher', $publisher);
    }

    /**
     * Set article article section.
     */
    public function articleSection(string $section): self
    {
        return $this->set('articleSection', $section);
    }
}
