<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contracts\Repository\SellerRepositoryInterface;
use App\Entity\Seller;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Seller>
 */
class SellerRepository extends ServiceEntityRepository implements SellerRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Seller::class);
    }

    public function byId(mixed $id): ?Seller
    {
        return $this->find($id);
    }

    public function create(string $name): Seller
    {
        $seller = new Seller();
        $seller->setName($name);
        $this->getEntityManager()->persist($seller);
        $this->getEntityManager()->flush();

        return $seller;
    }

    public function bindToUser(Seller $seller, User $user): void
    {
        $seller->setUser($user);
        $this->getEntityManager()->flush();
    }

    //    /**
    //     * @return Seller[] Returns an array of Seller objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Seller
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
