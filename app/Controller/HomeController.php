<?php

namespace App\Controller;

use App\Repository\MachinesRepository;
use App\Repository\ReservationsRepository;
use App\Repository\WorkspacesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(MachinesRepository $machinesRepository,ReservationsRepository $reservationsRepository, WorkspacesRepository $workspacesRepository): Response
    {
        // Récupérer toutes les machines et tous les espaces de travail depuis les repositories
        $machines = $machinesRepository->findAll();
        $workspaces = $workspacesRepository->findAll();
        $reservations = $reservationsRepository->findAll();

        return $this->render('home/home_page.html.twig', [
            'machines' => $machines,
            'workspaces' => $workspaces,
            'reservations' => $reservations
        ]);
    }
}
