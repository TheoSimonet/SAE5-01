<?php

namespace App\Controller;

use App\Repository\AssignmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AssignmentController extends AbstractController
{
    #[Route('/assignment', name: 'app_assignment')]
    public function index(AssignmentRepository $repository): Response
    {
        $assignments = $repository->findAll();

        return $this->render('assignment/index.html.twig', [
            'assignments' => $assignments,
        ]);
    }
}
