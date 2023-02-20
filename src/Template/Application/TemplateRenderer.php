<?php

namespace App\Template\Application;

use App\Template\Domain\Model\Content;
use App\Template\Domain\Model\Slug;
use App\Template\Domain\Model\Template;
use App\Template\Infrastructure\Doctrine\Entity\DoctrineTemplate;
use App\Template\Infrastructure\Doctrine\Repository\TemplateRepository;

class TemplateRenderer
{
    public function __construct(private readonly TemplateRepository $templateRepository)
    {
    }

    public function render(string $slug): Template
    {
        $template = $this->templateRepository->findOneBy(['slug' => $slug]);

        if (!$template instanceof DoctrineTemplate) {
            throw new \Exception('Template not found');
        }

        $content = new Content($template->getContent());
        $slug = new Slug($template->getSlug(), $template->getContentType());

        return new Template($content, $slug);

    }
}