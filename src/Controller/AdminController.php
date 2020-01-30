<?php

declare(strict_types=1);

namespace Root\Controller;

use Root\Adapter\Connection;
use Root\Entity\User;

class AdminController extends AbstractController
{
    private $entityManager;

    public function __construct()
    {
        $this->entityManager = Connection::getEntityManager();
    }

    public function dashboard(): void
    {
        $repository = $this->entityManager->getRepository(User::class);

        $this->render('admin/dashboard', [
            'users_total' => count($repository->findAll()),
            'users_inactive' => count($repository->findBy(['status' => false])),
            'users_attendant' => count($repository->findBy(['type' => 'Atendente'])),
            'users_support' => count($repository->findBy(['type' => 'Técnico'])),
        ]);
    }
}
