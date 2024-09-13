<?php
namespace App\Controller;

use App\Entity\Stock;
use App\Form\StockType;
use App\Service\StockService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InventoryController extends AbstractController
{
    #[Route('/inventory', name: 'inventory_index', methods: ['GET'])]
    public function index(StockService $stockService): Response
    {
        $stocks = $stockService->getAllStocks();

        return $this->render('inventory/index.html.twig', [
            'stocks' => $stocks,
        ]);
    }

    #[Route('/inventory/new', name: 'inventory_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StockService $stockService): Response
    {
        $form = $this->createForm(StockType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $stockService->createStock($form->getData());
            return $this->redirectToRoute('inventory_index');
        }

        return $this->render('inventory/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/inventory/{id}/edit', name: 'inventory_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Stock $stock, StockService $stockService): Response
    {
        $form = $this->createForm(StockType::class, $stock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $stockService->updateStock($stock);
            return $this->redirectToRoute('inventory_index');
        }

        return $this->render('inventory/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/inventory/{id}/delete', name: 'inventory_delete', methods: ['POST'])]
    public function delete(Request $request, Stock $stock, StockService $stockService): Response
    {
        if ($this->isCsrfTokenValid('delete' . $stock->getId(), $request->request->get('_token'))) {
            $stockService->deleteStock($stock);
        }

        return $this->redirectToRoute('inventory_index');
    }
}
