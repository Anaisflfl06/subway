<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\RecipeIngrediant;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class RecipeController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/recipe/new', name: 'recipe_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($recipe);
            
            // Ajouter les ingrédients à la recette
            $ingredientsData = $form->get('ingredients')->getData();

            foreach ($ingredientsData as $ingredientData) {
                $ingredient = $ingredientData->getIngredient(); // Récupère l'ingrédient associé

                if ($ingredient) {
                    $recipeIngredient = new RecipeIngrediant();
                    $recipeIngredient->setRecipe($recipe);
                    $recipeIngredient->setIngredient($ingredient);
                    $recipeIngredient->setQuantity($ingredientData->getQuantity());

                    $this->entityManager->persist($recipeIngredient);
                } else {
                    return new JsonResponse(['error' => 'Ingredient not found'], Response::HTTP_BAD_REQUEST);
                }
            }

            $this->entityManager->flush();

            return $this->redirectToRoute('recipes_list');
        }

        return $this->render('recipe/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/recipes', name: 'recipes_list')]
    public function list(RecipeRepository $recipeRepository): Response
    {
        $recipes = $recipeRepository->findAll();

        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    #[Route('/recipe/{id}', name: 'recipe_show', methods: ['GET'])]
    public function show(Recipe $recipe): Response
    {
        if (!$recipe) {
            throw $this->createNotFoundException('Recipe not found');
        }

        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }

    #[Route('/recipe/{id}/edit', name: 'recipe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recipe $recipe): Response
    {
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Supprimer les anciens ingrédients liés à la recette
            foreach ($recipe->getIngredients() as $existingRecipeIngredient) {
                $this->entityManager->remove($existingRecipeIngredient);
            }

            // Ajouter les nouveaux ingrédients
            $ingredientsData = $form->get('ingredients')->getData();

            foreach ($ingredientsData as $ingredientData) {
                $ingredient = $ingredientData->getIngredient();

                if ($ingredient) {
                    $recipeIngredient = new RecipeIngrediant();
                    $recipeIngredient->setRecipe($recipe);
                    $recipeIngredient->setIngredient($ingredient);
                    $recipeIngredient->setQuantity($ingredientData->getQuantity());

                    $this->entityManager->persist($recipeIngredient);
                } else {
                    return new JsonResponse(['error' => 'Ingredient not found'], Response::HTTP_BAD_REQUEST);
                }
            }

            $this->entityManager->flush();

            return $this->redirectToRoute('recipes_list');
        }

        return $this->render('recipe/edit.html.twig', [
            'form' => $form->createView(),
            'recipe' => $recipe,
        ]);
    }

    #[Route('/recipe/{id}/delete', name: 'recipe_delete', methods: ['POST'])]
    public function delete(Request $request, Recipe $recipe): Response
    {
        if ($this->isCsrfTokenValid('delete' . $recipe->getId(), $request->request->get('_token'))) {
            // Supprimer la recette et ses ingrédients associés
            foreach ($recipe->getIngredients() as $recipeIngredient) {
                $this->entityManager->remove($recipeIngredient);
            }
            $this->entityManager->remove($recipe);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('recipes_list');
    }
}
