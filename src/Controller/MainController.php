<?php

declare(strict_types=1);

namespace Root\Controller;

class MainController extends AbstractController
{
    public function index(): void
    {
        header('location: /admin');
    }

    public function notFound(): void
    {
        $this->render('main/error-not-found');
    }

    public function login(): void
    {
        $this->render('main/login');
    }
}
