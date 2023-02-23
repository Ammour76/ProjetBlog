<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogJeuxController extends AbstractController
{
    #[Route('/blog/jeux', name: 'app_blog_jeux')]
    public function index(): Response
    {
        return $this->render('blog_jeux/index.html.twig', [
            'controller_name' => 'BlogJeuxController',
        ]);
    }
}
