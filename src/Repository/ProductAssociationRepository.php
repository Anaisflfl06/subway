<?php
namespace App\Repository;

use App\Entity\ProductAssociation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductAssociation>
 */
class ProductAssociationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductAssociation::class);
    }

    /**
     * @return ProductAssociation[] Returns an array of ProductAssociation objects
     */
    public function findAssociationsByProduct(int $productId): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.product = :productId')
            ->setParameter('productId', $productId)
            ->getQuery()
            ->getResult();
    }

    // Add other custom queries as needed
}
