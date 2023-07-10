<?php

namespace App\Controller\util;

use App\Entity\Espaces;
use App\Form\EspacesType;
use App\Repository\CommandesRepository;
use App\Repository\EspacesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/espaces')]
class EspacesController extends AbstractController
{
    #[Route('/', name: 'app_espaces_index', methods: ['GET'])]
    public function index(EspacesRepository $espacesRepository): Response
    {
        return $this->render('comptes/espaces/index.html.twig', [
            'espaces' => $espacesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_espaces_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EspacesRepository $espacesRepository): Response
    {
        $espace = new Espaces();
        $form = $this->createForm(EspacesType::class, $espace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $espacesRepository->save($espace, true);

            return $this->redirectToRoute('app_espaces_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comptes/espaces/new.html.twig', [
            'espace' => $espace,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_espaces_show', methods: ['GET'])]
    public function show(Espaces $espace, CommandesRepository $commandes): Response
    {
        return $this->render('comptes/espaces/show.html.twig', [
            'espace' => $espace,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_espaces_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Espaces $espace, EspacesRepository $espacesRepository): Response
    {
        $form = $this->createForm(EspacesType::class, $espace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $espacesRepository->save($espace, true);

            return $this->redirectToRoute('app_espaces_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comptes/espaces/edit.html.twig', [
            'espace' => $espace,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_espaces_delete', methods: ['POST'])]
    public function delete(Request $request, Espaces $espace, EspacesRepository $espacesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $espace->getId(), $request->request->get('_token'))) {
            $espacesRepository->remove($espace, true);
        }

        return $this->redirectToRoute('app_espaces_index', [], Response::HTTP_SEE_OTHER);
    }
}
