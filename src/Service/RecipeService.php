<?php
namespace App\Service;

use App\Entity\Recipe;
use App\Entity\Ingrediant;
use App\Entity\RecipeIngrediant;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\IngredientService;

class RecipeService
{
    private $entityManager;
    private $ingredientService;

    public function __construct(EntityManagerInterface $entityManager, IngredientService $ingredientService)
    {
        $this->entityManager = $entityManager;
        $this->ingredientService = $ingredientService;
    }

    // Créer une nouvelle recette avec une liste d'ingrédients
    public function createRecipe(string $name, int $duration, array $ingredients): Recipe
    {
        $recipe = new Recipe();
        $recipe->setName($name);
        $recipe->setDuration($duration);
        $recipe->setCreatedAt(new \DateTimeImmutable());
        $recipe->setUpdatedAt(new \DateTimeImmutable());

        foreach ($ingredients as $ingredientData) {
            // Vérifier si l'ingrédient existe déjà, sinon, le créer
            $ingredient = $this->ingredientService->getIngredientById($ingredientData['id']) ?? 
                          $this->ingredientService->createIngredient($ingredientData['name'], $ingredientData['quantity']);

            $recipeIngredient = new RecipeIngrediant();
            $recipeIngredient->setRecipe($recipe);
            $recipeIngredient->setIngredient($ingredient);
            $recipeIngredient->setQuantity($ingredientData['quantity']);
            $recipeIngredient->setCreatedAt(new \DateTimeImmutable());
            $recipeIngredient->setUpdatedAt(new \DateTimeImmutable());

            $this->entityManager->persist($recipeIngredient);
        }

        $this->entityManager->persist($recipe);
        $this->entityManager->flush();

        return $recipe;
    }

    // Récupérer une recette par son ID
    public function getRecipeById(int $id): ?Recipe
    {
        return $this->entityManager->getRepository(Recipe::class)->find($id);
    }

    // Récupérer les ingrédients associés à une recette
    public function getIngredientsForRecipe(Recipe $recipe): array
    {
        return $this->entityManager->getRepository(RecipeIngrediant::class)->findBy(['recipe' => $recipe]);
    }

    // Mettre à jour les ingrédients d'une recette
    public function updateRecipeIngredients(Recipe $recipe, array $newIngredients): Recipe
    {
        // Supprimer les anciens ingrédients de la recette
        $existingIngredients = $this->entityManager->getRepository(RecipeIngrediant::class)->findBy(['recipe' => $recipe]);

        foreach ($existingIngredients as $recipeIngredient) {
            $this->entityManager->remove($recipeIngredient);
        }

        // Ajouter les nouveaux ingrédients
        foreach ($newIngredients as $ingredientData) {
            $ingredient = $this->ingredientService->getIngredientById($ingredientData['id']) ?? 
                          $this->ingredientService->createIngredient($ingredientData['name'], $ingredientData['quantity']);

            $recipeIngredient = new RecipeIngrediant();
            $recipeIngredient->setRecipe($recipe);
            $recipeIngredient->setIngredient($ingredient);
            $recipeIngredient->setQuantity($ingredientData['quantity']);
            $recipeIngredient->setCreatedAt(new \DateTimeImmutable());
            $recipeIngredient->setUpdatedAt(new \DateTimeImmutable());

            $this->entityManager->persist($recipeIngredient);
        }

        $recipe->setUpdatedAt(new \DateTimeImmutable());
        $this->entityManager->flush();

        return $recipe;
    }

    // Supprimer une recette
    public function deleteRecipe(Recipe $recipe): void
    {
        $this->entityManager->remove($recipe);
        $this->entityManager->flush();
    }
}
