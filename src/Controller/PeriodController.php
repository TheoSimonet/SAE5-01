<?php

namespace App\Controller;

use App\Entity\Period;
use App\Repository\PeriodRepository;
use App\Repository\SemesterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PeriodController extends AbstractController
{
    #[Route('/periods', name: 'app_period')]
    public function index(PeriodRepository $repository): Response
    {
        $periods = $repository->findAll();
        return $this->render('period/index.html.twig', [
            'controller_name' => 'SemesterController',
            'periods' => $periods,
        ]);
    }
}
