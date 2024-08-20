<?php

namespace App\Controller;

use App\Controller\VisitorEventsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Events;
use App\Entity\Participants;
use Doctrine\Persistence\ManagerRegistry;

class UserEventsController extends VisitorEventsController
{
    #[Route('/user/events/{id}/book', name: 'user.event.book', methods: ['GET', 'POST'])]
    public function bookEvent(Request $request, int $id, Events $event, ManagerRegistry $doctrine, UserInterface $user): Response
    {
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $participant = new Participants();
        $participant->setPerson($user);
        $participant->setEvent($event);
        $doctrine->getManager()->persist($participant);
        $doctrine->getManager()->flush();

        $this->addFlash('success', 'Vous êtes maintenant inscrit à cet événement.');

        return $this->redirectToRoute('flash_messages');
    }

}