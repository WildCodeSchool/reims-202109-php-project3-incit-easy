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
use Exception;

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

        if ($user->getAddress() == null) {
            throw new Exception();
        }

        $date = new DateTime();
        $garbages = $garbageRepository->findByWeek($date, $user->getAddress());
        $yearlyGarbages = $garbageRepository->findByYear($date, $user->getAddress());

        return $this->render('garbage/latest.html.twig', [
            "garbages" => $garbages,
            "yearlyGarbages" => $yearlyGarbages
        ]);
    }

    #[Route('/{id}', name: 'show')]
    public function show(Garbage $garbage): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if ($user == null) {
            return $this->redirectToRoute("login");
        }

        if (!in_array($user, ($garbage->getAddress()?->getUsers()->toArray()) ?? [])) {
            throw new AccessDeniedException("Vous n'avez pas le droit d'accéder à ces données.");
        }

        return $this->render('garbage/show.html.twig', [
            'garbage' => $garbage,
        ]);
    }
}
