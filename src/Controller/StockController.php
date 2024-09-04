<?php
// src/Controller/StockController.php

namespace App\Controller;

use App\Service\StockService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StockController extends AbstractController
{
    private $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    // Les méthodes existantes restent inchangées
    #[Route('/inventory', name: 'stock_list')]
    public function listAll(): Response
    {
        return $this->render('stock/index.html.twig');
    }

}
