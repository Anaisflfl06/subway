<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Recipe>
 *
 * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipe[]    findAll()
 * @method Recipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    /**
     * Find recipes by a given ingredient.
     * 
     * @param int $ingredientId
     * @return Recipe[]
     */
    public function findByIngredient(int $ingredientId): array
    {
        return $this->createQueryBuilder('r')
            ->join('r.recipeIngrediants', 'ri')
            ->where('ri.ingredient = :ingredientId')
            ->setParameter('ingredientId', $ingredientId)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find recipes that take less than a specified duration.
     * 
     * @param int $duration
     * @return Recipe[]
     */
    public function findByDurationLessThan(int $duration): array
    {
        return $this->createQueryBuilder('r')
            ->where('r.duration < :duration')
            ->setParameter('duration', $duration)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find the most recent recipes, ordered by creation date.
     * 
     * @param int $limit
     * @return Recipe[]
     */
    public function findRecentRecipes(int $limit = 10): array
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.created_at', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Helper method to create the basic query builder for Recipe.
     * 
     * @return QueryBuilder
     */
    private function getBaseQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('r');
    }
}
