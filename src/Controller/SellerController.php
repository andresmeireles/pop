<?php

declare(strict_types=1);

namespace App\Controller;

use App\Action\Seller\Manage;
use App\Exception\ApiException;
use App\Repository\SellerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class SellerController extends AbstractController
{
    #[Route('/seller', name: 'api_seller', methods: [Request::METHOD_GET])]
    public function index(SellerRepository $sellerRepository): JsonResponse
    {
        return $this->json(['sellers' => $sellerRepository->findAll()]);
    }

    /**
     * @throws ApiException
     */
    #[Route('/seller', name: 'create_seller', methods: [Request::METHOD_POST])]
    public function create(Request $request, Manage $sellerManage): JsonResponse
    {
        $sellerName = $request->getPayload()->getString('name');
        $user = $request->request->get('user');

        $createdSeller = $sellerManage->add($sellerName);
        if (null !== $user) {
            $sellerManage->bindToUser($createdSeller->getId(), (int) $user);
        }

        return $this->json([
            'message' => sprintf(
                'User %s was created',
                $createdSeller->getName()
            ),
        ]);
    }
}
