<?php

declare(strict_types=1);

namespace App\Action\User;

use App\Action\Database\Condition;
use App\Contract\Error\AppErrorInterface;
use App\Contract\Error\CreateUserError;
use App\Contract\Model\UserInterface;
use App\Contract\Repository\UserRepositoryInterface;

final readonly class CreateUser
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function execute(string $name, string $email, string $password, string $confirmPassword): AppErrorInterface|UserInterface
    {
        if ($password !== $confirmPassword) {
            return CreateUserError::PasswordNotMatch;
        }

        $userExists = $this->userRepository->exists(
            Condition::create('email', $email),
            Condition::create('name', $name),
        );

        if ($userExists) {
            return CreateUserError::UserAlreadyExists;
        }

        return $this->userRepository->create([
            'name' => $name,
            'email' => $email,
            'password' => $this->hashPassword($password),
        ]);
    }

    private function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
