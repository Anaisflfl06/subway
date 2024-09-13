<?php

namespace App\Controller;

use App\Service\BillService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BillController extends AbstractController
{
    private BillService $billService;

    public function __construct(BillService $billService)
    {
        $this->billService = $billService;
    }

    #[Route('/bill', name: 'bill_index', methods: ['GET'])]
    public function index(): Response
    {
        // Récupère la liste des factures récentes via le service
        $bills = $this->billService->getRecentBills();

        return $this->render('bill/index.html.twig', [
            'bills' => $bills,
        ]);
    }

    #[Route('/bill/create', name: 'bill_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $customerName = $request->request->get('customer_name');
            $totalAmount = (float)$request->request->get('total_amount');

            // Vérification des données
            if (empty($customerName) || $totalAmount <= 0) {
                $this->addFlash('error', 'Please provide valid customer name and total amount.');
                return $this->redirectToRoute('bill_create');
            }

            // Créer la facture via le service
            $this->billService->createBill($customerName, $totalAmount);

            // Redirige vers la liste des factures
            return $this->redirectToRoute('bill_index');
        }

        return $this->render('bill/create.html.twig');
    }

    #[Route('/bill/{id}', name: 'bill_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        // Récupère la facture par ID via le service
        $bill = $this->billService->getBillById($id);

        if (!$bill) {
            throw $this->createNotFoundException('The bill does not exist');
        }

        return $this->render('bill/show.html.twig', [
            'bill' => $bill,
        ]);
    }

    #[Route('/bill/{id}/delete', name: 'bill_delete', methods: ['POST'])]
    public function delete(int $id): Response
    {
        $bill = $this->billService->getBillById($id);

        if (!$bill) {
            throw $this->createNotFoundException('The bill does not exist');
        }

        // Supprimer la facture via le service
        $this->billService->deleteBill($id);

        // Redirige vers la liste des factures
        return $this->redirectToRoute('bill_index');
    }
}
