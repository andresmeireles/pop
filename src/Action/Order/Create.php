<?php

declare(strict_types=1);

namespace App\Action\Order;

use App\Contracts\Repository\CustomerRepositoryInterface;
use App\Contracts\Repository\SellerRepositoryInterface;
use App\Exceptions\ApiException;
use Symfony\Component\HttpFoundation\JsonResponse;

class Create
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
        private SellerRepositoryInterface $sellerRepository,
    ) {
    }

    /**
     * @param array{
     *     customer: int,
     *     products: array<int, array{product: int, quantity: int, value: float}>,
     *     additionals: array<int, array{name: string, value: int, additional: bool}>,
     *     seller: int
     * } $orderData
     */
    public function handle(array $orderData): JsonResponse
    {
        $customer = $this->customerRepository->byId($orderData['customer']);
        if (null === $customer) {
            throw new ApiException('Customer not found');
        }

        $seller = $this->sellerRepository->byId($orderData['seller']);
        if (null === $seller) {
            throw new ApiException('Seller not found');
        }

        return new JsonResponse('User created successfully');
    }
}
