<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\OrderRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'create_order', methods: [Request::METHOD_POST], format: 'json')]
    public function create(#[MapRequestPayload] OrderRequest $order): JsonResponse
    {
        return $this->json($order);
    }
}
