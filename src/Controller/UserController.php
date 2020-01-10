<?php

declare(strict_types=1);

namespace Root\Controller;

use Root\Entity\User;
use Root\Validator\UserValidator;

class UserController extends AbstractController
{
    public function add(): void
    {
        if (!$_POST) {
          $this->render('user/add');
          return;
        }

        if (!UserValidator::validateRequest($_POST)) {
          header('location: /novo-usuario');
        }

        //enviar pro banco de dados
    }

    public function list(): void
    {
        $this->render('user/list');
    }

    public function profile(): void
    {
        $this->render('user/profile');
    }
}
