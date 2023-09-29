<?php

namespace App\Repository;

use App\Entity\TemplatesCarteVisites;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TemplatesCarteVisites>
 *
 * @method TemplatesCarteVisites|null find($id, $lockMode = null, $lockVersion = null)
 * @method TemplatesCarteVisites|null findOneBy(array $criteria, array $orderBy = null)
 * @method TemplatesCarteVisites[]    findAll()
 * @method TemplatesCarteVisites[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TemplatesCarteVisitesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TemplatesCarteVisites::class);
    }

    public function save(TemplatesCarteVisites $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TemplatesCarteVisites $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return TemplatesCarteVisites[] Returns an array of TemplatesCarteVisites objects
     */
    public function findByCarteExpo(): array
    {
        return $this->createQueryBuilder('t')
            ->orderBy('RAND()')
            ->setMaxResults(12)
            ->getQuery()
            ->getResult();
    }


    public function findBymodeles(int $page, int $limit = 6): array
    {
        $limit = abs($limit);

        $result = [];
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('App\Entity\TemplatesCarteVisites', 't')
            ->setMaxResults($limit)
            ->setFirstResult(($page * $limit) - $limit);
        $paginator = new Paginator($query);
        $data = $paginator->getQuery()->getResult();

        if (empty($data)) {
            return $result;
        }

        $pages = ceil($paginator->count() / $limit);

        $result['data'] = $data;
        $result['pages'] = $pages;
        $result['page'] = $page;
        $result['limit '] = $limit;

        // dd($query->getQuery()->getResult());
        return $result;
    }

    public function findModelesBySearch(string $modele, int $page, int $limit = 6): array
    {
        $limit = abs($limit);

        $result = [];
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('App\Entity\TemplatesCarteVisites', 't')
            ->where('t.titres LIKE :modele')
            ->orWhere('t.descriptions LIKE :modele')
            ->setParameter('modele', "%$modele%")
            ->setMaxResults($limit)
            ->setFirstResult(($page * $limit) - $limit);
        $paginator = new Paginator($query);
        $data = $paginator->getQuery()->getResult();

        if (empty($data)) {
            return $result;
        }

        $pages = ceil($paginator->count() / $limit);

        $result['data'] = $data;
        $result['pages'] = $pages;
        $result['page'] = $page;
        $result['limit '] = $limit;

        // dd($query->getQuery()->getResult());
        return $result;
    }




    //    /**
    //     * @return TemplatesCarteVisites[] Returns an array of TemplatesCarteVisites objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TemplatesCarteVisites
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
