<?php

namespace App\Controller;

use App\Entity\TypeFraisForfait;
use App\Form\TypeFraisForfaitType;
use App\Repository\TypeFraisForfaitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/type/frais/forfait')]
class TypeFraisForfaitController extends AbstractController
{
    #[Route('/', name: 'app_type_frais_forfait_index', methods: ['GET'])]
    public function index(TypeFraisForfaitRepository $typeFraisForfaitRepository): Response
    {
        return $this->render('type_frais_forfait/index.html.twig', [
            'type_frais_forfaits' => $typeFraisForfaitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_frais_forfait_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypeFraisForfaitRepository $typeFraisForfaitRepository): Response
    {
        $typeFraisForfait = new TypeFraisForfait();
        $form = $this->createForm(TypeFraisForfaitType::class, $typeFraisForfait);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeFraisForfaitRepository->add($typeFraisForfait, true);

            return $this->redirectToRoute('app_type_frais_forfait_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_frais_forfait/new.html.twig', [
            'type_frais_forfait' => $typeFraisForfait,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_frais_forfait_show', methods: ['GET'])]
    public function show(TypeFraisForfait $typeFraisForfait): Response
    {
        return $this->render('type_frais_forfait/show.html.twig', [
            'type_frais_forfait' => $typeFraisForfait,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_frais_forfait_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeFraisForfait $typeFraisForfait, TypeFraisForfaitRepository $typeFraisForfaitRepository): Response
    {
        $form = $this->createForm(TypeFraisForfaitType::class, $typeFraisForfait);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeFraisForfaitRepository->add($typeFraisForfait, true);

            return $this->redirectToRoute('app_type_frais_forfait_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_frais_forfait/edit.html.twig', [
            'type_frais_forfait' => $typeFraisForfait,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_frais_forfait_delete', methods: ['POST'])]
    public function delete(Request $request, TypeFraisForfait $typeFraisForfait, TypeFraisForfaitRepository $typeFraisForfaitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeFraisForfait->getId(), $request->request->get('_token'))) {
            $typeFraisForfaitRepository->remove($typeFraisForfait, true);
        }

        return $this->redirectToRoute('app_type_frais_forfait_index', [], Response::HTTP_SEE_OTHER);
    }
}
