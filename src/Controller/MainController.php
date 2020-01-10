<?php

declare(strict_types=1);

namespace Root\Controller;

class MainController extends AbstractController
{
    public function index(): void
    {
        echo '<h1>Página Inicial</h1>';
    }

    public function notFound(): void
    {
        echo '<h1>Página não encontrada</h1>';
    }

    public function login(): void
    {
        $this->render('main/login');
    }
}
