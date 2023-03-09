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
        $user = $doctrine->getRepository(User::class)->findAll();
        $nbrUser = count($user);
        $fichesFrais = $doctrine->getRepository(FicheFrais::class)->findAll();
        $primeT = 0;
        foreach  ($fichesFrais as $FF){
            $primeT+=floatval($FF->getMontantValide());
        };
        $primeT = $primeT*0.095;
        $primeV = ($primeT/$nbrUser);


        $primeD = 0;
        foreach($fichesFrais as $FF){
            $primeD += floatval($FF->getPrime());
        };
        $primeD*=0.095;
        $primeDbis = ($primeD/$nbrUser);


        return $this->render('prime/index.html.twig', [
            'controller_name' => 'PrimeController',
            'primeT' => $primeT,
            'primeV'=>$primeV,
            'Dprime' => $primeD,
            'Dprimebis' => $primeDbis,
        ]);
    }

}
