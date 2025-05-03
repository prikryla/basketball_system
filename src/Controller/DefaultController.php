<?php

namespace App\Controller;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController {
    
    #[Route('/home', name: 'home')]
    public function homepage(): Response{
        return $this->render('base.html.twig');
    }
}