<?php
// src/Controller/UserController.php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Les méthodes existantes restent inchangées
    #[Route('/users', name: 'user_list')]
    public function listAll(): Response
    {
        return $this->render('user/index.html.twig');
    }

}
