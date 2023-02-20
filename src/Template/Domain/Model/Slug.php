<?php

namespace App\Template\Domain\Model;
class Slug
{
    private string $slug;

    private string $contentType;

    public function __construct(string $slug, string $contentType)
    {
        $this->slug = $slug;
        $this->contentType = $contentType;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getContentType(): string
    {
        return $this->contentType;
    }

}