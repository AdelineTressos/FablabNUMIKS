<?php

namespace App\Controller\VisitorEspace;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PublicationsRepository;



class RouteHomeController extends AbstractController
{
    /**
     * 
     *  @Route vers toutes les pages de redirections espaces members clients
     * 
     */

    #[Route('/', name: 'app_route_home')]
    public function index(): Response
    {
        return $this->render('visitor/index.html.twig', [
            'controller_name' => 'RouteHomeController',
        ]);
    }

    #[Route('/articles', name: 'app_route_articles')]
    public function articles(PublicationsRepository $publicationsRepository): Response
    {
        $publications = $publicationsRepository->findAllPublishedOrderedByDateDesc();

        return $this->render('visitor/articles/index.html.twig', [
            'publications' => $publications,
        ]);
    }

}
