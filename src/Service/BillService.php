<?php

namespace App\Service;

use App\Entity\Bill;
use Doctrine\ORM\EntityManagerInterface;

class BillService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getRecentBills(): array
    {
        // Récupère les factures les plus récentes, tu peux ajuster cette logique selon tes besoins
        return $this->entityManager->getRepository(Bill::class)->findBy([], ['createdAt' => 'DESC']);
    }

    public function createBill(string $customerName, float $totalAmount): Bill
    {
        $bill = new Bill();
        $bill->setCustomerName($customerName);
        $bill->setTotalAmount($totalAmount);
        $bill->setCreatedAt(new \DateTime());

        $this->entityManager->persist($bill);
        $this->entityManager->flush();

        return $bill;
    }

    public function getBillById(int $id): ?Bill
    {
        return $this->entityManager->getRepository(Bill::class)->find($id);
    }

    public function deleteBill(int $id): void
    {
        $bill = $this->getBillById($id);

        if ($bill) {
            $this->entityManager->remove($bill);
            $this->entityManager->flush();
        }
    }
}
