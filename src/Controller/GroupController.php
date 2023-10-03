<?php

namespace App\Controller;

use App\Entity\Group;
use App\Form\GroupType;
use App\Repository\GroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class GroupController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/groups', name: 'group_index')]
    public function index(GroupRepository $groupRepository): Response
    {
        $groups = $groupRepository->findAll();

        return $this->render('group/index.html.twig', [
            'groups' => $groups,
        ]);
    }

    #[Route('/groups/{id}', name: 'group_show')]
    public function show(Group $group): Response
    {
        return $this->render('group/show.html.twig', [
            'group' => $group,
        ]);
    }

    #[Route('/groups/{id}/edit', name: 'group_edit')]
    public function edit(Request $request, Group $group): Response
    {
        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('group_show', ['id' => $group->getId()]);
        }

        return $this->render('group/edit.html.twig', [
            'group' => $group,
            'form' => $form->createView(),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/react', name: 'app_react')]
    #[Route('/react/groups', name: 'app_react_groups')]
    #[Route('/react/groups/{id}', name: 'app_react_group', requirements: ['id' => '\d+'])]
    public function react(): Response
    {
        return $this->render('group/react.html.twig');
    }

    #[Route('/api/groups', name: 'group_list', methods: ['GET'])] // Ajout de la route pour la liste des groupes en GET
    public function list(GroupRepository $groupRepository): JsonResponse
    {
        $groups = $groupRepository->findAll();

        return $this->json($groups, Response::HTTP_OK, [], ['groups' => 'group:read']);
    }

    #[Route('/api/groups', name: 'group_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $group = new Group();
        $form = $this->createForm(GroupType::class, $group);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($group);
            $this->entityManager->flush();

            return $this->json($group, Response::HTTP_CREATED);
        }

        return $this->json($form->getErrors(true, false), Response::HTTP_BAD_REQUEST);
    }
}
