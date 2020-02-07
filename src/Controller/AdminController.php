<?php

declare(strict_types=1);

namespace Root\Controller;

use Doctrine\ORM\Query\ResultSetMapping;
use Root\Adapter\Connection;
use Root\Entity\User;
use Root\Security\PermissionSecurity;

class AdminController extends AbstractController
{
    private $entityManager;

    public function __construct()
    {
        $this->entityManager = Connection::getEntityManager();
    }

    public function dashboard(): void
    {
        PermissionSecurity::userHasPermission('Admin');

        $repository = $this->entityManager->getRepository(User::class);

        /*$rsm = new ResultSetMapping();
        $rsm->addEntityResult(User::class, 'u');
        $rsm->addFieldResult('u', 'id', 'id');
        $rsm->addFieldResult('u', 'name', 'name');
        $rsm->addFieldResult('u', 'status', 'status');
        $rsm->addFieldResult('u', 'createdAt', 'createdAt');

        var_dump($this->entityManager->createNativeQuery('SELECT * FROM User u;', $rsm)->getResult());*/

        /*$qb = $this->entityManager->createQueryBuilder();
        $qb
            ->select(User::class)
            ->setMaxResults(5)
            ->orderBy('createdAt', 'desc');*/

        $lastUsers = $this->entityManager->getConnection()->prepare(
            "SELECT * FROM User ORDER BY createdAt DESC LIMIT 5"
        );
        $lastUsers->execute();

        $this->render('admin/dashboard', [
            'users_total' => count($repository->findAll()),
            'users_inactive' => count($repository->findBy(['status' => false])),
            'users_attendant' => count($repository->findBy(['type' => 'Atendente'])),
            'users_support' => count($repository->findBy(['type' => 'Técnico'])),
            'last_users' => $lastUsers->fetchAll(),
        ]);
    }
}
