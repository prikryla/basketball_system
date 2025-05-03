<?php

namespace App\Controller;

use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController {
    
    #[Route('homepage')]
    public function homepage(): Response{
        return $this->render('homepage.html.twig');
    }
}