<?php

namespace App\Controller;

use App\Entity\Espaces;
use App\Entity\SiteTemplate;
use App\Form\EspacesUserInfoType;
use App\Form\JsonType;
use App\Repository\EspacesRepository;
use App\Repository\SiteTemplateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sites/template')]
class SiteTemplateController extends AbstractController
{   
    
    #[Route('', name: 'app_site_template')]
    public function index(EspacesRepository $espacesRepository, SiteTemplateRepository $siteTemplateRepository, Request $request): Response
    {   
        $page = $request->query->getInt('page', 1);
        if(!$this->getUser()) return $this->redirectToRoute('app_login');
        $modeles =  $siteTemplateRepository->findBymodeles($page, 15);
        
        if($this->getUser() && $request->query->get('espace')){
            $espace = $espacesRepository->findOneById($request->query->get('espace'));   
        }else {
            $espace = null;
        }
        
        return $this->render('site_template/index.html.twig', [
            'modeles' => $modeles,
            'espace' => $espace,
        ]);
    }

    #[Route('/details/{id}', name: 'app_site_template_details')]
    public function templateDetails(Request $request, SiteTemplateRepository $siteTemplateRepository): Response
    {
        $siteTemplate = $siteTemplateRepository->findOneById($request->get('id'));
       
        return $this->render('site_template/modeles-details.html.twig', [
            'template' => $siteTemplate
        ]);
    }
    #[Route('/userinfo/add/{id}', name: 'app_user_info_site_template')]
    public function userInfoSiteTemplateAdd(Request $request, Espaces $espace, EspacesRepository $espacesRepository): Response
    {
        $form = $this->createForm(EspacesUserInfoType::class, $espace);
        $form->handleRequest($request);
        
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $espacesRepository->save($espace, true);
        }
        if ($espace->getSiteTemplate() && $espace->getUserInfoSiteTemplate()){
            return $this->redirectToRoute('app_espaces_show', ['id'=>$espace->getId()]);
        }

        return $this->render('site_template/add-user-info.html.twig', [
            'form'=>$form,
            'espace'=>$espace
        ]);
    }
}
