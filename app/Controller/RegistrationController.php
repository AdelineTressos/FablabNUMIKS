<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use App\Security\Authenticator;
use App\Service\JwtService;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        Security $security,
        EntityManagerInterface $entityManager,
        SendMailService $mail,
        JwtService $jwt,
        UsersRepository $userRepository
    ): Response {

        if ($this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('Password')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // On genere le jwt de l'utilisateur
            // on cree le header
            $header = [
                'type' => 'JWT',
                'alg' => 'HS256',
            ];

            $payload = [
                'id' => $user->getId(),
            ];
            // on genere le token 
            $token = $jwt->gerenate($header, $payload, $this->getParameter('app.jwtsecret'));


            // Envoyez envoie un mail
            $mail->send(
                'no-reply@fablab.net',
                $user->getEmail(),
                "Inscription sur le site du FabLab",
                'register',
                compact('user', 'token')
            );

            // Trouve l'email du fablab grace au username admin:
            $adminUser = $userRepository->findOneBy(['username' => 'admin']);
        if ($adminUser) {
            $adminEmail = $adminUser->getEmail();

            // Informations de l'utilisateur à envoyer au responsable
            $userInfo = [
                'Nom' => $user->getLastName(),
                'Prénom' => $user->getFirstName(),
                'Email' => $user->getEmail(),
                'Téléphone' => $user->getPhone(),
                'Genre' => $user->getGender()->getType(), 
                'Code Postal' => $user->getPostalCode()->getNumber(), 
                'Ville' => $user->getCity()->getNameCity(),
                'Adresse' => $user->getStreet(),
                'Complément d\'adresse' => $user->getAdressComplement(),
                'Est une organisation' => $user->isIsOrganization() ? 'Oui' : 'Non',
                'Numéro de SIRET' => $user->getNumSiret(),
                'Nom de l\'organisation' => $user->getNameOrganization(),
            ];

            $mail->send(
                'no-reply@fablab.net',
                $adminEmail,
                "Nouvelle inscription sur le site du FabLab",
                'admin_notification',
                ['userInfo' => $userInfo]
            );
        }


            return $security->login($user, Authenticator::class, 'main');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    // créer un route pour verifier l'utilisateur 
    #[Route('/verif/{token}', name: 'verify_user')]
    public function verifyUser(
        $token,
        JwtService $jwt,
        UsersRepository $usersRepository,
        EntityManagerInterface $em,
    ): Response {
        //On verifie si le token est valide n'a pas expiré & n'a pas été modifier
        if ($jwt->isValid($token) && !$jwt->isExpired($token) && $jwt->check($token, $this->getParameter('app.jwtsecret'))) {
            // On recupére le payload

            $payload = $jwt->getPayload($token);

            //On recupere le user du token

            $user = $usersRepository->find($payload['id']);

            //On verifie que l'utilisateur existe et n'a pas encore activé son compte

            if ($user && !$user->isIsEmailVerified()) {
                $user->setIsEmailVerified(true);
                $em->flush($user);
                $this->addFlash('success', 'Félicitations le compte à bien été activez ! ');
                return $this->redirectToRoute('app_login');
            }
        }
        // ici un problème se pose dans le token
        $this->addFlash('danger', 'Le token est invalide ou à expiré');
        return $this->redirectToRoute('app_login');
    }

    #[Route('/newVerif', name: 'resend_verif')]
    public function resendVerif(
        JwtService $jwt,
        SendMailService $mail,
        UsersRepository $usersRepository
    ): Response {
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('danger', 'Vous devez être connecté pour accèder à cette page ');
            return $this->redirectToRoute('app_login');
        }

        if ($user->isIsEmailVerified()) {
            $this->addFlash('danger', 'Vous avez déjà verifié votre compte email ');
            return $this->redirectToRoute('app_login');
        }

        // On genere le jwt de l'utilisateur
        // on cree le header
        $header = [
            'type' => 'JWT',
            'alg' => 'HS256',
        ];

        $payload = [
            'id' => $user->getId(),
        ];
        // on genere le token 
        $token = $jwt->gerenate($header, $payload, $this->getParameter('app.jwtsecret'));


        // Envoyez envoie un mail
        $mail->send(
            'no-reply@fablab.net',
            $user->getEmail(),
            "Inscription sur le site du FabLab",
            'register',
            compact('user', 'token')
        );

        $this->addFlash('success', 'Email de vérification envoyé');
        return $this->redirectToRoute('app_login');
    }
}
