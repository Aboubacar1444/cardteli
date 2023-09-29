<?php

namespace App\Controller\util;

use App\Entity\Espaces;
use App\Form\EspacesType;
use App\Repository\CommandesRepository;
use App\Repository\EspacesRepository;
use App\Repository\NumerosUssdRepository;
use App\Repository\SiteTemplateRepository;
use App\Repository\TemplatesCarteVisitesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            'espaces' => $espacesRepository->findBy(['User' => $this->getUser()]),
        ]);
    }

    #[Route('/new', name: 'app_espaces_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EspacesRepository $espacesRepository): Response
    {
        $espace = new Espaces();
        $form = $this->createForm(EspacesType::class, $espace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $espace->setUser($this->getUser());
            $espace->setDateCreations(new \DateTime());
            $espacesRepository->save($espace, true);

            return $this->redirectToRoute('app_espaces_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comptes/espaces/new.html.twig', [
            'espace' => $espace,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_espaces_show', methods: ['GET', 'POST'])]
    public function show(ManagerRegistry $manager, Request $request, Espaces $espace, CommandesRepository $commandes, TemplatesCarteVisitesRepository $templatesCarteVisitesRepository, SiteTemplateRepository $siteTemplateRepository): Response
    {
        $em = $manager->getManager();
        $today = new \DateTime('now');
        $monthLater = $today->add( new \DateInterval("P1M"));
        $getCommandes = $commandes->findBy(['user' => $this->getUser(), "productType" => "pack", "espaces" => null]);
        // add pack to an empty space
        if($request->request->get('commande')){
            
            $commandeId = $request->request->get('commande');
            $espace->setCommandes($commandes->findOneById($commandeId));
            
            $espace->setDateEcheance($monthLater);
            $em->flush();
            $cmdRef = $espace->getCommandes()->getReference();
            $this->addFlash(
               'success',
               "Nice! votre pack: $cmdRef a été rélié avec succès à votre espace!"
            );
        }
        // add card template to a space
        if($request->get('cardTemplate'))
        {
            $cardTemplateId = $request->get('cardTemplate');
            $espace->setCardTemplate($templatesCarteVisitesRepository->findOneById($cardTemplateId));
            $em->flush();
            $cardTemplateName = $espace->getCardTemplate()->getTitres();
            $this->addFlash(
                'success',
                "Nice! votre Template: $cardTemplateName, a été rélié avec succès à votre espace!"
             );
        }

        //add site Template
        if ($request->get('siteTemplate')){
            $siteTemplateId = $request->get('siteTemplate');
            $espace->setSiteTemplate($siteTemplateRepository->findOneByID($siteTemplateId));
            $em->flush();
            $siteTemplateName = $espace->getSiteTemplate()->getName();
            $this->addFlash(
                'success',
                "Nice! votre site : $siteTemplateName, a été rélié avec succès à votre espace! Veuillez renseignez le formulaire d'information pour le template."
             );
        }
        if ($espace->getSiteTemplate() && !$espace->getUserInfoSiteTemplate()){
            return $this->redirectToRoute('app_user_info_site_template', ['id'=>$espace->getId()]);
        }
        return $this->render('comptes/espaces/show.html.twig', [
            'espace' => $espace,
            "commandes"=>$getCommandes
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

        return $this->render('comptes/espaces/edit.html.twig', [
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
