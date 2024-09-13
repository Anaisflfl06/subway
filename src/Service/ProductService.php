<?php
namespace App\Service;

use App\Entity\Product;
use App\Entity\ProductAssociation;
use App\Entity\Ingrediant;
use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    private $entityManager;
    private $ingredientService;
    private $recipeService;

    public function __construct(EntityManagerInterface $entityManager, IngredientService $ingredientService, RecipeService $recipeService)
    {
        $this->entityManager = $entityManager;
        $this->ingredientService = $ingredientService;
        $this->recipeService = $recipeService;
    }

    // Créer un produit générique
    public function createProduct(string $name, float $price, string $image): Product
    {
        $product = new Product();
        $product->setName($name);
        $product->setPrice($price);
        $product->setImage($image);
        $product->setCreatedAt(new \DateTimeImmutable());
        $product->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }

    // Récupérer tous les produits
    public function getAllProducts(): array
    {
        return $this->entityManager->getRepository(Product::class)->findAll();
    }

    // Associer un produit avec un ingrédient
    public function associateProductWithIngredient(Product $product, Ingrediant $ingrediant): void
    {
        $productAssociation = new ProductAssociation();
        $productAssociation->setProduct($product);
        $productAssociation->setAssociatedId($ingrediant->getId());
        $productAssociation->setAssociatedType('ingredient');
        $productAssociation->setCreatedAt(new \DateTimeImmutable());
        $productAssociation->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($productAssociation);
        $this->entityManager->flush();
    }

    // Associer un produit avec une recette
    public function associateProductWithRecipe(Product $product, Recipe $recipe): void
    {
        $productAssociation = new ProductAssociation();
        $productAssociation->setProduct($product);
        $productAssociation->setAssociatedId($recipe->getId());
        $productAssociation->setAssociatedType('recipe');
        $productAssociation->setCreatedAt(new \DateTimeImmutable());
        $productAssociation->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($productAssociation);
        $this->entityManager->flush();
    }

    // Acheter un produit (soit ingrédient, soit recette)
    public function buyProduct(Product $product): string
    {
        $associations = $this->entityManager->getRepository(ProductAssociation::class)->findBy(['product' => $product]);

        foreach ($associations as $association) {
            if ($association->getAssociatedType() === 'ingredient') {
                $ingredient = $this->ingredientService->getIngredientById($association->getAssociatedId());
                if ($ingredient->getQuantity() > 0) {
                    $this->ingredientService->updateIngredientQuantity($ingredient, $ingredient->getQuantity() - 1);
                    return 'Ingredient bought successfully!';
                } else {
                    return 'Ingredient out of stock!';
                }
            } elseif ($association->getAssociatedType() === 'recipe') {
                $recipe = $this->recipeService->getRecipeById($association->getAssociatedId());
                $ingredients = $this->recipeService->getIngredientsForRecipe($recipe);

                $enoughStock = true;
                foreach ($ingredients as $recipeIngredient) {
                    $ingredient = $recipeIngredient->getIngredient();
                    if ($ingredient->getQuantity() < $recipeIngredient->getQuantity()) {
                        $enoughStock = false;
                        break;
                    }
                }

                if ($enoughStock) {
                    foreach ($ingredients as $recipeIngredient) {
                        $ingredient = $recipeIngredient->getIngredient();
                        $ingredient->setQuantity($ingredient->getQuantity() - $recipeIngredient->getQuantity());
                    }

                    $this->entityManager->flush();
                    return 'Recipe bought successfully!';
                } else {
                    return 'Not enough stock for the recipe ingredients.';
                }
            }
        }

        return 'Unsupported product type for purchase.';
    }

    // Créer un produit à partir d'un ingrédient
    public function createProductFromIngredient(Product $product, Ingrediant $ingredient): Product
    {
        $this->createProduct($product->getName(), $product->getPrice(), $product->getImage());
        $this->associateProductWithIngredient($product, $ingredient);
        return $product;
    }

    // Créer un produit à partir d'une recette
    public function createProductFromRecipe(Product $product, Recipe $recipe): Product
    {
        $this->createProduct($product->getName(), $product->getPrice(), $product->getImage());
        $this->associateProductWithRecipe($product, $recipe);
        return $product;
    }

    // Mettre à jour un produit
    public function updateProduct(Product $product): Product
    {
        $product->setUpdatedAt(new \DateTimeImmutable());
        $this->entityManager->flush();
        return $product;
    }

    // Supprimer un produit
    public function deleteProduct(Product $product): void
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }
}
