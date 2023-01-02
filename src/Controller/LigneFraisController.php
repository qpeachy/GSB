<?php

namespace App\Controller;

use App\Entity\FicheFrais;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LigneFraisController extends AbstractController
{
    #[Route('{id}/lignesfrais', name: 'app_lignes_frais', methods: ['GET'])]
    public function Lines(FicheFrais $fichefrais): Response
    {
        $lesLignesFHF = $fichefrais->getLigneFraisHorsForfait();
        $lesLignesFF = $fichefrais->getLigneFraisForfait();
        return $this->render('ligne_frais/index.html.twig', [
            'controller_name' => 'LigneFraisController',
            'lesLignesFHF' => $lesLignesFHF,
            'lesLignesFF' => $lesLignesFF
        ]);
    }
}
