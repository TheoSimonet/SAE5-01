<?php

namespace App\Controller;

use App\Entity\Year;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class YearController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/years", name="year_index")
     */
    public function index(): Response
    {
        $yearRepository = $this->entityManager->getRepository(Year::class);
        $years = $yearRepository->findAll();

        return $this->render('year/index.html.twig', [
            'years' => $years,
        ]);
    }

    /**
     * @Route("/years/{id}", name="year_show", requirements={"id"="\d+"})
     */
    public function show(Year $year): Response
    {
        return $this->render('year/show.html.twig', [
            'year' => $year,
        ]);
    }
}