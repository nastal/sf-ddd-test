<?php

declare(strict_types=1);

namespace App\Template\Domain\Model;

class Template
{

    protected Content $content;
    protected Slug $slug;

    public function __construct(Content $content, Slug $slug)
    {
        $this->content = $content;
        $this->slug = $slug;
    }

    public function getContent(): Content
    {
        return $this->content;
    }

    public function getSlug(): Slug
    {
        return $this->slug;
    }

}
