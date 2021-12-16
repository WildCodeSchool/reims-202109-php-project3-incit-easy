<?php

namespace App\Controller;

use App\Repository\GarbageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Garbage;
use Symfony\Component\Finder\Exception\AccessDeniedException;

#[Route('/garbage', name: 'garbage_')]
class GarbageController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(GarbageRepository $garbageRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('garbage/index.html.twig');
    }

    #[Route('/{id}', name: 'show')]
    public function show(Garbage $garbage): Response
    {
        $user = $this->getUser();
        if ($user !== $garbage->getUser()) {
            throw new AccessDeniedException("Vous n'avez pas le droit d'accéder à ces données.");
        }
        return $this->render('garbage/show.html.twig', [
            'garbage' => $garbage,
        ]);
    }
}
