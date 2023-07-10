<?php

namespace App\Repository;

use App\Entity\NumerosUssdRelations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NumerosUssdRelations>
 *
 * @method NumerosUssdRelations|null find($id, $lockMode = null, $lockVersion = null)
 * @method NumerosUssdRelations|null findOneBy(array $criteria, array $orderBy = null)
 * @method NumerosUssdRelations[]    findAll()
 * @method NumerosUssdRelations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NumerosUssdRelationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NumerosUssdRelations::class);
    }

    public function save(NumerosUssdRelations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(NumerosUssdRelations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return NumerosUssdRelations[] Returns an array of NumerosUssdRelations objects
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

//    public function findOneBySomeField($value): ?NumerosUssdRelations
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
