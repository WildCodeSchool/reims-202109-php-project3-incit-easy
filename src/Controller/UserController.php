<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/{id}', name: 'show')]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/garbage', name: 'garbage')]
    public function showGarbages(User $user, ?int $limit): Response
    {
        if (!$limit) {
            $limit = count($user->getGarbages());
        }
        return $this->render('user/show_garbages.html.twig', [
            "user" => $user,
            "limit" => $limit,
        ]);
    }
}
