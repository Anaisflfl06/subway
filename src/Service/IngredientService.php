<?php
namespace App\Service;

use App\Entity\Ingrediant;
use Doctrine\ORM\EntityManagerInterface;

class IngredientService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Créer un nouvel ingrédient
    public function createIngredient(string $name, float $quantity): void
    {
        $ingrediant = new Ingrediant();
        $ingrediant->setName($name);
        $ingrediant->setQuantity($quantity);

        $this->entityManager->persist($ingrediant);
        $this->entityManager->flush();
    }

    // Récupérer tous les ingrédients
    public function getAllIngredients(): array
    {
        return $this->entityManager->getRepository(Ingrediant::class)->findAll();
    }

    // Récupérer un ingrédient par son ID
    public function getIngredientById(int $id): ?Ingrediant
    {
        return $this->entityManager->getRepository(Ingrediant::class)->find($id);
    }

    // Mettre à jour un ingrédient existant
    public function updateIngredient(Ingrediant $ingrediant, string $name, float $quantity): void
    {
        $ingrediant->setName($name);
        $ingrediant->setQuantity($quantity);

        $this->entityManager->flush();
    }

    // Mettre à jour la quantité d'un ingrédient
    public function updateIngredientQuantity(Ingrediant $ingrediant, float $quantity): void
    {
        $ingrediant->setQuantity($quantity);

        $this->entityManager->flush();
    }

    // Supprimer un ingrédient
    public function deleteIngredient(Ingrediant $ingrediant): void
    {
        $this->entityManager->remove($ingrediant);
        $this->entityManager->flush();
    }
}
