<?php

namespace App\Service;

use App\Entity\RestaurantSetting;
use App\Repository\RestaurantSettingRepository;
use Doctrine\ORM\EntityManagerInterface;

class RestaurantSettingService
{
    private EntityManagerInterface $entityManager;
    private RestaurantSettingRepository $restaurantSettingRepository;

    public function __construct(EntityManagerInterface $entityManager, RestaurantSettingRepository $restaurantSettingRepository)
    {
        $this->entityManager = $entityManager;
        $this->restaurantSettingRepository = $restaurantSettingRepository;
    }

    public function getAllSettings(): array
    {
        return $this->restaurantSettingRepository->findAll();
    }

    public function save(RestaurantSetting $restaurantSetting): void
    {
        $this->entityManager->persist($restaurantSetting);
        $this->entityManager->flush();
    }

    public function delete(RestaurantSetting $restaurantSetting): void
    {
        $this->entityManager->remove($restaurantSetting);
        $this->entityManager->flush();
    }
}
