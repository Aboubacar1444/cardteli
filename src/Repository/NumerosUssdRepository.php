<?php

namespace App\Repository;

use App\Entity\NumerosUssd;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NumerosUssd>
 *
 * @method NumerosUssd|null find($id, $lockMode = null, $lockVersion = null)
 * @method NumerosUssd|null findOneBy(array $criteria, array $orderBy = null)
 * @method NumerosUssd[]    findAll()
 * @method NumerosUssd[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NumerosUssdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NumerosUssd::class);
    }

    public function save(NumerosUssd $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(NumerosUssd $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return NumerosUssd[] Returns an array of NumerosUssd objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NumerosUssd
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
