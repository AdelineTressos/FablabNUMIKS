<?php

namespace App\Controller;

use App\Entity\Events;
use App\Repository\EventsRepository;
use App\Entity\Participants;
use App\Repository\ParticipantsRepository;
use App\Form\AdminEventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/event')]
class AdminEventController extends AbstractController
{
    #[Route('/', name: 'app_admin_event')]
    public function index(EventsRepository $eventsRepository): Response
    {
        // $ParticipantsCounts = $eventsRepository->findByEventNumberOfParticipants();

        return $this->render('admin_event/index.html.twig', [
            'controller_name' => 'AdminEventController',
            'publishedEvents' => $eventsRepository->findBy(
                ['is_published' => true],
                ['start_date' => 'DESC']
            ),
           
        ]);
    }

    // create new Event
    #[Route('/new', name: 'app_admin_event_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $event = new Events();
        $form = $this->createForm(AdminEventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();

            $this->addFlash('success', 'Un nouvel évènement a été créé avec succès.');

            return $this->redirectToRoute('app_admin_event', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_event/newEvent.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'app_admin_event_show', methods: ['GET'])]
    public function show(Events $event, ParticipantsRepository $participantsRepository): Response
    {
        // $participants = $participantsRepository->findBy(['event' => $event]);

        // $events = [];
        // foreach ($participants as $participant) {
        //     $events[] = $participant->getEvent();
        // }

        return $this->render('admin_event/showEvent.html.twig', [
            'event' => $event,
            'participants' => $participantsRepository->findParticipantsByEvent($event),
        ]);
    }

// mettre un formulaire pour changer le status de is validated

}
