<?php

namespace App\Controller\util;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Espaces;
use App\Entity\NumerosUssdRelations;
use App\Form\EspacesType;
use App\Repository\EspacesRepository;
use App\Repository\NumerosUssdRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ComptesController extends AbstractController
{
    public function __construct(private  ManagerRegistry $em, private NumerosUssdRepository $numerosUssdRepository){}

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
            'espaces' => $espacesRepository->findBy(['User'=>$this->getUser()]),
            'form' => $form->createView(),
        ]);
    }
    //add an ussd number to an espace
    #[Route('/numerotation/{espaces}', name: 'app_numero_ussd')]
    public function numerotations(EspacesRepository $espacesRepository, Request $request): Response
    {   
        $persit = $this->em->getManager();
        $userEspace = $espacesRepository->findOneById($request->get('espaces')); 
        //check ussd if available or not
        if ($request->getContent()){
            $ussdToCheck = $request->request->get('ussd');
           
            $response = $this->numerosUssdRepository->checkUssd($ussdToCheck);
            foreach ($response as $v) {
                $data [] = $v;
            }
            return $this->json($data, 200);
        }
        //put ussd choiced by user to his espace
        if ($request->get('choiceUssd')){
            $ussd =$request->get('choiceUssd');
            $ussdRelation = new NumerosUssdRelations();
            $choiceUssd =$this->numerosUssdRepository->findOneByNumeros($ussd);
            $userEspace->setUnitesUssd($ussd);
            
            if ($choiceUssd->getPrix() != 0) {
               
            }else{
                $ussdRelation->setEspaces($userEspace);
                $ussdRelation->setNumero($choiceUssd);
                $choiceUssd->setDisponibilites(false);  
            }
            $persit->persist($ussdRelation);
            $persit->flush();
            $this->addFlash(
                'success',
                "Nice! votre ussd: $ussd a été rélié avec succès à votre espace!"
            );
            return $this->redirectToRoute('app_espaces_show', ['id', $request->get('espaces')]);
        }
        return $this->render('comptes/numerotation.html.twig', [
            'espace'=> $espacesRepository->findOneById($request->get('espaces')),
        ]);
    }
}
