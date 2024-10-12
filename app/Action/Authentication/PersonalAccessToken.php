<?php

declare(strict_types=1);

namespace App\Action\Authentication;

use App\Action\Database\Condition;
use App\Contract\Error\AppErrorInterface;
use App\Contract\Error\AuthenticationError;
use App\Contract\Model\PersonalAccessTokenInterface;
use App\Contract\Model\UserInterface;
use App\Contract\Repository\PersonalAccessTokenRepositoryInterface;
use DateTime;
use DateTimeImmutable;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\UnencryptedToken;
use Throwable;

/**
 * TODO: adicionar classe na injecção de dependencias com a string.
 */
final readonly class PersonalAccessToken
{
    public function __construct(
        private string $appKey,
        private PersonalAccessTokenRepositoryInterface $personalAccessTokenRepository,
    ) {
    }

    public function create(UserInterface $user): PersonalAccessTokenInterface
    {
        $key = InMemory::base64Encoded($this->appKey);
        $accessToken = $this->createAccessToken($user);
        $expiresAt = (new DateTimeImmutable())->modify('+1 hour');
        $builder = new Builder(new JoseEncoder(), ChainedFormatter::default());

        $jwt = $builder
            ->issuedBy('http://localhost')
            ->permittedFor((string) $user->getId())
            ->expiresAt($expiresAt)
            ->withClaim('access_token', $accessToken)
            ->getToken(new Sha256(), $key);

        return $this->personalAccessTokenRepository->create([
            'user_id' => $user->getId(),
            'access_token' => $accessToken,
            'jwt' => $jwt->toString(),
            'expires_at' => $expiresAt,
        ]);
    }

    public function parse(string $jwt): AppErrorInterface|UserInterface
    {
        $parser = new Parser(new JoseEncoder());
        $parsedToken = $this->executeParse($parser, $jwt);

        if ($parsedToken === null) {
            return AuthenticationError::InvalidToken;
        }

        if ($parsedToken->isExpired(new DateTime())) {
            return AuthenticationError::ExpiredToken;
        }

        $pat = $this->personalAccessTokenRepository->findBy(
            Condition::create('access_token', $parsedToken->claims()->get('access_token')),
        );

        if (count($pat) === 0) {
            return AuthenticationError::InvalidToken;
        }

        return $pat[0]->getUser();
    }

    private function createAccessToken(UserInterface $user): string
    {
        $now = new DateTimeImmutable();
        $phrase = sprintf('%s%s%s', $user->getId(), $user->getName(), $now->getTimestamp());

        return password_hash($phrase, PASSWORD_DEFAULT);
    }

    private function executeParse(Parser $parser, string $tokenToParse): ?UnencryptedToken
    {
        try {
            return $parser->parse($tokenToParse);
        } catch (Throwable) {
            // TODO: adicionar log aqui
            return null;
        }
    }
}
