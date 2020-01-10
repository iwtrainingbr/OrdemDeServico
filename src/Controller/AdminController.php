<?php

declare(strict_types=1);

namespace Root\Controller;

class AdminController extends AbstractController
{
    public function dashboard(): void
    {
        $this->render('admin/dashboard');
    }
}
