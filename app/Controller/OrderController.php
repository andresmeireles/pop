<?php

declare(strict_types=1);

namespace App\Controller;

use App\Action\Order\Create;
use App\Contract\Error\AppErrorInterface;
use App\Contract\Repository\SellerRepositoryInterface;
use App\Exception\OrderException;
use App\Middleware\HasAuthorizationTokenMiddleware;
use App\Request\OrderRequest;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;

#[Middleware(middleware: HasAuthorizationTokenMiddleware::class)]
#[Controller(prefix: '/order')]
class OrderController extends AbstractController
{
    #[Inject]
    private SellerRepositoryInterface $sellerRepository;

    #[GetMapping(path: 'seller/{sellerId}')]
    public function orderBySeller(int $sellerId): ResponseInterface
    {
        $seller = $this->sellerRepository->byId($sellerId);
        if ($seller === null) {
            return $this->response->json(['error' => 'vendedor nao encontrado']);
        }

        return $this->response->json($seller->getOrders());
    }

    /**
     * @throws OrderException
     */
    #[PostMapping(path: '')]
    public function createOrder(OrderRequest $request, Create $createOrder): ResponseInterface
    {
        $data = $request->validated();
        if (!array_key_exists('products', $data)) {
            throw ValidationException::withMessages(['products' => 'products not sent']);
        }

        if (!array_key_exists('additionals', $data)) {
            $data['additionals'] = [];
        }

        $user = $this->authUser->user();
        $seller = $this->sellerRepository->sellerByUserId($user->getId());

        if ($seller === null) {
            return $this->response->json(['error' => 'seller not found']);
        }

        $data['seller'] = $seller->getId();
        $newOrder = $createOrder->execute($data);

        if ($newOrder instanceof AppErrorInterface) {
            throw new OrderException($newOrder->getMessage());
        }

        return $this->response->json(['message' => 'pedido criado com sucesso'])->withStatus(201);
    }
}
