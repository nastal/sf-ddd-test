<?php

namespace App\Template\UI\HTTP;

use App\Template\Application\TemplateRenderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TemplateController extends AbstractController
{
    public function __construct(private readonly TemplateRenderer $templateRenderer)
    {
    }

    #[Route('/templates/render', name: 'template', methods: ['POST'])]
    public function getTemplate(Request $request)
    {
        //fixme make validation
        $content = json_decode($request->getContent(), true);

        //fixme output as described in doc
        try {
            $templateRender = $this->templateRenderer->render($content['slug']);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], 404);
        }

        $body = $templateRender->getContent()->renderCode($content['variables']['code']);

        $response = new Response($body);
        $response->headers->set('Content-Type', $templateRender->getSlug()->getContentType());

        return $response;
    }
}