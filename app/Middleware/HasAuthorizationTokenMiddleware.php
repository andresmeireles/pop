<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Action\Authentication\Authenticate;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HasAuthorizationTokenMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly Authenticate $authenticate)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $authorization = $request->getHeader('Authorization');
        $token = str_replace(['Bearer', ' '], '', $authorization[0]);
    }
}
