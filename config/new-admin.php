<?php

use Root\Adapter\Connection;
use Root\Entity\User;

include_once dirname(__DIR__).'/vendor/autoload.php';
include_once dirname(__DIR__).'/config/database.php';

$entityManager = Connection::getEntityManager();

$user = new User();
$user->setName('Administrador Padrão');
$user->setEmail('admin@email.com');
$user->setPassword(password_hash('12345678', PASSWORD_ARGON2I));
$user->setType('Admin');

$entityManager->persist($user);
$entityManager->flush();

echo PHP_EOL."===============================================".PHP_EOL;
echo PHP_EOL."=== Usuário admin@email.com criado com senha 12345678".PHP_EOL;
echo PHP_EOL."===============================================".PHP_EOL;
