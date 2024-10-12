<?php

declare(strict_types=1);

namespace App\Action;

use App\Action\Database\Condition;
use App\Contract\Model\ProductInterface;
use App\Contract\Repository\ProductRepositoryInterface;
use App\Exception\ApiServerException;
use Exception;

class AddProduct
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
    ) {
    }

    /**
     * @param array{name: string, height: string, original_value: string, color: string} $productData
     * @throws ApiServerException
     */
    public function execute(array $productData): ProductInterface
    {
        $product = $this->productRepository->findBy(
            [
                Condition::create('name', $productData['name']),
                Condition::create('height', $productData['height']),
                Condition::create('color', $productData['color']),
            ]
        );

        if ($product !== []) {
            throw new ApiServerException('Product exists');
        }

        return $this->productRepository->create($productData);
    }
}
