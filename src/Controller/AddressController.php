<?php

namespace App\Controller;

use App\Entity\Address;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/address', name: 'address_')]
class AddressController extends AbstractController
{
    #[Route('/{id}/garbage', name: 'garbage')]
    public function showGarbages(Address $address, ?int $limit): Response
    {
        if (!$limit) {
            $limit = count($address->getGarbages());
        }
        return $this->render('address/show_garbages.html.twig', [
            "address" => $address,
            "limit" => $limit,
        ]);
    }
}
