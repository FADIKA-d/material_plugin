<?php

namespace App\Repository;

use App\Entity\Material;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Material>
 *
 * @method Material|null find($id, $lockMode = null, $lockVersion = null)
 * @method Material|null findOneBy(array $criteria, array $orderBy = null)
 * @method Material[]    findAll()
 * @method Material[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Material::class);
    }

    //    /**
    //     * @return Material[] Returns an array of Material objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Material
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findByCritaria(
        int $offset,
        int $limit,
        string $column,
        string $dir,
        string $search
    ): ?array {
        $query = $this->createQueryBuilder('m');

        if ($search) {
            $query->andWhere('m.name LIKE :search')
                ->setParameter('search', "%{$search}%");
        }
        
        $query->andWhere('m.quantity > 0');

        return $query->orderBy("m.{$column}", $dir)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()->getResult();
        ;

    }

    public function getTotalRecords(): int
    {
        return $this->createQueryBuilder("m")->select('count(m.id)')->getQuery()->getSingleScalarResult();
    }
    public function countByFilteredRecords($search): int
    {
        return $this->createQueryBuilder("m")->select('count(m.id)')->where('m.name LIKE :search')
        ->setParameter('search', "%{$search}%")->getQuery()->getSingleScalarResult();
    }
    // public function update(int $id): Material
    // {
    // }
}
