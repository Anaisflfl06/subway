<?php
namespace App\Service;

use App\Entity\Stock;
use Doctrine\ORM\EntityManagerInterface;

class StockService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllStocks(): array
    {
        return $this->entityManager->getRepository(Stock::class)->findAll();
    }

    public function createStock(Stock $stock): void
    {
        $this->entityManager->persist($stock);
        $this->entityManager->flush();
    }

    public function updateStock(Stock $stock): void
    {
        $this->entityManager->flush();
    }

    public function deleteStock(Stock $stock): void
    {
        $this->entityManager->remove($stock);
        $this->entityManager->flush();
    }
}

