<?php

namespace App\Controller\util;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Espaces;
use App\Form\EspacesType;
use App\Repository\EspacesRepository;
use Symfony\Component\HttpFoundation\Request;

class ComptesController extends AbstractController
{
    #[Route('/comptes', name: 'app_comptes')]
    public function index(EspacesRepository $espacesRepository, Request $request): Response
    {
        $espace = new Espaces();
        $form = $this->createForm(EspacesType::class, $espace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $espace->setDateCreations(new \DateTime());
            $espacesRepository->save($espace, true);

            return $this->redirectToRoute('app_espaces_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('comptes/index.html.twig', [
            'controller_name' => 'ComptesController',
            'espaces' => $espacesRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/numerotation/{espaces}', name: 'app_numero_ussd')]
    public function numerotations(EspacesRepository $espacesRepository, Request $request): Response
    {


        return $this->render('comptes/numerotation.html.twig', []);
    }
}
