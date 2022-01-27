<?php

namespace App\Controller;

use App\Repository\GarbageRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Garbage;
use App\Form\AdminGarbageType;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use DateTime;
use Doctrine\DBAL\Driver\IBMDB2\Result;
use Doctrine\ORM\EntityManagerInterface;
use DoctrineExtensions\Query\Mysql\Rand;
use Exception;
use Symfony\Component\HttpFoundation\Request;

#[Route('/garbage', name: 'garbage_')]
class GarbageController extends AbstractController
{
    #[Route('/', name: 'index')]
    #[IsGranted('ROLE_USER')]
    public function index(GarbageRepository $garbageRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $garbages = $garbageRepository->findBy([], [
            "createdAt" => "DESC",
        ]);

        $limit = 50;

        return $this->render('garbage/index.html.twig', [
            "garbages" => $garbages,
            "limit" => $limit,
        ]);
    }

    #[Route('/latest', name: 'latest')]
    #[IsGranted('ROLE_USER')]
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
            "user" => $user,
            "garbages" => $garbages,
            "yearlyGarbages" => $yearlyGarbages
        ]);
    }

    #[Route('/new', name: 'add')]
    #[IsGranted('ROLE_ADMIN')]
    public function add(
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        $garbage = new Garbage();
        $form = $this->createForm(AdminGarbageType::class, $garbage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($garbage);
            $entityManager->flush();

            return $this->redirectToRoute('garbage_add', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('garbage/add.html.twig', [
            'garbageAddForm' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'show')]
    #[IsGranted('ROLE_USER')]
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
