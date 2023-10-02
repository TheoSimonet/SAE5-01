<?php

namespace App\Controller;

use App\Entity\Year;
use App\Form\YearType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/years/new", name="year_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $year = new Year();
        $form = $this->createForm(YearType::class, $year);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($year);
            $this->entityManager->flush();

            return $this->redirectToRoute('year_show', ['id' => $year->getId()]);
        }

        return $this->render('year/new.html.twig', [
            'year' => $year,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/years/{id}/edit", name="year_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Year $year): Response
    {
        $form = $this->createForm(YearType::class, $year);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('year_show', ['id' => $year->getId()]);
        }

        return $this->render('year/edit.html.twig', [
            'year' => $year,
            'form' => $form->createView(),
        ]);
    }
}
