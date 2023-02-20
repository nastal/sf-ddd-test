<?php

declare(strict_types=1);

namespace App\Template\Domain\Model;


use App\Shared\Domain\Entity\Type;
use App\Shared\Domain\Service\UlidService;

class Template
{
    protected string $uuid;

    protected Content $content;

    protected Type $slug;

    private function __construct(Content $content, Type $slug)
    {
        $this->uuid = UlidService::generate();
        $this->content = $content;
        $this->slug = $slug;
    }

    public function getContent(): Content
    {
        return $this->content;
    }

    public function getSlug(): Type
    {
        return $this->slug;
    }

}
