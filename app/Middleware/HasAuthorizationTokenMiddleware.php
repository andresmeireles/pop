<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Action\Authentication\PersonalAccessToken;
use App\Contract\Model\UserInterface;
use App\Exception\InvalidBearerTokenException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HasAuthorizationTokenMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly PersonalAccessToken $personalAccessToken)
    {
    }

    /**
     * @throws InvalidBearerTokenException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $hasAuthToken = $request->hasHeader('Authorization');
        if (!$hasAuthToken) {
            throw new InvalidBearerTokenException();
        }

        $authorization = $request->getHeader('Authorization');
        $token = str_replace(['Bearer', ' '], '', $authorization[0]);
        $user = $this->personalAccessToken->parse($token);

        if (!$user instanceof UserInterface) {
            throw new InvalidBearerTokenException();
        }

        return $handler->handle($request);
    }
}
