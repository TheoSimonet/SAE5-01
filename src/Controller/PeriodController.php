<?php

namespace App\Controller;

use App\Entity\Period;
use App\Repository\PeriodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PeriodController extends AbstractController
{
    private $periodRepository;

    public function __construct(PeriodRepository $periodRepository)
    {
        $this->periodRepository = $periodRepository;
    }

    #[Route('/periods', name: 'app_period_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $periods = $this->periodRepository->findAll();

        return $this->json($periods, 200, [], ['groups' => 'period:read']);
    }

    #[Route('/periods/{id}', name: 'app_period_show', methods: ['GET'])]
    public function show(Period $period): JsonResponse
    {
        return $this->json($period, 200, [], ['groups' => 'period:read']);
    }
}
