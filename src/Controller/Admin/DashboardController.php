<?php

namespace App\Controller\Admin;

use App\Entity\Assignment;
use App\Entity\Group;
use App\Entity\Period;
use App\Entity\Semester;
use App\Entity\Subject;
use App\Entity\User;
use App\Entity\Week;
use App\Entity\Wish;
use App\Entity\Year;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administration');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Semestres', 'fas fa-list', Semester::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Affectations', 'fas fa-check-circle', Assignment::class);
        yield MenuItem::linkToCrud('Groupes', 'fas fa-users', Group::class);
        yield MenuItem::linkToCrud('Periodes', 'fa fa-clock-o', Period::class);
        yield MenuItem::linkToCrud('Matieres', 'fas fa-book', Subject::class);
        yield MenuItem::linkToCrud('Voeux', 'fas fa-pencil', Wish::class);
        yield MenuItem::linkToCrud('Années', 'fas fa-hourglass-start', Year::class);
        yield MenuItem::linkToCrud('Semaines', 'fas fa-calendar', Week::class);
    }
}
