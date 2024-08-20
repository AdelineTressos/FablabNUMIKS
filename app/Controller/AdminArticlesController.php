<?php

namespace App\Controller;

use App\Entity\Publications; // Assurez-vous que cette entité est correcte pour votre contexte
use App\Form\PublicationsType; // Vérifiez si le formulaire doit être ajusté
use App\Repository\PublicationsRepository; // Confirmez le repository
use App\Service\FileUploader; // Confirmez que ce service est utilisé et configuré
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/articles')]
class AdminArticlesController extends AbstractController
{
    #[Route('/', name: 'app_admin_articles_index', methods: ['GET'])]
    public function index(PublicationsRepository $publicationsRepository): Response
    {
        return $this->render('admin_articles/index.html.twig', [
            'publications' => $publicationsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_articles_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, FileUploader $fileUploader): Response
    {
        $publication = new Publications();
        $form = $this->createForm(PublicationsType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Logique d'upload de l'image et de persistance
            if ($imageFile = $form->get('front_picture_file')->getData()) {
                $imageFileName = $fileUploader->upload($imageFile);
                $publication->setFrontPicture($imageFileName);
            }

            $entityManager->persist($publication);
            $entityManager->flush();

            $this->addFlash('success', 'L\'article a bien été créé.');
            return $this->redirectToRoute('app_admin_articles_index');
        }

        return $this->render('admin_articles/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_articles_show', methods: ['GET'])]
    public function show(Publications $publication): Response
    {
        return $this->render('admin_articles/show.html.twig', [
            'publication' => $publication,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_articles_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Publications $publication, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PublicationsType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $entityManager->flush();
                $this->addFlash('success', 'La publication a bien été modifiée.');
                return $this->redirectToRoute('app_admin_articles_show', ['id' => $publication->getId()], Response::HTTP_SEE_OTHER);
            } else {
                // Le formulaire a été soumis mais n'est pas valide
                $this->addFlash('danger', 'Une erreur est survenue lors de la modification!');
            }
        }

        return $this->render('admin_articles/edit.html.twig', [
            'publication' => $publication,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_articles_delete', methods: ['POST'])]
    public function delete(Request $request, Publications $publication, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $publication->getId(), $request->request->get('_token'))) {

            $imageFileName = $publication->getFrontPicture(); 
            if ($imageFileName) {
                $imageFilePath = $this->getParameter('targetDirectory') . '/' . $imageFileName;
                if (file_exists($imageFilePath)) {
                    unlink($imageFilePath);
                }
            }

            $entityManager->remove($publication);
            $entityManager->flush();

            $this->addFlash('success', 'Publication supprimée avec succès.');
        }

        return $this->redirectToRoute('app_admin_articles_index');
    }
}
