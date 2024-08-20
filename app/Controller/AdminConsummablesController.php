<?php

namespace App\Controller;

use App\Entity\Consummables;
use App\Form\ConsummablesType;
use App\Repository\ConsummablesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/consummables')]
class AdminConsummablesController extends AbstractController
{
    #[Route('/', name: 'app_admin_consummables_index', methods: ['GET'])]
    public function index(Request $request, ConsummablesRepository $consummablesRepository): Response
    {
        $search = $request->query->get('search');
        $consummables = $consummablesRepository->findByConsummableName($search);

        return $this->render('admin_consummables/index.html.twig', [
            'consummables' => $consummables,
        ]);
    }

    #[Route('/new', name: 'app_admin_consummables_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $consummable = new Consummables();
        $form = $this->createForm(ConsummablesType::class, $consummable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($consummable);
            $entityManager->flush();
            $this->addFlash('success', 'Le consommable a bien été crée.');
            return $this->redirectToRoute('app_admin_consummables_index');
        }

        return $this->render('admin_consummables/new.html.twig', [
            'consummable' => $consummable,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_consummables_show', methods: ['GET'])]
    public function show(Consummables $consummable): Response
    {
        return $this->render('admin_consummables/show.html.twig', [
            'consummable' => $consummable,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_consummables_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Consummables $consummable, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConsummablesType::class, $consummable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Le consommable a bien été modifiée.');
            return $this->redirectToRoute('app_admin_consummables_index');
        }

        return $this->render('admin_consummables/edit.html.twig', [
            'consummable' => $consummable,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_consummables_delete', methods: ['POST'])]
    public function delete(Request $request, Consummables $consummable, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $consummable->getId(), $request->request->get('_token'))) {
            $entityManager->remove($consummable);
            $entityManager->flush();
            $this->addFlash('success', 'Le consommable a bien été supprimée.');
        }

        return $this->redirectToRoute('app_admin_consummables_index');
    }

    
}
