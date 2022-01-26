<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/profile', name: 'profile_')]
class ProfileController extends AbstractController
{
    #[Route('/{id}', name: 'show')]
    #[IsGranted('ROLE_USER')]
    public function show(User $user): Response
    {
        return $this->render('profile/show.html.twig', [
            'user' => $user,
            'limit' => 6,
        ]);
    }
}
