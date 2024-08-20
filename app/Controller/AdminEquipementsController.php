<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminEquipementsController extends AbstractController
{
    #[Route('/admin/equipements', name: 'app_admin_equipements')]
    public function index(): Response
    {
        return $this->render('admin_equipements/index.html.twig', [
            'controller_name' => 'AdminEquipementsController',
        ]);
    }
}
