<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(
        Request $request, 
        EntityManagerInterface $entityManager, 
        MailerInterface $mailer
        ): Response
    {
        //contact form
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        //when form submitted and valided
        if($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            //persistance on contact table in DB
            $entityManager->persist($contact);
            $entityManager->flush();

            //send email contact
            $email = (new TemplatedEmail())
            ->from($contact->getEmail())
            ->to('adminFablab@outlook.com')
            ->subject('Demande de contact')
            // path of the Twig template to render
            ->htmlTemplate('contact/emails_contact/contact_email.html.twig')
            ->context([
                'contact' => $contact
            ]);

            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                var_dump('Erreur : '. $e);
            }

            //flash success
            $this->addFlash(
                'success',
                'Votre demande a bien été envoyée.'
            );
            //This will be completed after developpement of page fablab presentation
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
