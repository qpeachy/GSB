<?php

namespace App\Controller;

use App\Entity\FicheFrais;
use App\Form\FicheFraisType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FicheFraisController extends AbstractController
{
    #[Route('/ficheFrais', name: 'app_fiche_frais')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
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

        $mois=[];
        foreach ($fichesfrais as $f){
            $mois[] = $f->getMois();
        }
        $laFF=null;

        $form=$this->createForm(FicheFraisType::class, null, ['mois_list'=>$mois]);
        $form->handleRequest($request);
        $bool = false;

        if ($form->isSubmitted() && $form->isValid()) {

            if($form->get('effacer')->isClicked()){
                $bool = false;
            }
            if($form->get('valider')->isClicked()){
                $bool = true;
                $formD=$form->getData();
                $result = $formD['mois'];
                foreach ($fichesfrais as $f){
                    if ($f->getMois() == $result){
                        $laFF=$f;
                    }
                }
            }

        }

        return $this->render('fiche_frais/index.html.twig', [
            'user' => $user,
            'FF' => $laFF,
            'form'=>$form,
            'bool'=>$bool
        ]);
    }
}
