<?php

namespace App\Controller;

use App\Entity\Period;
use App\Form\PeriodType;
use App\Repository\PeriodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;


class PeriodController extends AbstractController
{
    #[Route('/periods', name: 'app_period')]
    public function index(PeriodRepository $repository): Response
    {
        $periods = $repository->findAll();
        return $this->render('period/index.html.twig', [
            'controller_name' => 'PeriodController',
            'periods' => $periods,
        ]);
    }

    #[Route('/periods/new', name: 'app_period_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $period = new Period();
        $form = $this->createForm(PeriodType::class, $period);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($period);
            $manager->flush();

            return $this->redirectToRoute('app_period');
        }

        return $this->render('period/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/periods/edit/{id}', name: 'app_period_edit', methods: ['GET', 'POST'])]
    public function edit(Period $period, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(PeriodType::class, $period);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            return $this->redirectToRoute('app_period');
        }

        return $this->render('period/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
