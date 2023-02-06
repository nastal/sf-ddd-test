<?php

namespace App\Shared\Infrastructure\Controller;

use App\Shared\Domain\Entity\AgreeablePuppy;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PyppyController extends AbstractController
{
    #[Route('/controller/pyppy', name: 'app_controller_pyppy')]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {

        $entityManager = $doctrine->getManager();

        $puppy = new AgreeablePuppy();
        $puppy->setName('Nani');

        $entityManager->persist($puppy);
        $entityManager->flush();

        return $this->json([
            'message' => 'Puppy ' . $puppy->getName() . ' is saved',
            'id' => $puppy->getId(),
        ]);
    }
}
