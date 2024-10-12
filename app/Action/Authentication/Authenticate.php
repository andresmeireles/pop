<?php

declare(strict_types=1);

namespace App\Action\Authentication;

use App\Action\Database\Condition;
use App\Contract\Error\AppErrorInterface;
use App\Contract\Error\AuthenticationError;
use App\Contract\Model\UserInterface;
use App\Contract\Repository\UserRepositoryInterface;

final readonly class Authenticate
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function execute(string $email, string $password): AppErrorInterface|UserInterface
    {
        $users = $this->userRepository->findBy(Condition::create('email', $email));
        if ($users === []) {
            return AuthenticationError::CredentialsNotMatch;
        }

        $user = $users[0];
        if (!$this->validatePassword($user->getPassword(), $password)) {
            return AuthenticationError::CredentialsNotMatch;
        }

        return $user;
    }

    private function validatePassword(string $hashedPassword, string $password): bool
    {
        return password_verify($password, $hashedPassword);
    }
}
