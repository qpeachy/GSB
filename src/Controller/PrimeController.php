<?php

namespace App\Controller;

use App\Entity\FicheFrais;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrimeController extends AbstractController
{
    #[Route('/prime', name: 'app_prime')]
    public function primeV(ManagerRegistry $doctrine): Response
    {
        $userL = $doctrine->getRepository(User::class)->findAll();
        $nbrUser = count($userL);
        $ficheFraisL = $doctrine->getRepository(FicheFrais::class)->findAll();
        $prime = 0;
        foreach  ($ficheFraisL as $FF){
            $prime+=floatval($FF->getMontantValide());
        };
        $prime = $prime*0.095;
        $primeV = ($prime/$nbrUser);
        $primeV = number_format($primeV, 2, ',', ' ');
        $primeT = number_format($prime, 2, ',', ' ');

        return $this->render('prime/index.html.twig', [
            'controller_name' => 'PrimeController',
            'primeT' => $primeT,
            'primeV'=>$primeV,
        ]);
    }

//    public function primeD(ManagerRegistry $doctrine): Response
//    {
//        $userL = $doctrine->getRepository(User::class)->findAll();
//        $nbrUser = count($userL);
//        $ficheFraisL = $doctrine->getRepository(FicheFrais::class)->findAll();
//        $prime = 0;
//        foreach  ($ficheFraisL as $FF){
//
//        };
//        return $this->render('prime/index.html.twig', [
//            'DprimeT' => $primeT,
//            'DprimeV'=>$primeV,
//        ]);
//    }

}
