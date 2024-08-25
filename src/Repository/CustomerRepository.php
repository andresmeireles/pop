<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contracts\Repository\CustomerRepositoryInterface;
use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Customer>
 */
class CustomerRepository extends ServiceEntityRepository implements CustomerRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    public function byId(int $id): Customer
    {
        return $this->find($id);
    }

    public function create(Customer $customer): Customer
    {
        $this->getEntityManager()->persist($customer);
        $this->getEntityManager()->flush();

        return $customer;
    }
}
