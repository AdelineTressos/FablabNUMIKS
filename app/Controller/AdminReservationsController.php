<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Form\ReservationsTypeMachine;
use App\Form\ReservationsTypeWorkSpace;
use App\Repository\ReservationsRepository;
use App\Repository\UsersRepository;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AdminReservationsController extends AbstractController
{   
    #[Route('/admin/reservations/dashboard', name: 'app_admin_reservations_dashboard')]
    public function indexDashboard(): Response
    {
        return $this->render('admin_reservations/dashboard.html.twig', [
        ]);
    }

    #[Route('/admin/reservations', name: 'app_admin_reservations_machine')]
    public function index(Request $request, ReservationsRepository $repository): Response
    {
        $month = $request->query->get('month');
        $username = $request->query->get('username');
        $todayFilter = $request->query->get('today');

        // Définir la date d'aujourd'hui et hier
        $today = new \DateTime('today');
        $yesterday = (clone $today)->modify('-1 day');

        if ($todayFilter) {
            // Si le filtre aujourd'hui est appliqué, récupérer uniquement les réservations pour aujourd'hui
            $reservations = $repository->findReservationsForToday();
        } else {
            // Sinon, récupérer toutes les réservations selon le mois et le nom d'utilisateur
            $reservations = $repository->findReservations($month, $username);
        }

        // Initialiser les tableaux pour les réservations
        $futureValidatedReservations = [];
        $futureNonValidatedReservations = [];
        $pastReservations = [];
        $todayReservations = []; // Ajout d'un tableau pour les réservations d'aujourd'hui

        foreach ($reservations as $reservation) {
            if ($reservation->getDateReservation() > $today) {
                // Réservation dans le futur
                if ($reservation->isIsValidated()) {
                    $futureValidatedReservations[] = $reservation;
                } else {
                    $futureNonValidatedReservations[] = $reservation;
                }
            } elseif ($reservation->getDateReservation() == $today) {
                // Réservation pour aujourd'hui
                $todayReservations[] = $reservation;
            } elseif ($reservation->getDateReservation() <= $yesterday) {
                // Réservation dans le passé (y compris hier)
                $pastReservations[] = $reservation;
            }
        }

        // Passer les réservations filtrées à la vue
        return $this->render('admin_reservations/index.html.twig', [
            'futureValidatedReservations' => $futureValidatedReservations,
            'futureNotValidatedReservations' => $futureNonValidatedReservations,
            'pastReservations' => $pastReservations,
            'todayReservations' => $todayReservations, // Ajouter les réservations d'aujourd'hui à la vue
        ]);
    }


    #[Route('/admin/reservations/create', name: 'app_admin_reservations_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservations();
        $form = $this->createForm(ReservationsTypeMachine::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();
            $this->addFlash('success', 'Vous venez de creer une réservation d\'une machine');
            return $this->redirectToRoute('app_admin_reservations_machine');
        }
        return $this->render('admin_reservations/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/reservations/edit/{id}', name: 'app_admin_reservations_edit_machine')]
    public function edit(int $id, Request $request,UsersRepository $userRepository,SendMailService $mail, ReservationsRepository $repository, EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator): Response
    {
        $reservation = $repository->find($id);
        if (!$reservation) {
            throw $this->createNotFoundException('La réservation n\'existe pas.');
        }

        $form = $this->createForm(ReservationsTypeMachine::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation); // Prépare l'entité pour la sauvegarde
            $entityManager->flush(); // Effectue la sauvegarde

            $adminUser = $userRepository->findOneBy(['username' => 'admin']);
        if ($adminUser) {
            $adminEmail = $adminUser->getEmail();
            // Envoyer l'email de confirmation
            $mail->send(
                $adminEmail,
                $reservation->getUser()->getEmail(),
                "Validation de votre réservation",
                'modifierReservation',
                compact('reservation')
            );
        }
            $this->addFlash('success', 'Vous venez de modifier une réservation d\'une machine');
            return $this->redirectToRoute('app_admin_reservations_machine');
        }
        return $this->render('admin_reservations/edit.html.twig', [
            'form' => $form->createView(),
            'reservation' => $reservation
        ]);
    }

    #[Route('/admin/reservations/delete/{id}', name: 'app_admin_reservations_delete_machine')]
    public function delete(int $id,UsersRepository $userRepository,SendMailService $mail, ReservationsRepository $repository, EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator): Response
    {
        $reservation = $repository->find($id);

        $adminUser = $userRepository->findOneBy(['username' => 'admin']);
        if ($adminUser) {
            $adminEmail = $adminUser->getEmail();
            // Envoyer l'email de confirmation
            $mail->send(
                $adminEmail,
                $reservation->getUser()->getEmail(),
                "Validation de votre réservation",
                'annulerReservation',
                compact('reservation')
            );
        }

        if ($reservation) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Vous venez de supprimer une réservation d\'une machine');
        return $this->redirectToRoute('app_admin_reservations_machine');
    }

    #[Route('/admin/reservations/show/{id}', name: 'app_admin_reservations_show_machine')]
    public function show(int $id, ReservationsRepository $repository): Response
    {
        $reservation = $repository->find($id);
        if (!$reservation) {
            throw $this->createNotFoundException('La réservation demandée n\'existe pas.');
        }

        return $this->render('admin_reservations/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/admin/reservations/validate/send/email/{id}', name: 'app_admin_reservations_validate')]
    public function validateReservation(int $id, UsersRepository $userRepository, ReservationsRepository $repository, EntityManagerInterface $em, SendMailService $mail): Response
    {
        $reservation = $repository->find($id);

        if (!$reservation) {
            $this->addFlash('error', 'La réservation n\'existe pas.');
            return $this->redirectToRoute('app_admin_reservations_machine');
        }

        // Valider la réservation
        $reservation->setIsValidated(true);
        $em->flush();

        $adminUser = $userRepository->findOneBy(['username' => 'admin']);
        if ($adminUser) {
            $adminEmail = $adminUser->getEmail();
            // Envoyer l'email de confirmation
            $mail->send(
                $adminEmail,
                $reservation->getUser()->getEmail(),
                "Validation de votre réservation",
                'validerReservation',
                compact('reservation')
            );

            $this->addFlash('success', 'La réservation a été validée et un e-mail de confirmation a été envoyé.');
            return $this->redirectToRoute('app_admin_reservations_show_machine', ['id' => $id]);
        }
    }

    // ATTENTION PARTIS RESERVATION WORKSPACE !

    #[Route('/admin/reservations/workspace', name: 'app_admin_reservations_workspace')]
    public function indexWorkspace(Request $request, ReservationsRepository $repository): Response
    {
        $month = $request->query->get('month');
        $username = $request->query->get('username');
        $todayFilter = $request->query->get('today');

        // Définir la date d'aujourd'hui et hier
        $today = new \DateTime('today');
        $yesterday = (clone $today)->modify('-1 day');

        if ($todayFilter) {
            // Si le filtre aujourd'hui est appliqué, récupérer uniquement les réservations pour aujourd'hui
            $reservations = $repository->findReservationsForToday();
        } else {
            // Sinon, récupérer toutes les réservations selon le mois et le nom d'utilisateur
            $reservations = $repository->findReservations($month, $username);
        }

        // Initialiser les tableaux pour les réservations
        $futureValidatedReservations = [];
        $futureNonValidatedReservations = [];
        $pastReservations = [];
        $todayReservations = []; // Ajout d'un tableau pour les réservations d'aujourd'hui

        foreach ($reservations as $reservation) {
            if ($reservation->getDateReservation() > $today) {
                // Réservation dans le futur
                if ($reservation->isIsValidated()) {
                    $futureValidatedReservations[] = $reservation;
                } else {
                    $futureNonValidatedReservations[] = $reservation;
                }
            } elseif ($reservation->getDateReservation() == $today) {
                // Réservation pour aujourd'hui
                $todayReservations[] = $reservation;
            } elseif ($reservation->getDateReservation() <= $yesterday) {
                // Réservation dans le passé (y compris hier)
                $pastReservations[] = $reservation;
            }
        }

        // Passer les réservations filtrées à la vue
        return $this->render('admin_reservations/workspace/index.html.twig', [
            'futureValidatedReservations' => $futureValidatedReservations,
            'futureNotValidatedReservations' => $futureNonValidatedReservations,
            'pastReservations' => $pastReservations,
            'todayReservations' => $todayReservations, // Ajouter les réservations d'aujourd'hui à la vue
        ]);
    }


    #[Route('/admin/reservations/workspace/create', name: 'app_admin_reservations_create_workspace')]
    public function createWorkspace(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservations();
        $form = $this->createForm(ReservationsTypeWorkSpace::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();
            $this->addFlash('success', 'Vous venez de créer une réservation d\'un poles');
            return $this->redirectToRoute('app_admin_reservations_workspace');
        }
        return $this->render('admin_reservations/workspace/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/reservations/edit/workspace/{id}', name: 'app_admin_reservations_edit_workspace')]
    public function editWorkspace(int $id, Request $request,UsersRepository $userRepository,SendMailService $mail, ReservationsRepository $repository, EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator): Response
    {
        $reservation = $repository->find($id);
        if (!$reservation) {
            throw $this->createNotFoundException('La réservation n\'existe pas.');
        }

        $form = $this->createForm(ReservationsTypeWorkSpace::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation); // Prépare l'entité pour la sauvegarde
            $entityManager->flush(); // Effectue la sauvegarde

            $adminUser = $userRepository->findOneBy(['username' => 'admin']);
        if ($adminUser) {
            $adminEmail = $adminUser->getEmail();
            // Envoyer l'email de confirmation
            $mail->send(
                $adminEmail,
                $reservation->getUser()->getEmail(),
                "Validation de votre réservation",
                'modifierReservation',
                compact('reservation')
            );
        }   
        $this->addFlash('success', 'Vous venez de modifier une réservation d\'un poles');
            return $this->redirectToRoute('app_admin_reservations_workspace');
        }
        return $this->render('admin_reservations/workspace/edit.html.twig', [
            'form' => $form->createView(),
            'reservation' => $reservation
        ]);
    }

    #[Route('/admin/reservations/workspace/delete/{id}', name: 'app_admin_reservations_delete_workspace')]
    public function deleteWorkspace(int $id,UsersRepository $userRepository,SendMailService $mail, ReservationsRepository $repository, EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator): Response
    {
        $reservation = $repository->find($id);

        $adminUser = $userRepository->findOneBy(['username' => 'admin']);
        if ($adminUser) {
            $adminEmail = $adminUser->getEmail();
            // Envoyer l'email de confirmation
            $mail->send(
                $adminEmail,
                $reservation->getUser()->getEmail(),
                "Validation de votre réservation",
                'annulerReservation',
                compact('reservation')
            );
        }

        if ($reservation) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Vous venez de supprimer une réservation d\'un poles');
        return $this->redirectToRoute('app_admin_reservations_workspace');
    }

    #[Route('/admin/reservations/workspace/show/{id}', name: 'app_admin_reservations_show_workspace')]
    public function showWorkspace(int $id, ReservationsRepository $repository): Response
    {
        $reservation = $repository->find($id);
        if (!$reservation) {
            throw $this->createNotFoundException('La réservation demandée n\'existe pas.');
        }

        return $this->render('admin_reservations/workspace/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/admin/reservations/validate/workspace/send/email/{id}', name: 'app_admin_reservations_validate_workspace')]
    public function validateReservationWorkspace(int $id, UsersRepository $userRepository, ReservationsRepository $repository, EntityManagerInterface $em, SendMailService $mail): Response
    {
        $reservation = $repository->find($id);

        if (!$reservation) {
            $this->addFlash('error', 'La réservation n\'existe pas.');
            return $this->redirectToRoute('app_admin_reservations_machine');
        }

        // Valider la réservation
        $reservation->setIsValidated(true);
        $em->flush();

        $adminUser = $userRepository->findOneBy(['username' => 'admin']);
        if ($adminUser) {
            $adminEmail = $adminUser->getEmail();
            // Envoyer l'email de confirmation
            $mail->send(
                $adminEmail,
                $reservation->getUser()->getEmail(),
                "Validation de votre réservation",
                'validerReservation',
                compact('reservation')
            );

            $this->addFlash('success', 'La réservation a été validée et un e-mail de confirmation a été envoyé.');
            return $this->redirectToRoute('app_admin_reservations_show_workspace', ['id' => $id]);
        }
    }
}
