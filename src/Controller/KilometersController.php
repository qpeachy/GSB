<?php

namespace App\Controller;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class KilometersController extends AbstractController
{
    /*#[Route('/kilometers', name: 'app_kilometers')]
    public function index(EntityManagerInterface $entityManager): Response
    {
       //$query = $entityManager -> createQuery("Select user.nom, user.prenom, SUM(ligne_frais_forfaitise.quantite) from user inner join fiche_frais on user.id = fiche_frais.user_id inner join ligne_frais_forfaitise on fiche_frais.id = ligne_frais_forfaitise.fiche_frais_id where fiche_frais.mois = '202107' and fiche_frais.mois = '202108' and ligne_frais_forfaitise.type_frais_forfait_id = 2 group by user.id");
//       $result = $query->getArrayResult();
//        return $this->render('kilometers/index.html.twig', [
//            'controller_name' => 'KilometersController',
//            'result' => $result,
//        ]);
    }

    #[Route('/kilometers', name: 'app_kilometers')]
    public function index2(EntityManagerInterface $entityManager): Response
    {
        //$query = $entityManager -> createQuery("Select user.nom, user.prenom, SUM(ligne_frais_forfaitise.quantite) from user inner join fiche_frais on user.id = fiche_frais.user_id inner join ligne_frais_forfaitise on fiche_frais.id = ligne_frais_forfaitise.fiche_frais_id where fiche_frais.mois = '202107' and fiche_frais.mois = '202108' and ligne_frais_forfaitise.type_frais_forfait_id = 2 group by user.id having SUM(ligne_frais_forfaitise.quantite) > 1500");
//       $result = $query->getArrayResult();
//        return $this->render('kilometers/index.html.twig', [
//            'controller_name' => 'KilometersController',
//            'result' => $result,
//        ]);
    }*/
}
