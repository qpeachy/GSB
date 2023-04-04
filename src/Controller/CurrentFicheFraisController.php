<?php

namespace App\Controller;

use App\Entity\FicheFrais;
use App\Form\CurrentFicheFraisType;
use App\Form\FicheFraisType;
use App\Form\LigneFFType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Constraints\Date;

class CurrentFicheFraisController extends AbstractController
{
    #[Route('/current', name: 'app_current')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        // usually you'll want to make sure the user is authenticated first,
        // see "Authorization" below
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        //get current YearMonth
        $currentMonth = date('Ym');

        //get FF of $currentMonth
        $currentFF = $doctrine->getRepository(FicheFrais::class)->findBy(['mois' => $currentMonth, 'user' => $user]);

        //verify that the FF exists, if not create FF
        if($currentFF == null){ $currentFF = new FicheFrais(); }

        //create from
        $formLigneFF = $this->createForm(LigneFFType::class);
        $formLigneFF->handleRequest($request);

        //When form is validated
        if ($formLigneFF->isSubmitted() && $formLigneFF->isValid()) {

        }

        return $this->render('current_fiche_frais/index.html.twig', [

            ]);
    }
}
