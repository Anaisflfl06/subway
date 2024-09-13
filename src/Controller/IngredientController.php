<?php

namespace App\Controller;

use App\Entity\Ingrediant;
use App\Form\IngredientType;
use App\Service\IngredientService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IngredientController extends AbstractController
{
    private $ingredientService;

    public function __construct(IngredientService $ingredientService)
    {
        $this->ingredientService = $ingredientService;
    }

    // Liste tous les ingrédients
    #[Route('/ingredients', name: 'ingredient_list')]
    public function listAll(): Response
    {
        $ingredients = $this->ingredientService->getAllIngredients();

        return $this->render('ingredient/index.html.twig', [
            'ingredients' => $ingredients,
        ]);
    }

    // Ajoute un nouvel ingrédient
    #[Route('/ingredient/new', name: 'ingredient_new')]
    public function new(Request $request): Response
    {
        $ingredient = new Ingrediant();
        $form = $this->createForm(IngredientType::class, $ingredient);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->ingredientService->createIngredient(
                $ingredient->getName(),
                $ingredient->getQuantity()
            );

            $this->addFlash('success', 'Ingrédient ajouté avec succès.');
            return $this->redirectToRoute('ingredient_list');
        }

        return $this->render('ingredient/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Édite un ingrédient existant
    #[Route('/ingredient/{id}/edit', name: 'ingredient_edit')]
    public function edit(Request $request, int $id): Response
    {
        $ingredient = $this->ingredientService->getIngredientById($id);

        if (!$ingredient) {
            throw $this->createNotFoundException('Ingrédient non trouvé');
        }

        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->ingredientService->updateIngredient(
                $ingredient,
                $ingredient->getName(),
                $ingredient->getQuantity()
            );

            $this->addFlash('success', 'Ingrédient mis à jour avec succès.');
            return $this->redirectToRoute('ingredient_list');
        }

        return $this->render('ingredient/edit.html.twig', [
            'form' => $form->createView(),
            'ingredient' => $ingredient,
        ]);
    }

    // Supprime un ingrédient
    #[Route('/ingredient/{id}/delete', name: 'ingredient_delete')]
    public function delete(int $id): Response
    {
        $ingredient = $this->ingredientService->getIngredientById($id);

        if ($ingredient) {
            $this->ingredientService->deleteIngredient($ingredient);
            $this->addFlash('success', 'Ingrédient supprimé avec succès.');
        } else {
            $this->addFlash('error', 'Ingrédient non trouvé.');
        }

        return $this->redirectToRoute('ingredient_list');
    }
}
