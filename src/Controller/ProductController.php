<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/product', methods: [Request::METHOD_GET])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->json(['products' => $productRepository->findAll()]);
    }

    #[Route('/product', name: 'product_create', methods: [Request::METHOD_POST], format: 'json')]
    public function create(#[MapRequestPayload] Product $product, ProductRepository $productRepository): JsonResponse
    {
        $createdProduct = $productRepository->create($product);

        return $this->json([
            'message' => sprintf('Product %s created', $createdProduct->getName()),
        ]);
    }
}
