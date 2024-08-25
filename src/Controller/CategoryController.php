<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\ProductCategory;
use App\Repository\ProductCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/product-category', name: 'product_categories', methods: [Request::METHOD_GET])]
    public function index(ProductCategoryRepository $productCategoryRepository): JsonResponse
    {
        return $this->json(['categories' => $productCategoryRepository->findAll()]);
    }

    #[Route('//product-category', name: 'create_product_category', methods: [Request::METHOD_POST], format: 'json')]
    public function createProductCategory(
        #[MapRequestPayload] ProductCategory $productCategory,
        ProductCategoryRepository $productCategoryRepository
    ): JsonResponse {
        $createdProductCategory = $productCategoryRepository->create($productCategory);

        return $this->json(['message' => sprintf('product category %s created', $createdProductCategory->getName())]);
    }
}
