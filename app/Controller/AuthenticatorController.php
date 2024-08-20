<?php

namespace App\Controller;

use App\Form\ResetPasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use App\Repository\UsersRepository;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthenticatorController extends AbstractController
{
    #[Route(path: '/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('cities'); Sécurité au cas ou que l'on soit déjà connecté 
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/deconnexion', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/oublie-pass', name: 'forgotten-password')]
    public function forgottenPassword(
        Request $request,
        UsersRepository $usersRepository,
        TokenGeneratorInterface $tokenGenerator,
        EntityManagerInterface $em,
        SendMailService $mail


    ): Response {
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //cherche son utilisateur par email verif
            $user = $usersRepository->findOneByEmail($form->get('email')->getData());

            if ($user) {
                // Génère un token de réinitialisation
                $token = $tokenGenerator->generateToken();

                $user->setResetToken($token);
                $em->persist($user);
                $em->flush();

                // Genere l'url  pour le mail et envoi du mail
                $url = $this->generateUrl(
                    'reset_pass',
                    ['token' => $token],
                    UrlGeneratorInterface::ABSOLUTE_URL
                );

                // On crée les données du mail
                $context = compact('url', 'user');

                // envoi du mail
                $mail->send(
                    'no-reply@be.fr',
                    $user->getEmail(),
                    'Réinitialiser votre mot de passe',
                    'password_reset',
                    $context,
                );

                $this->addFlash('success', 'Email à été correctement envoyez');
                return $this->redirectToRoute('app_login');
            }
            $this->addFlash("danger", "Un problème est survenu veulliez recommencer");
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset_password_request.html.twig', [
            'requestPassForm' => $form->createView(),
        ]);
    }

    #[Route('/oublie-pass/{token}', name: 'reset_pass')]
    public function resetPass(
        string $token,
        Request $request,
        UsersRepository $usersRepository,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        // Verifie si le token est dans la bdd 
        $user = $usersRepository->findOneByResetToken($token);

        if ($user) {
            $form = $this->createForm(ResetPasswordFormType::class);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                // on efface le token
                $user->setResetToken('');
                $user->setPassword(
                    $passwordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    ));
                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'Mot de passe modifié avec succes!');
                return $this->redirectToRoute('app_login');
            }

            return $this->render('security/reset_password.html.twig', [
                'passForm' => $form->createView()
            ]);
        }
        $this->addFlash("danger", "Jeton invalide");
        return $this->redirectToRoute('app_login');
    }
}
