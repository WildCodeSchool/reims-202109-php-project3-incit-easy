<?php

namespace App\Controller;

use App\Entity\Address;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/address', name: 'address_')]
class AddressController extends AbstractController
{
    #[Route('/{id}/garbage', name: 'garbage')]
    #[IsGranted('ROLE_USER')]
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
