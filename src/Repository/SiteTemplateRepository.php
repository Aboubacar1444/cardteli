<?php

namespace App\Repository;

use App\Entity\SiteTemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SiteTemplate>
 *
 * @method SiteTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method SiteTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method SiteTemplate[]    findAll()
 * @method SiteTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SiteTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SiteTemplate::class);
    }

//    /**
//     * @return SiteTemplate[] Returns an array of SiteTemplate objects
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

   public function findOneByID($value): ?SiteTemplate
   {
       return $this->createQueryBuilder('s')
           ->andWhere('s.id = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }


/**
 * @return SiteTemplate[] 
 */

public function findBymodeles(int $page, int $limit = 6): array
    {
        $limit = abs($limit);

        $result = [];
        $query = $this->createQueryBuilder('s')
            
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
}
