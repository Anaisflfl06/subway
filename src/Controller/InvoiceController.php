<?php
// src/Controller/InvoiceController.php

namespace App\Controller;

use App\Service\InvoiceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceController extends AbstractController
{
    private $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    // Les méthodes existantes restent inchangées
    #[Route('/invoices', name: 'invoice_list')]
    public function listAll(): Response
    {
        return $this->render('invoice/index.html.twig');
    }

}
