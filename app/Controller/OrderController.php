<?php

declare(strict_types=1);

namespace App\Controller;

use App\Action\Order\Create;
use App\Model\Seller;
use App\Request\OrderRequest;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;

#[Controller]
class OrderController extends AbstractController
{
    #[GetMapping(path: '/order/seller/{id}')]
    public function orderBySeller(int $sellerId): ResponseInterface
    {
        $seller = Seller::find($sellerId);
        return $this->response->json($seller->orders);
    }

    #[PostMapping(path: '/order')]
    public function createOrder(OrderRequest $request, Create $createOrder): ResponseInterface
    {
        $data = $request->validated();
        if (!array_key_exists('products', $data)) {
            throw ValidationException::withMessages(['products' => 'products not sent']);
        }

        $newOrder = $createOrder->execute($data);

        return $this->response->json(['success' => true]);
    }
}
