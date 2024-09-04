<?php
namespace App\Controller;

use App\Entity\Ingrediant;
use App\Form\IngredientType;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IngredientController extends AbstractController
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    #[Route('/ingredients', name: 'ingredient_list')]
    public function listAll(): Response
    {
        return $this->render('ingrediant/index.html.twig');
    }


    #[Route('/ingredient/new', name: 'ingredient_new')]
    public function new(Request $request): Response
    {
        $ingredient = new Ingrediant();
        $form = $this->createForm(IngredientType::class, $ingredient);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productService->createIngredient(
                $ingredient->getName(),
                $ingredient->getQuantity()
            );

            return $this->redirectToRoute('ingredient_success');
        }

        return $this->render('create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/ingredient/success', name: 'ingredient_success')]
    public function success(): Response
    {
        return $this->render('update.html.twig');
    }
}
