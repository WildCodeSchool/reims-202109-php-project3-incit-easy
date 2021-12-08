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
        $garbage = $garbageRepository->findOneById(1);
        $totalGarbage =  $garbage->getNonRecycledWaste() + $garbage->getRecycledWaste();
        return $this->render('garbage/index.html.twig', [
            'garbage' => $garbage,
            'totalGarbage' => $totalGarbage,
        ]);
    }
}
