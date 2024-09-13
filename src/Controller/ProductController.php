<?php
namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductFromIngredientType;
use App\Form\ProductFromRecipeType;
use App\Service\ProductService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'product_index', methods: ['GET'])]
    public function index(ProductService $productService): Response
    {
        $products = $productService->getAllProducts();

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/new/from-ingredient', name: 'product_new_from_ingredient', methods: ['GET', 'POST'])]
    public function newFromIngredient(Request $request, ProductService $productService): Response
    {
        $form = $this->createForm(ProductFromIngredientType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData(); // Ceci retourne une instance de Product
            $ingredients = $form->get('ingredients')->getData(); // Récupère les ingrédients sélectionnés
            $productService->createProductFromIngredient($product, $ingredients);
            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new_from_ingredient.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/product/new/from-recipe', name: 'product_new_from_recipe', methods: ['GET', 'POST'])]
    public function newFromRecipe(Request $request, ProductService $productService): Response
    {
        $form = $this->createForm(ProductFromRecipeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $productService->createProductFromRecipe($product, $form->get('recipe')->getData());
            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new_from_recipe.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/product/{id}', name: 'product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/product/{id}/edit', name: 'product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, ProductService $productService): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productService->updateProduct($product);
            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/product/{id}/delete', name: 'product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, ProductService $productService): Response
    {
        // Vérifie la validité du token CSRF pour la suppression
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $productService->deleteProduct($product);
        }

        // Redirige vers la liste des produits après la suppression
        return $this->redirectToRoute('product_index');
    }
}
