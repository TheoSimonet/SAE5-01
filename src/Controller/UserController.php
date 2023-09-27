<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/user/{id}', name: 'app_user_show', requirements: ['id' => '\d+'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user/{id}/edit', name: 'app_user_edit', requirements: ['id' => '\d+'])]
    public function edit(ManagerRegistry $doctrine, Request $request, User $user): Response
    {
        $form = $this->createForm(userType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setFirstname($form->getData()->getFirstname());
            $user->setLastname($form->getData()->getLastname());
            $user->setEmail($form->getData()->getEmail());
            $user->setAddress($form->getData()->getAddress());

            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_user_show', [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('user/_form.html.twig', [
            'advertisement' => $user,
            'form' => $form->createView(),
        ]);
    }


}
