<?php

namespace App\Controller;

use App\Repository\GarbageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GarbageController extends AbstractController
{
    #[Route('/garbage', name: 'garbage')]
    public function index(GarbageRepository $garbageRepository): Response
    {
        $allGarbage = $garbageRepository->findById(1);
        $totalGarbage = $allGarbage['nonRecycledWaste'] + $allGarbage['recycledWaste'];
        return $this->render('garbage/index.html.twig', [
            'garbage' => $allGarbage,
            'totalGarbage' => $totalGarbage,
        ]);
    }
}
