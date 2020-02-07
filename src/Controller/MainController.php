<?php

declare(strict_types=1);

namespace Root\Controller;

use Root\Adapter\Connection;
use Root\Entity\User;
use Root\Security\PermissionSecurity;

class MainController extends AbstractController
{
    private $entityManager;

    public function __construct()
    {
        $this->entityManager = Connection::getEntityManager();
    }

    public function index(): void
    {
        if (!PermissionSecurity::isLogged()) {
            header('location: /login');
            return;
        }

        header('location: /admin');
    }

    public function notFound(): void
    {
        $this->render('main/error-not-found');
    }

    public function login(): void
    {
        if (PermissionSecurity::isLogged()) {
            $_SESSION['errors'] = ['Você já está logado'];
            header('location: /');
            return;
        }

        if ($_POST) {
            $user = $this
                ->entityManager
                ->getRepository(User::class)
                ->findOneBy(['email' => $_POST['email']]);

            if (!$user) {
                $_SESSION['errors'] = ['Usuário não encontrado'];
                header('location: /login');
                return;
            }

            if (!password_verify($_POST['password'], $user->getPassword())) {
                $_SESSION['errors'] = ['Senha Incorreta'];
                header('location: /login');
                return;
            }

            if ($user->isStatus() === false) {
                $_SESSION['errors'] = ['Usuário Bloqueado'];
                header('location: /login');
                return;
            }

            $_SESSION['user_logged'] = serialize($user);
            header('location: /');
            return;
        }

        $this->render('main/login');
    }

    public function logout(): void
    {
        session_destroy();
        header('location: /login');
    }
}
