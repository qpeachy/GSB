<?php

namespace App\Controller;

use App\Entity\FicheFrais;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FicheFraisController extends AbstractController
{
    #[Route('/ficheFrais', name: 'app_fiche_frais')]
    public function index(ManagerRegistry $doctrine): Response
    {
        // usually you'll want to make sure the user is authenticated first,
        // see "Authorization" below
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $repository = $doctrine->getRepository(FicheFrais::class);
        $fichesfrais = $repository->findBy(['user'=>$user]);

        return $this->render('fiche_frais/index.html.twig', [
            'controller_name' => 'FicheFraisController',
            'user' => $user,
            'fichesfrais' => $fichesfrais,
        ]);
    }
}
