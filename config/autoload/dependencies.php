<?php

declare(strict_types=1);

use App\Action\Authentication\PersonalAccessToken;
use App\Action\Database\Transaction;
use App\Bridge\AppLogger;
use App\Contract\Bridge\AppLoggerInterface;
use App\Contract\Database\TransactionInterface;
use App\Contract\Model\CustomerInterface;
use App\Contract\Model\PersonalAccessTokenInterface;
use App\Contract\Model\SellerInterface;
use App\Contract\Model\UserInterface;
use App\Contract\Repository\AdditionalRepositoryInterface;
use App\Contract\Repository\CustomerRepositoryInterface;
use App\Contract\Repository\OrderProductRepositoryInterface;
use App\Contract\Repository\OrderRepositoryInterface;
use App\Contract\Repository\PersonalAccessTokenRepositoryInterface;
use App\Contract\Repository\ProductRepositoryInterface;
use App\Contract\Repository\SellerRepositoryInterface;
use App\Contract\Repository\UserRepositoryInterface;
use App\Model\Customer;
use App\Model\PersonalAccessToken as PersonalAccessTokenModel;
use App\Model\Seller;
use App\Model\User;
use App\Repository\AdditionalRepository;
use App\Repository\CustomerRepository;
use App\Repository\OrderProductRepository;
use App\Repository\OrderRepository;
use App\Repository\PersonalAccessTokenRepository;
use App\Repository\ProductRepository;
use App\Repository\SellerRepository;
use App\Repository\UserRepository;
use Psr\Container\ContainerInterface;

use function Hyperf\Config\config;

return [
    ProductRepositoryInterface::class => ProductRepository::class,
    UserRepositoryInterface::class => UserRepository::class,
    SellerRepositoryInterface::class => SellerRepository::class,
    CustomerRepositoryInterface::class => CustomerRepository::class,
    OrderRepositoryInterface::class => OrderRepository::class,
    AdditionalRepositoryInterface::class => AdditionalRepository::class,
    OrderProductRepositoryInterface::class => OrderProductRepository::class,
    PersonalAccessTokenRepositoryInterface::class => PersonalAccessTokenRepository::class,
    UserInterface::class => User::class,
    PersonalAccessTokenInterface::class => PersonalAccessTokenModel::class,
    SellerInterface::class => Seller::class,
    CustomerInterface::class => Customer::class,
    TransactionInterface::class => Transaction::class,
    AppLoggerInterface::class => AppLogger::class,
    PersonalAccessToken::class => fn (ContainerInterface $container) => new PersonalAccessToken(
        config('app_key'),
        $container->get(PersonalAccessTokenRepositoryInterface::class),
    ),
];
