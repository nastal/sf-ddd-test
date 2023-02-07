<?php

namespace App\Verification\UI\HTTP;

use App\Shared\Domain\Entity\AgreeablePuppy;
use App\Verification\Domain\Entity\Subject;
use App\Verification\Domain\Entity\Verification;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Verification\Infrastructure\VerificationRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VerificationController extends AbstractController
{

    #[Route('/verification', name: 'verification', methods: ['POST'])]
    public function create(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $entityManager = $doctrine->getManager();

        $parametersAsArray = json_decode($request->getContent(), true);
        dd($parametersAsArray);
        //todo validate parameters or use DTO

        $subjectIdentity = new Subject();

        /*$verificationEntity = new Verification(

        )*/

        $verificationRepository = new VerificationRepository($doctrine);
        $verificationRepository->create();

        $entityManager->persist($verificationRepository);
        $entityManager->flush();

        return $this->json([
            'ss' => 'ss'
        ]);
    }
}
