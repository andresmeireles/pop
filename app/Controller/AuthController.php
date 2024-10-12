<?php

declare(strict_types=1);

namespace App\Controller;

use App\Action\Authentication\Authenticate;
use App\Action\Authentication\PersonalAccessToken;
use App\Action\User\CreateUser;
use App\Contract\Error\AppErrorInterface;
use App\Exception\ApiServerException;
use App\Middleware\HasAuthorizationTokenMiddleware;
use App\Request\CreateUserRequest;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

#[Controller]
class AuthController extends AbstractController
{
    public function __construct(private readonly PersonalAccessToken $personalAccessToken)
    {
    }

    #[PostMapping(path: '/login')]
    public function login(ServerRequestInterface $request, Authenticate $authenticate): ResponseInterface
    {
        $userData = $request->getParsedBody();
        $user = $authenticate->execute($userData['email'], $userData['password']);
        $token = $this->personalAccessToken->create($user);

        return $this->response->json(['token' => $token->getJwt()]);
    }

    #[PostMapping(path: '/signup')]
    public function signUp(
        CreateUserRequest $request,
        PersonalAccessToken $personalAccessToken,
        CreateUser $createUser
    ): ResponseInterface {
        $validated = $request->validated();
        if ($validated === []) {
            return $this->response->json(['error' => 'no data sent']);
        }

        [$name, $email, $password, $confirmPassword] = array_values($request->validated());
        $user = $createUser->execute($name, $email, $password, $confirmPassword);
        if ($user instanceof AppErrorInterface) {
            throw new ApiServerException($user->getMessage());
        }

        $pat = $personalAccessToken->create($user);

        return $this->response->json([$pat->getJwt()]);
    }

    #[Middleware(middleware: HasAuthorizationTokenMiddleware::class)]
    #[GetMapping(path: '/me')]
    public function me(ServerRequestInterface $request): ResponseInterface
    {
        $user = $this->personalAccessToken->parse($request->getHeader('Authorization')[0]);

        return $this->response->json($user);
    }
}
