<?php

namespace App\Controller;

use App\Repository\GarbageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(GarbageRepository $garbageRepository): Response
    {
        $user = $this->getUser();
        if ($user) {
            $garbages = $garbageRepository->findByUser($user);
            $garbage = end($garbages);
            $id = $garbage->getId();
            return $this->redirectToRoute("garbage_show", [
                "id" => $id,
            ]);
        } else {
            return $this->redirectToRoute("login");
        }
    }
}
