<?php

namespace App\Controller\gestions;

use App\Entity\TemplateImages;
use App\Entity\TemplatesCarteVisites;
use App\Form\TemplatesCarteVisitesType;
use App\Repository\TemplateImagesRepository;
use App\Repository\TemplatesCarteVisitesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/templates/carte/visites')]
class TemplatesCarteVisitesController extends AbstractController
{
    #[Route('/', name: 'app_templates_carte_visites_index', methods: ['GET'])]
    public function index(TemplatesCarteVisitesRepository $templatesCarteVisitesRepository): Response
    {
        return $this->render('gestions/templates_carte_visites/index.html.twig', [
            'templates_carte_visites' => $templatesCarteVisitesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_templates_carte_visites_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TemplatesCarteVisitesRepository $templatesCarteVisitesRepository, SluggerInterface $slugger, TemplateImagesRepository $uploadI): Response
    {
        $templatesCarteVisite = new TemplatesCarteVisites();
        $form = $this->createForm(TemplatesCarteVisitesType::class, $templatesCarteVisite);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            /** @var UploadedFile $images */
            $images = $form->get('images')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            foreach ($images as $value) {
                $uplo = new TemplateImages();
                $originalFilename = pathinfo($value->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $value->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $value->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                    $uplo->setImages($newFilename);
                    $uplo->setModeles($templatesCarteVisite);
                    $uploadI->save($uplo);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imagesname' property to store the PDF file name
                // instead of its contents

            }
            $templatesCarteVisite->setDateAjout(new \DateTime());
            $templatesCarteVisitesRepository->save($templatesCarteVisite, true);

            //  return $this->redirectToRoute('app_templates_carte_visites_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('gestions/templates_carte_visites/new.html.twig', [
            'templates_carte_visite' => $templatesCarteVisite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_templates_carte_visites_show', methods: ['GET'])]
    public function show(TemplatesCarteVisites $templatesCarteVisite): Response
    {
        return $this->render('gestions/templates_carte_visites/show.html.twig', [
            'templates_carte_visite' => $templatesCarteVisite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_templates_carte_visites_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TemplatesCarteVisites $templatesCarteVisite, TemplatesCarteVisitesRepository $templatesCarteVisitesRepository): Response
    {
        $form = $this->createForm(TemplatesCarteVisitesType::class, $templatesCarteVisite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $templatesCarteVisitesRepository->save($templatesCarteVisite, true);

            return $this->redirectToRoute('app_templates_carte_visites_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('gestions/templates_carte_visites/edit.html.twig', [
            'templates_carte_visite' => $templatesCarteVisite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_templates_carte_visites_delete', methods: ['POST'])]
    public function delete(Request $request, TemplatesCarteVisites $templatesCarteVisite, TemplatesCarteVisitesRepository $templatesCarteVisitesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $templatesCarteVisite->getId(), $request->request->get('_token'))) {
            $templatesCarteVisitesRepository->remove($templatesCarteVisite, true);
        }

        return $this->redirectToRoute('app_templates_carte_visites_index', [], Response::HTTP_SEE_OTHER);
    }
}