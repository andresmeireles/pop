<?php

declare(strict_types=1);

namespace App\Controller;

use App\Action\Order\Create;
use App\Bridge\AuthUser;
use App\Contract\Repository\SellerRepositoryInterface;
use App\Middleware\HasAuthorizationTokenMiddleware;
use App\Model\Seller;
use App\Request\OrderRequest;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;

#[Middleware(middleware: HasAuthorizationTokenMiddleware::class)]
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
    public function createOrder(
        OrderRequest $request,
        Create $createOrder,
        AuthUser $authUser,
        SellerRepositoryInterface $sellerRepository
    ): ResponseInterface {
        $data = $request->validated();
        if (!array_key_exists('products', $data)) {
            throw ValidationException::withMessages(['products' => 'products not sent']);
        }

        $user = $authUser->user();
        $seller = $sellerRepository->sellerByUserId($user->getId());
        if ($seller === null) {
            return $this->response->json(['error' => 'seller not found']);
        }

        $data['seller'] = $seller->getId();
        $newOrder = $createOrder->execute($data);

        return $this->response->json(['success' => true]);
    }
}
