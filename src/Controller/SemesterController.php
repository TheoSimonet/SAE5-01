<?php

namespace App\Controller;

use App\Entity\Semester;
use App\Form\SemesterType;
use App\Repository\SemesterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SemesterController extends AbstractController
{
    #[Route('/semesters', name: 'app_semester')]
    public function index(SemesterRepository $repository): Response
    {
        $semesters = $repository->findAll();

        return $this->render('semester/index.html.twig', [
            'semesters' => $semesters,
        ]);
    }

    #[Route('/semesters/new', name: 'app_semester_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $semester = new Semester();
        $form = $this->createForm(SemesterType::class, $semester);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $semester = $form->getData();

            $manager->persist($semester);
            $manager->flush();

            return $this->redirectToRoute('app_semester');
        }

        return $this->render('/semester/_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/semesters/edit/{id}', 'app_semester_edit', methods: ['GET', 'POST'])]
    public function edit(Semester $semester, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(SemesterType::class, $semester);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            return $this->redirectToRoute('app_semester');
        }

        return $this->render('/semester/_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/semesters/delete/{id}', 'app_semester_delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Semester $semester): Response
    {
        $manager->remove($semester);
        $manager->flush();

        return $this->redirectToRoute('app_semester');
    }
}
