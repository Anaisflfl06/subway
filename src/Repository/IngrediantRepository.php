<?php

namespace App\Repository;

use App\Entity\Ingrediant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ingrediant>
 *
 * @method Ingrediant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ingrediant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ingrediant[]    findAll()
 * @method Ingrediant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngrediantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ingrediant::class);
    }

    // Exemple d'une méthode personnalisée pour trouver les ingrédients dont la quantité est inférieure à un certain seuil
    public function findByLowQuantity(float $threshold): array
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.quantity < :threshold')
            ->setParameter('threshold', $threshold)
            ->orderBy('i.quantity', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // Exemple d'une méthode pour trouver tous les ingrédients triés par nom
    public function findAllSortedByName(): array
    {
        return $this->createQueryBuilder('i')
            ->orderBy('i.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}

