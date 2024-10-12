<?php

declare(strict_types=1);

namespace App\Controller;

use App\Bridge\AuthUser;
use App\Contract\Repository\SellerRepositoryInterface;
use App\Middleware\HasAuthorizationTokenMiddleware;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

#[Middleware(middleware: HasAuthorizationTokenMiddleware::class)]
#[Controller]
class SellerController extends AbstractController
{
    #[PostMapping(path: '/seller')]
    public function create(ServerRequestInterface $request, SellerRepositoryInterface $repository, AuthUser $authUser): ResponseInterface
    {
        $name = $request->getParsedBody()['name'];
        $user = $authUser->user()->getId();
        $seller = $repository->create([
            'name' => $name,
            'user_id' => $user,
        ]);

        return $this->response->json(['seller created']);
    }
}
