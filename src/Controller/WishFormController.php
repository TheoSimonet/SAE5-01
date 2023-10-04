<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishFormController extends AbstractController
{
    #[Route('/wish/form', name: 'app_wish_form')]
    public function index(): Response
    {
        return $this->render('wish_form/index.html.twig', [
            'controller_name' => 'WishFormController',
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/react', name: 'app_react')]
    #[Route('/react/semesters', name: 'app_react_semesters')]
    #[Route('/react/semesters/{id}', name: 'app_react_semester', requirements: ['id' => '\d+'])]
    public function react(): Response
    {
        return $this->render('home/react.html.twig');
    }
}
