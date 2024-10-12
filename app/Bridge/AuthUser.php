<?php

declare(strict_types=1);

namespace App\Bridge;

use App\Action\Authentication\PersonalAccessToken;
use App\Contract\Model\UserInterface;
use Hyperf\Context\Context;
use Psr\Http\Message\ServerRequestInterface;

readonly class AuthUser
{
    public function __construct(private PersonalAccessToken $personalAccessToken)
    {
    }

    public function user(): UserInterface
    {
        $request = Context::get(ServerRequestInterface::class);
        $token = str_replace(['Bearer', ' '], '', $request->getHeader('Authorization')[0]);

        return $this->personalAccessToken->parse($token);
    }
}
