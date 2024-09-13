<?php

namespace App\Controller;

use App\Entity\RestaurantSetting;
use App\Form\RestaurantSettingType;
use App\Service\RestaurantSettingService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantSettingController extends AbstractController
{
    private RestaurantSettingService $restaurantSettingService;

    public function __construct(RestaurantSettingService $restaurantSettingService)
    {
        $this->restaurantSettingService = $restaurantSettingService;
    }

    #[Route('/settings', name: 'restaurant_setting_index', methods: ['GET'])]
    public function index(): Response
    {
        $settings = $this->restaurantSettingService->getAllSettings();
        return $this->render('restaurant_setting/index.html.twig', [
            'settings' => $settings,
        ]);
    }

    #[Route('/restaurant-setting/new', name: 'restaurant_setting_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $restaurantSetting = new RestaurantSetting();
        $form = $this->createForm(RestaurantSettingType::class, $restaurantSetting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->restaurantSettingService->save($restaurantSetting);

            return $this->redirectToRoute('restaurant_setting_index');
        }

        return $this->render('restaurant_setting/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/restaurant-setting/{id}', name: 'restaurant_setting_show', methods: ['GET'])]
    public function show(RestaurantSetting $restaurantSetting): Response
    {
        return $this->render('restaurant_setting/show.html.twig', [
            'restaurant_setting' => $restaurantSetting,
        ]);
    }

    #[Route('/restaurant-setting/{id}/edit', name: 'restaurant_setting_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RestaurantSetting $restaurantSetting): Response
    {
        $form = $this->createForm(RestaurantSettingType::class, $restaurantSetting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->restaurantSettingService->save($restaurantSetting);

            return $this->redirectToRoute('restaurant_setting_index');
        }

        return $this->render('restaurant_setting/edit.html.twig', [
            'form' => $form->createView(),
            'restaurant_setting' => $restaurantSetting,
        ]);
    }

    #[Route('/restaurant-setting/{id}', name: 'restaurant_setting_delete', methods: ['POST'])]
    public function delete(Request $request, RestaurantSetting $restaurantSetting): Response
    {
        if ($this->isCsrfTokenValid('delete'.$restaurantSetting->getId(), $request->request->get('_token'))) {
            $this->restaurantSettingService->delete($restaurantSetting);
        }

        return $this->redirectToRoute('restaurant_setting_index');
    }
}
