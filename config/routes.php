<?php

use Root\Controller\Api\SkillApiController;
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
    '/logout' => mountRoute(MainController::class, 'logout'),

    '/usuarios' => mountRoute(UserController::class, 'list'),
    '/novo-usuario' => mountRoute(UserController::class, 'add'),
    '/excluir-usuario' => mountRoute(UserController::class, 'remove'),
    '/editar-usuario' => mountRoute(UserController::class, 'edit'),
    '/usuarios/pdf' => mountRoute(UserController::class, 'pdf'),

    '/habilidades' => mountRoute(SkillController::class, 'list'),
    '/nova-habilidade' => mountRoute(SkillController::class, 'add'),
    '/excluir-habilidade' => mountRoute(SkillController::class, 'remove'),
    '/editar-habilidade' => mountRoute(SkillController::class, 'edit'),

    '/admin' => mountRoute(AdminController::class, 'dashboard'),
    '/perfil' => mountRoute(UserController::class, 'profile'),


    //API
    '/api/habilidade' => mountRoute(SkillApiController::class, 'main'),
];
