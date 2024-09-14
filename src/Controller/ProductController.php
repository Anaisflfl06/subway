<?php
namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductFromIngredientType;
use App\Form\ProductFromRecipeType;
use App\Form\ProductType;
use App\Service\ProductService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    #[Route('/products', name: 'product_list')]
    public function listAll(): Response
    {
        $products = $this->productService->getAllProducts();
        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/products/create', name: 'product_create')]
    public function createProduct(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productService->createProduct(
                $product->getName(),
                $product->getPrice(),
                $product->getImage()
            );

            $this->addFlash('success', 'Produit ajouté avec succès.');
            return $this->redirectToRoute('product_list');
        }

        return $this->render('product/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/products/{id}', name: 'product_show', methods: ['GET'])]
    public function showDetail(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    
    #[Route('/products/{id}/edit', name: 'product_edit', methods: ['GET', 'POST'])]
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

    #[Route('/products/{id}/delete', name: 'product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, ProductService $productService): Response
    {
        $productService->deleteProduct($product);
        return new Response();
    }


    #[Route('/product/show/{id}', name: 'product_show')]
    public function show(int $id): Response
    {
        $products = $this->productService->getAllProducts();
        // $products = [
        //     ['name' => 'sugar', 'price' => 100]
        // ];
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

   

   
}
