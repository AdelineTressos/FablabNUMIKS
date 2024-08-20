<?php
// Simon il est mauvais
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\MachinesRepository;
use App\Entity\Machines;
use App\Form\MachinesType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class AdminMachinesController extends AbstractController
{

    #[Route('/admin/machines', name: 'app_admin_machines')]
    public function index(MachinesRepository $machinesRepository): Response
    {
        $allMachines = $machinesRepository->findAll();
        $memberAccessMachines = $machinesRepository->findBy(['member_access' => true]);
        $bookedMachines = $machinesRepository->findBy(['is_booked' => true]);

        return $this->render('admin_machines/index.html.twig', [
            'allMachines' => $allMachines,
            'memberAccessMachines' => $memberAccessMachines,
            'bookedMachines' => $bookedMachines,
        ]);
    }


    #[Route('/admin/machines/new', name: 'admin_machines_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $machine = new Machines();
        $form = $this->createForm(MachinesType::class, $machine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($imageFile = $form->get('machine_picture')->getData()) {
                $imageFileName = $fileUploader->upload($imageFile);
                $machine->setMachinePicture($imageFileName);
            }

            $entityManager->persist($machine);
            $entityManager->flush();

            $this->addFlash('success', 'La machine a été ajoutée');
            return $this->redirectToRoute('app_admin_machines');
        }

        return $this->render('admin_machines/new.html.twig', [
            'machine' => $machine,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/machines/{id}', name: 'admin_machines_show', methods: ['GET'])]
    public function show(Machines $machine): Response
    {
        return $this->render('admin_machines/show.html.twig', [
            'machine' => $machine,
        ]);
    }

    #[Route('/admin/machines/edit/{id}', name: 'admin_machines_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Machines $machine, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $originalImage = $machine->getMachinePicture(); 

        $form = $this->createForm(MachinesType::class, $machine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($imageFile = $form->get('machine_picture')->getData()) {

                if ($originalImage) {
                    $fileUploader->remove($originalImage);
                }

                $imageFileName = $fileUploader->upload($imageFile);
                $machine->setMachinePicture($imageFileName);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Machine mise à jour avec succès.');

            return $this->redirectToRoute('app_admin_machines');
        }

        return $this->render('admin_machines/edit.html.twig', [
            'machine' => $machine,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/machines/delete/{id}', name: 'admin_machines_delete', methods: ['POST'])]
    public function delete(Request $request, Machines $machine, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $machine->getId(), $request->request->get('_token'))) {

            $imageFileName = $machine->getMachinePicture();
            if ($imageFileName) {
                $imageFilePath = $this->getParameter('targetDirectory') . '/' . $imageFileName;
                if (file_exists($imageFilePath)) {
                    unlink($imageFilePath);
                }
            }

            $entityManager->remove($machine);
            $entityManager->flush();

            $this->addFlash('success', 'Machine supprimée avec succès.');
        }

        return $this->redirectToRoute('app_admin_machines');
    }
}
