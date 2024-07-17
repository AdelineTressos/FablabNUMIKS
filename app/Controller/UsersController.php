<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Reservations;
use App\Form\UserEditType;
use App\Form\UserPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Repository\ReservationsRepository;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[IsGranted('ROLE_USER')]
#[Route('/users')]
class UsersController extends AbstractController
{
    
    #[Route('/{id}', name: 'app_users_show', methods: ['GET'])] 
    public function show(Users $user): Response
    {
        if ($this->getUser() === $user) {
            return $this->render('profile_user/profile.html.twig',[
                'user' => $user,
            ]);
        }

        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/login.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_users_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {   

        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            //persist in person table in DB
            $entityManager->persist($user);
            $entityManager->flush();

            //flash success
            $this->addFlash(
                'success',
                'Vos modifications ont bien été enregistrées. '
            );

            return $this->redirectToRoute('app_users_show', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('/profile_user/edit_profile.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit_password', name: 'app_users_edit_password', methods: ['GET', 'POST'])]
    public function changePassword(
        Request $request, 
        UserPasswordHasherInterface $hasher, 
        Users $user, 
        EntityManagerInterface $entityManager, 
        MailerInterface $mailer
        ): Response
    {
        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('app_login');
        }
        
        $form = $this->createForm(UserPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Check if old password matches
            if (!$hasher->isPasswordValid($user, $form->get('password')->getData())) {
                $this->addFlash('warning', 'Mot de passe actuel incorrect.');
                return $this->redirectToRoute('app_users_edit_password');
            }

            $plainNewPassword = $form->get('newPassword')->getData();

            //Set new password with hasher
            $newPassword = $hasher->hashPassword(
                $user,
                $plainNewPassword
            );
            $user->setPassword($newPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            //template email contact
            $email = (new TemplatedEmail())
            ->from('no-reply@fablab.net')
            ->to($user->getEmail())
            ->subject('Confirmation du changement de mot de passe')

            // path of the Twig template to render
            ->htmlTemplate('emails/change_password_user.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'user' => $user
            ]);

            //send email
            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                var_dump('Erreur : '. $e);
            }

            //flash success
            $this->addFlash(
                'success',
                'Votre mot de passe a bien été modifié.'
            );
            
            return $this->redirectToRoute('app_users_show', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profile_user/edit_user_password.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_users_delete', methods: ['POST'])]
    public function delete(Request $request, Users $user, EntityManagerInterface $entityManager, ReservationsRepository $reservations): Response
    {
        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('app_login');
        }
        
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {

            // $reservations_user = $reservations->findBy(['user' => $this->getUser()]);

            // if ($reservations_user) {
            //     $entityManager->remove($reservations_user);
            // }

            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }

}
