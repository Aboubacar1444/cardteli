<?php

namespace App\Controller\util;

use App\Entity\Espaces;
use App\Repository\EspacesRepository;
use App\Repository\PacksAvantagesRepository;
use App\Repository\PacksRepository;
use App\Repository\TemplatesCarteVisitesRepository;
use App\Services\CryptageData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PacksRepository $packs, PacksAvantagesRepository $packsAvantages, TemplatesCarteVisitesRepository $templateExpos, CacheInterface $cahe, MailerInterface $mailer): Response
    {

        $OffrePerso = $packs->findOneBy(['nom' => 'Offre Perso']);
        $OffrePro = $packs->findOneBy(['nom' => 'Offre Pro']);
        $OffreVip = $packs->findOneBy(['nom' => 'Offre VIP']);

        $OffrePersoAvantage = $packsAvantages->findBy(['packs' => $OffrePerso->getId()]);
        $OffreProAvantage = $packsAvantages->findBy(['packs' => $OffrePro->getId()]);
        $OffreVipAvantage = $packsAvantages->findBy(['packs' => $OffreVip->getId()]);


        $cartesexpo = $templateExpos->findByCarteExpo();
        // dd($OffrePerso, $OffrePersoAvantage, $cartesexpo);


        return $this->render('util/index.html.twig', [
            'OffrePerso' => $OffrePerso,
            'OffrePro' => $OffrePro,
            'OffreVip' => $OffreVip,
            'OffrePersoAvantages' => $OffrePersoAvantage,
            'OffreProAvantages' => $OffreProAvantage,
            'OffreVipAvantages' => $OffreVipAvantage,
            'carteExpos' => $cartesexpo
        ]);
    }

    #[Route('/offres', name: 'app_offres')]
    public function offres(): Response
    {
        return $this->render('util/offres.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/offres-details/{offres}', name: 'app_offres-detail')]
    public function offresDetail($offres): Response
    {
        return $this->render('util/offres-detail.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/templates-cartes', name: 'app_modeles')]
    public function models(TemplatesCarteVisitesRepository $templates, ?EspacesRepository $espacesRepository, CacheInterface $cache, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        /*  $modeles =  $cache->get('modeles_req', function (ItemInterface $item) use ($templates, $page) {
            $item->expiresAfter(30);
            return  $templates->findBymodeles($page, 2);
        }); */
        $modeles =  $templates->findBymodeles($page, 6);
        
        if($request->get('search')) $modeles =  $templates->findModelesBySearch($request->get('search'), $page, 6);
        
        
        if($this->getUser() && $request->query->get('espace')){
            $espace = $espacesRepository->findOneById($request->query->get('espace'));   
        }else {
            $espace = null;
        }

        return $this->render('util/modeles.html.twig', [
            'modeles' => $modeles,
            'espace' => $espace,
        ]);
    }

    #[Route('/templates-cartes/details/{url}', name: 'app_modeles-details')]
    public function modelsDetails(Request $request, TemplatesCarteVisitesRepository $templates, $url, CryptageData $cryptageData): Response
    {
        $urls = explode("-", $url);
        $template = $templates->findOneBy(['codes' => urldecode($urls[0]), 'url' => $urls[1]]);
        

        return $this->render('util/modeles-details.html.twig', [
            'template' => $template
        ]);
    }
}
