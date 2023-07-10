<?php

namespace App\Repository;

use App\Entity\PacksAvantages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PacksAvantages>
 *
 * @method PacksAvantages|null find($id, $lockMode = null, $lockVersion = null)
 * @method PacksAvantages|null findOneBy(array $criteria, array $orderBy = null)
 * @method PacksAvantages[]    findAll()
 * @method PacksAvantages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PacksAvantagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PacksAvantages::class);
    }

    public function save(PacksAvantages $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PacksAvantages $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PacksAvantages[] Returns an array of PacksAvantages objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PacksAvantages
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
