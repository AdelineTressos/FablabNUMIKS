<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Persons;
use App\Entity\Genders;
use App\Entity\Cities;
use App\Entity\Events;
use App\Entity\Participants;
use App\Repository\UsersRepository;
use App\Repository\PersonsRepository;
use App\Repository\GendersRepository;
use App\Repository\CitiesRepository;
use App\Repository\EventsRepository;
use App\Repository\PartipantsRepository;
use App\Form\VisitorEventRegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface; //c'est cette ligne qui ma bloqué

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class VisitorEventsController extends AbstractController
{
    #[Route('/visitor/events', name: 'app_visitor_events', methods: ['GET'])]

    public function index(Request $request, EventsRepository $repository): Response
    {
        $events = $repository->findAll();
        return $this->render('visitor_events/index.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/visitor/events/{id}', name: 'event.show', methods: ['GET'])]
    public function show(Request $request, int $id, EventsRepository $repository): Response
    {   
        // if ($is_member_only)
        $event = $repository->find($id);
        // $event = $repository->find($is_member_only);
        return $this->render('visitor_events/show.html.twig', [
            'event' => $event,
        ]);
    }
    #[Route('/visitor/events/{id}/check-membership', name: 'event.check_membership', methods: ['GET', 'POST'])]
public function checkMembership(Request $request, int $id, EventsRepository $repository, EntityManagerInterface $em)
{
    $event = $repository->find($id);
    $user = $this->getUser(); // Get the current user

    if ($user && $user->isMember()) { // Check if the user is a member
        return new JsonResponse(['isMember' => true]);
    } else {
        return new JsonResponse(['isMember' => false]);
    }
}


    #[Route('/visitor/events/{id}/book', name: 'event.book', methods: ['GET', 'POST'])]
    public function book(Request $request, int $id, EventsRepository $repository, Events $event, EntityManagerInterface $em, UserInterface $user = null)
    { $event = $repository->find($id);
        
        $person = new Persons();
        $gender = new Genders();
        $cities = new Cities();
        $form = $this->createForm(VisitorEventRegistrationType::class, $person);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($person);
            $participant = new Participants();
            $participant->setPerson($person);
            $participant->setEvent($event);
            $em->persist($participant);
            $em->flush();
            $this->addFlash('success', 'Nous avons bien pris en compte votre inscription.Un mail de confirmation vous sera prochainement envoyé.A bientôt');
            return $this->redirectToRoute('flash_messages');
        }  return $this->render('visitor_events/book.html.twig', [
            'event' => $event,
            'form' => $form
        ]);
        if ($user) {

            // If the user is logged in, redirect to the user event booking page
            return $this->redirectToRoute('user.event.book', [
                'id' => $event->getId(),
            ]);
        }
    
        // If the user is not logged in, render the show template
        return $this->render('visitor_events/book.html.twig', [
            
            'event' => $event,
        ]);
      
    }

    // #[Route('/visitor/events/book/alert', name: 'event.alert', methods: ['GET', 'POST'])]
    public function showFlashSpecial(Request $request): Response
    {
        return $this->render('visitor_events/flash_messages.html.twig', [
            'flashSpecial' => $request->getSession()->getFlashBag()->all(),
            'flashMessages'=> ""
        ]);
    }
    


    

}