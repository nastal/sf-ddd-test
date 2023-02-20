<?php

declare(strict_types=1);

namespace App\Template\Domain\Model;

interface TemplateRepositoryInterface
{
    public function findBySlug(string $slug);
}
