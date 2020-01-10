<?php

use Root\Controller\MainController;
use Root\Controller\UserController;
use Root\Controller\SkillController;
use Root\Controller\AdminController;

function mountRoute(string $controller, string $method): array
{
    return [
      'controller' => $controller,
      'method' => $method,
    ];
}

return [
    '/' => mountRoute(MainController::class, 'index'),
    '/login' => mountRoute(MainController::class, 'login'),
    '/usuarios' => mountRoute(UserController::class, 'list'),
    '/novo-usuario' => mountRoute(UserController::class, 'add'),
    '/habilidades' => mountRoute(SkillController::class, 'list'),
    '/nova-habilidade' => mountRoute(SkillController::class, 'add'),
    '/admin' => mountRoute(AdminController::class, 'dashboard'),
    '/perfil' => mountRoute(UserController::class, 'profile'),
];
