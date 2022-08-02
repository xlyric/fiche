<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Fiche;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    public function __construct( 
        private AdminUrlGenerator $adminUrlGenerator 
        )    {
        
            
    }


    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
        ->setController(FicheCrudController::class)
        ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administration des Fiches');
    }

    public function configureMenuItems(): iterable
    {
        return [
        MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
        
        MenuItem::section('Fiches'),
        MenuItem::linkToCrud('Fiches', 'fa fa-database', Fiche::class),
        MenuItem::linkToCrud('Categorie', 'fa fa-database', Categorie::class),

        MenuItem::section('Users'),
        MenuItem::linkToCrud('Users', 'fa fa-user', User::class)
        ];
    }
}
