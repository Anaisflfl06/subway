<?php
// src/Controller/SettingsController.php

namespace App\Controller;

use App\Service\SettingsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SettingsController extends AbstractController
{
    private $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    // Les méthodes existantes restent inchangées
    #[Route('/settings', name: 'settings_list')]
    public function listAll(): Response
    {
        return $this->render('settings/index.html.twig');
    }

}
