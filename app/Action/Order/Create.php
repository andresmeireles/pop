<?php

declare(strict_types=1);

namespace App\Action\Order;

use App\Contract\Bridge\AppLoggerInterface;
use App\Contract\Database\TransactionInterface;
use App\Contract\Error\AppErrorInterface;
use App\Contract\Error\OrderError;
use App\Contract\Model\CustomerInterface;
use App\Contract\Model\SellerInterface;
use App\Contract\Repository\AdditionalRepositoryInterface;
use App\Contract\Repository\CustomerRepositoryInterface;
use App\Contract\Repository\OrderProductRepositoryInterface;
use App\Contract\Repository\OrderRepositoryInterface;
use App\Contract\Repository\ProductRepositoryInterface;
use App\Contract\Repository\SellerRepositoryInterface;
use App\Model\Order;
use Exception;
use Throwable;

readonly class Create
{
    public function __construct(
        private SellerRepositoryInterface $sellerRepository,
        private CustomerRepositoryInterface $customerRepository,
        private ProductRepositoryInterface $productRepository,
        private OrderRepositoryInterface $orderRepository,
        private AdditionalRepositoryInterface $additionalRepository,
        private OrderProductRepositoryInterface $orderProductRepository,
        private TransactionInterface $transaction,
        private AppLoggerInterface $logger,
    ) {
    }

    /**
     * @param array{
     *     seller: int,
     *     customer: int,
     *     products: array<int, array{id: int, value: float, quantity: int}>,
     *     additionals?: array<int, array{name: string, addition: bool, value: float}>
     * } $orderData
     */
    public function execute(array $orderData): AppErrorInterface|Order
    {
        $this->transaction->beginTransaction();
        try {
            $seller = $this->sellerRepository->byId($orderData['seller']);
            $customer = $this->customerRepository->byId($orderData['customer']);
            $order = $this->createOrder($customer, $seller);
            $this->addProductsToOrder($orderData['products'], $order);
            $this->addAdditionalToOrder($orderData['additionals'], $order);
            $this->transaction->commit();

            return $order;
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
            $this->transaction->rollBack();

            return OrderError::CreateOrderError;
        }
    }

    private function createOrder(CustomerInterface $customer, SellerInterface $seller): Order
    {
        return $this->orderRepository->create([
            'customer_id' => $customer->getId(),
            'seller_id' => $seller->getId(),
        ]);
    }

    /**
     * @param array<int, array{id: int, value: float, quantity: int}> $products
     * @throws Exception
     */
    private function addProductsToOrder(array $products, Order $order): void
    {
        array_walk(
            $products,
            function (array $p) use ($order) {
                $product = $this->productRepository->byId($p['id']);
                if ($product === null) {
                    throw new Exception('product not found: ' . $p['id']);
                }

                $this->orderProductRepository->create([
                    'order_id' => $order->getId(),
                    'product_id' => $product->getId(),
                    'amount' => $p['value'],
                    'quantity' => $p['quantity'],
                ]);
            }
        );
    }

    /**
     * @param array<int, array{name: string, addition: bool, value: float}> $products
     */
    private function addAdditionalToOrder(array $products, Order $order): void
    {
        array_walk(
            $products,
            fn (array $p) => $this->additionalRepository->create([
                'name' => $p['name'],
                'value' => $p['value'],
                'addition' => $order['addition'],
                'order_id' => $order->getId(),
            ])
        );
    }
}
