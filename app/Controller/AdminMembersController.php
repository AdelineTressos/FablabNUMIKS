<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\AdminMemberType;
use App\Repository\UsersRepository;
use App\Repository\ReservationsRepository;
use App\Repository\ParticipantsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\SendMailService;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
// use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/members')]
 // #[IsGranted('ROLE_ADMIN')]
class AdminMembersController extends AbstractController
{
    #[Route('/', name: 'app_admin_members')]
    public function index(UsersRepository $usersRepository): Response
    {
        return $this->render('admin_members/index.html.twig', [
            'controller_name' => 'AdminMembersController',
            'nonValidatedUsers' => $usersRepository->findBy(['is_validated' => false or NULL, 'is_visitor' => false or NULL]),
            'validatedUsers' => $usersRepository->findBy(['is_validated' => true]),
        ]);
    }
    #[Route('/show/{id}', name: 'app_admin_show', methods: ['GET'])]
    public function show(Users $user, ReservationsRepository $reservationsRepository, ParticipantsRepository $participantsRepository): Response
    {
        $reservations = $reservationsRepository->findBy(['user' => $user]);
        $participations = $reservationsRepository->findBy(['user' => $user]);

        $events = [];
        foreach ($participations as $participation) {
            $events[] = $participation->getEvent();
        }

        return $this->render('admin_members/oneMember.html.twig', [
            'user' => $user,
            'reservations' => $reservations,
            'events' => $events,
            'participations' => $participations
        ]);
    }

    #[Route('/edit/{id}', name: 'app_admin_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, Users $user, EntityManagerInterface $entityManager, SendMailService $mail): Response
{
    $form = $this->createForm(AdminMemberType::class, $user,  [
        'is_edit_mode' => true, // On est en mode édition, donc true
    ]);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $wasValidated = $user->isIsValidated(); // En supposant que vous avez cette méthode getter

        $entityManager->flush();

        if (!$wasValidated && $user->isIsValidated()) {
            $mail->send(
                'no-reply@fablab.net',
                $user->getEmail(),
                "Adhésion au FabLab",
                'validated_member',
                ['user' => $user]
            );
        }

        $this->addFlash('success', 'L\'adhésion a été modifiée avec succès.');
        return $this->redirectToRoute('app_admin_members', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('admin_members/editMember.html.twig', [
        'memberForm' => $form->createView(),
    ]);
}


    // Delete
    #[Route('/delete/{id}', name: 'app_admin_delete', methods: ['POST'])]
    public function delete(Users $user, EntityManagerInterface $entityManager): Response
    {

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_members', [], Response::HTTP_SEE_OTHER);
    }

    // create
    #[Route('/new', name: 'app_admin_new', methods: ['GET', 'POST'])]
    public function new( Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, SendMailService $mail): Response
    {
        $user = new Users();
        $form = $this->createForm(AdminMemberType::class, $user,  [
            'is_edit_mode' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(["ROLE_USER"]);
            $user->setIsValidated(true);
            $password = bin2hex(random_bytes(8)); // Génération du mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);
          
            $entityManager->persist($user);
            $entityManager->flush();

            $mail->send(
                'no-reply@fablab.net',
                $user->getEmail(),
                "Inscription sur le site du FabLab",
                'create_member',
                compact('user', 'password')
            );

            $this->addFlash('success', 'Nouvelle adhésion créée avec succès.');
            return $this->redirectToRoute('app_admin_members');
        }

        return $this->render('admin_members/newMember.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }
}

