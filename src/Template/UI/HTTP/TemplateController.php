<?php

namespace App\Template\UI\HTTP;

use App\Template\Infrastructure\Doctrine\Repository\TemplateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\HandleTrait;

class TemplateController extends AbstractController
{
    public function __construct(private readonly TemplateRepository $templateRepository)
    {
    }

    #[Route('/templates/render', name: 'template', methods: ['POST'])]
    public function redner(Request $request)
    {

        //fixme make validation
        $content = json_decode($request->getContent(), true);

        //fixme output as described in doc
        try {
            $template = $this->templateRepository->findBySlug($content['slug']);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], 404);
        }

        return $this->json(['message' => $template->getContent()]);
    }
}