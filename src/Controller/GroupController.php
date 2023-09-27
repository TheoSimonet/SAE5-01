<?php

namespace App\Controller;

use App\Entity\Group;
use App\Repository\GroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GroupController extends AbstractController
{
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
}
