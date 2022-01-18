<?php

namespace App\Controller;

use App\Repository\GarbageRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Garbage;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use DateTime;

#[Route('/garbage', name: 'garbage_')]
class GarbageController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(GarbageRepository $garbageRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $garbages = $garbageRepository->findBy([], [
            "createdAt" => "DESC",
        ]);

        return $this->render('garbage/index.html.twig', [
            "garbages" => $garbages,
        ]);
    }

    #[Route('/latest', name: 'latest')]
    public function latest(GarbageRepository $garbageRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        if ($user == null) {
            return $this->redirectToRoute("login");
        }

        $date = new DateTime();
        $garbages = $garbageRepository->findByWeek($date, $user);
        $yearlyGarbages = $garbageRepository->findByYear($date, $user);

        return $this->render('garbage/latest.html.twig', [
            "garbages" => $garbages,
            "yearlyGarbages" => $yearlyGarbages
        ]);
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
