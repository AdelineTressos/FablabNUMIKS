<?php

namespace App\Controller;

use App\Repository\ReservationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/reservations')]
class ReservationsController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'reservations_index', methods: ['GET'])]
    public function index(ReservationsRepository $reservationsRepository): Response
    {
        return $this->render('profile_user/reservations_user.html.twig', [
            'reservations' => $reservationsRepository->findBy(['user' => $this->getUser()]),
        ]);
    }

}
