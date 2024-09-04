<?php
// src/Controller/BillController.php

namespace App\Controller;

use App\Service\BillService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BillController extends AbstractController
{
    private $billService;

    public function __construct(BillService $billService)
    {
        $this->billService = $billService;
    }

    // Les méthodes existantes restent inchangées
    #[Route('/bill', name: 'bill_list')]
    public function listAll(): Response
    {
        return $this->render('bill/index.html.twig');
    }

}
