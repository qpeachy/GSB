<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\FicheFrais;
use App\Entity\LigneFraisForfaitise;
use App\Entity\LigneFraisHorsForfait;
use App\Entity\TypeFraisForfait;
use App\Form\LigneFFType;
use App\Form\LigneFHFType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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
        $currentFF = $doctrine->getRepository(FicheFrais::class)->findOneBy(['mois' => $currentMonth, 'user' => $user]);
        //verify that the FF exists, if not create FF
        if($currentFF == null){
            $etat = $doctrine->getRepository(Etat::class)->find(2);
            $currentFF = new FicheFrais();
            $currentFF->setUser($user);
            $currentFF->setMois($currentMonth);
            $currentFF->setNbrJustificatif(0);
            $currentFF->setEtat($etat);
            $currentFF->setDateDerniereModif(new \DateTime());
            $currentFF->setMontantValide(00.0);

            $LFF = new LigneFraisForfaitise();//Creation Ligne Frais Forfaitisé
            $LFF->setTypeFraisForfait($doctrine->getRepository(TypeFraisForfait::class)->find(1));
            $LFF->setQuantite(0);
            $LFF->setFicheFrais($currentFF);
            $currentFF->addLigneFraisForfaitise($LFF);

            $LFF = new LigneFraisForfaitise();//Creation Ligne Frais Forfaitisé
            $LFF->setTypeFraisForfait($doctrine->getRepository(TypeFraisForfait::class)->find(2));
            $LFF->setQuantite(0);
            $LFF->setFicheFrais($currentFF);
            $currentFF->addLigneFraisForfaitise($LFF);

            $LFF = new LigneFraisForfaitise();//Creation Ligne Frais Forfaitisé
            $LFF->setTypeFraisForfait($doctrine->getRepository(TypeFraisForfait::class)->find(3));
            $LFF->setQuantite(0);
            $LFF->setFicheFrais($currentFF);
            $currentFF->addLigneFraisForfaitise($LFF);

            $LFF = new LigneFraisForfaitise();//Creation Ligne Frais Forfaitisé
            $LFF->setTypeFraisForfait($doctrine->getRepository(TypeFraisForfait::class)->find(4));
            $LFF->setQuantite(0);
            $LFF->setFicheFrais($currentFF);
            $currentFF->addLigneFraisForfaitise($LFF);

            $doctrine->getManager()->persist($currentFF);
            $doctrine->getManager()->flush();
        }

        //Create LigneFraisForfaitisé's form and sending lff quantity data so that it wouldn't disappear
        // everytime the page reload
        $formLigneFF = $this->createForm(LigneFFType::class, null, [
            'FE' => $currentFF->getLigneFraisForfaitise()[0]->getQuantite(),
            'FK' => $currentFF->getLigneFraisForfaitise()[1]->getQuantite(),
            'NH' => $currentFF->getLigneFraisForfaitise()[2]->getQuantite(),
            'RR' => $currentFF->getLigneFraisForfaitise()[3]->getQuantite(),
        ]);

        $formLigneFF->handleRequest($request);
        //When form is validated
        if ($formLigneFF->isSubmitted() && $formLigneFF->isValid()) {
            $currentFF->getLigneFraisForfaitise()[0]->setQuantite($formLigneFF->get('FE')->getData());
            $currentFF->getLigneFraisForfaitise()[1]->setQuantite($formLigneFF->get('FK')->getData());
            $currentFF->getLigneFraisForfaitise()[2]->setQuantite($formLigneFF->get('NH')->getData());
            $currentFF->getLigneFraisForfaitise()[3]->setQuantite($formLigneFF->get('RR')->getData());

            $doctrine->getManager()->persist($currentFF); //persist the object $currentFF in the database
            $doctrine->getManager()->flush(); // flush is called to persist it
        }

        //Create Ligne Frais Hors Forfait form
        $LFHF = new LigneFraisHorsForfait();//Creation Ligne Frais Hors Forfait
        $formLigneFHF = $this->createForm(LigneFHFType::class, $LFHF);
        $formLigneFHF->handleRequest($request);

        //When form is validated
        if ($formLigneFHF->isSubmitted() && $formLigneFHF->isValid()) {
            $currentFF->addLigneFraisHorsForfait($LFHF);
            $doctrine->getManager()->persist($currentFF); //persist the object $currentFF in the database
            $doctrine->getManager()->flush(); // flush is called to persist it
        }

        return $this->render('current_fiche_frais/index.html.twig', [
                'formLFF'=>$formLigneFF,
                'formLFHF' => $formLigneFHF,
                'mois' => $currentMonth,
                'FF' => $currentFF
            ]);
    }
}
