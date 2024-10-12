<?php

declare(strict_types=1);

namespace App\Action\Order;

use App\Contract\Bridge\AppLoggerInterface;
use App\Contract\Database\TransactionInterface;
use App\Contract\Model\CustomerInterface;
use App\Contract\Model\SellerInterface;
use App\Contract\Repository\AdditionalRepositoryInterface;
use App\Contract\Repository\CustomerRepositoryInterface;
use App\Contract\Repository\OrderProductRepositoryInterface;
use App\Contract\Repository\OrderRepositoryInterface;
use App\Contract\Repository\ProductRepositoryInterface;
use App\Contract\Repository\SellerRepositoryInterface;
use App\Exception\OrderException;
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
     * @throws OrderException
     */
    public function execute(array $orderData): Order
    {
        $this->transaction->beginTransaction();
        try {
            $seller = $this->sellerRepository->byId($orderData['seller']);
            $customer = $this->customerRepository->byId($orderData['customer']);
            $order = $this->createOrder($customer, $seller);
            $this->addProductsToOrder($order, $orderData['products']);
            $this->addAdditionalToOrder($order, $orderData['additionals']);
            $this->transaction->commit();

            return $order;
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
            $this->transaction->rollBack();

            throw new OrderException('error when create order', context: [
                'messages' => $e->getMessage(),
            ]);
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
    private function addProductsToOrder(Order $order, array $products): void
    {
        array_walk(
            $products,
            function (array $p) use ($order) {
                $product = $this->productRepository->byId($p['product_id']);
                if ($product === null) {
                    throw new Exception('product not found: ' . $p['product_id']);
                }

                $this->orderProductRepository->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'amount' => $p['value'],
                    'quantity' => $p['quantity'],
                ]);
            }
        );
    }

    /**
     * @param array<int, array{name: string, addition: bool, value: float}> $products
     */
    private function addAdditionalToOrder(Order $order, array $products): void
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
