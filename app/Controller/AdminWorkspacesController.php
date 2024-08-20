<?php

namespace App\Controller;

use App\Entity\Workspaces;
use App\Form\WorkspacesType;
use App\Repository\MachinesRepository;
use App\Repository\ReservationsRepository;
use App\Repository\WorkspacesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/workspaces')]
class AdminWorkspacesController extends AbstractController
{
    // Liste des espaces de travail
    #[Route('/', name: 'app_admin_workspaces')]
    public function index(WorkspacesRepository $workspacesRepository): Response
    {
        $reservedWorkspaces = $workspacesRepository->findBy(['is_booked' => true]);
        $memberAccessWorkspaces = $workspacesRepository->findBy(['member_access' => true]);
        $allAccessWorkspaces = $workspacesRepository->findAll();

        return $this->render('admin_workspaces/index.html.twig', [
            'reservedWorkspaces' => $reservedWorkspaces,
            'memberAccessWorkspaces' => $memberAccessWorkspaces,
            'allAccessWorkspaces' => $allAccessWorkspaces,
        ]);
    }


    // Création d'un nouvel espace de travail
    #[Route('/new', name: 'admin_workspaces_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $workspace = new Workspaces();
        $form = $this->createForm(WorkspacesType::class, $workspace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($workspace);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_workspaces');
        }

        return $this->render('admin_workspaces/new.html.twig', [
            'workspace' => $workspace,
            'form' => $form->createView(),
        ]);
    }

    // Édition d'un espace de travail
    #[Route('/{id}/edit', name: 'admin_workspaces_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Workspaces $workspace, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(WorkspacesType::class, $workspace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_workspaces');
        }

        return $this->render('admin_workspaces/edit.html.twig', [
            'workspace' => $workspace,
            'form' => $form->createView(),
        ]);
    }

    // Suppression d'un espace de travail
    #[Route('delete/{id}', name: 'admin_workspaces_delete', methods: ['POST'])]
public function deleteWorkspace(Request $request, Workspaces $workspace, WorkspacesRepository $workspacesRepository): Response
{
    if ($this->isCsrfTokenValid('delete'.$workspace->getId(), $request->request->get('_token'))) {
        $workspacesRepository->deleteWithRelations($workspace);

        return $this->redirectToRoute('app_admin_workspaces');
    }

    // Redirection après suppression
    return $this->redirectToRoute('app_admin_workspaces');
}


    // Ajout de la méthode show à AdminWorkspacesController

    #[Route('show/{id}', name: 'admin_workspaces_show', methods: ['GET'])]
    public function show(Workspaces $workspace): Response
    {
        return $this->render('admin_workspaces/show.html.twig', [
            'workspace' => $workspace,
        ]);
    }
}
