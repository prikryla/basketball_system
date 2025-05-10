<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Entity\Cities;
use App\Entity\Drivers;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return $this->render('dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('BBK Blansko')
            ->setLocales(['en']);
    }

    public function configureMenuItems(): iterable
    {   
        return [ 
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::linkToCrud('Users', 'fa fa-user', Users::class),
            MenuItem::linkToCrud('Cities', 'fa fa-city', Cities::class),
            MenuItem::linkToCrud('Drivers', 'fa fa-user', Drivers::class)
        ];
    }
}