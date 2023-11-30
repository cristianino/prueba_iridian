<?php

namespace App\Repository;

use App\Entity\AreaDeContacto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AreaDeContacto>
 *
 * @method AreaDeContacto|null find($id, $lockMode = null, $lockVersion = null)
 * @method AreaDeContacto|null findOneBy(array $criteria, array $orderBy = null)
 * @method AreaDeContacto[]    findAll()
 * @method AreaDeContacto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AreaDeContactoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AreaDeContacto::class);
    }

//    /**
//     * @return AreaDeContacto[] Returns an array of AreaDeContacto objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AreaDeContacto
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
