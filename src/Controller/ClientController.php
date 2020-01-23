<?php

declare(strict_types=1);

namespace Root\Controller;

use Root\Adapter\Connection;
use Root\Entity\Client;

class ClientController extends AbstractController
{
    private $entityManager;

    public function __construct()
    {
        $this->entityManager = Connection::getEntityManager();
    }

    public function add(): void
    {
        if (!$_POST) {
          $this->render('client/add');
          return;
        }

        $client = new Client();
        $client->setName($_POST['name']);
        $client->setEmail($_POST['email']);
        $client->setPhone($_POST['phone']);

        $this->entityManager->persist($client);
        $this->entityManager->flush();
        header('location: /clientes');
    }

    public function list(): void
    {
        $clients = $this->entityManager->getRepository(Client::class)->findAll();

        $this->render('client/list', $clients);
    }

    public function remove(): void
    {
        $client = $this->entityManager->getRepository(Client::class)->find($_GET['id']);

        if (!$client) {
            $_SESSION['errors'] = ['Cliente não encontrado'];
            header('location: /clientes');
            return;
        }

        $this->entityManager->remove($client);
        $this->entityManager->flush();

        header('location: /clientes');
    }
}
