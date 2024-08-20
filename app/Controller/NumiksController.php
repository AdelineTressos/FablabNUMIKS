<?php

namespace App\Controller;

use App\Entity\Contact;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NumiksController extends AbstractController
{
    #[Route('/numiks', name: 'app_numiks')]
    public function index(): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        return $this->render('numiks/index.html.twig', [
            'controller_name' => 'NumiksController',
            'form' => $form->createView(),
        ]);
    }
}
