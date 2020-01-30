<?php

declare(strict_types=1);

namespace Root\Controller;

use Root\Adapter\Connection;
use Root\Entity\Skill;
use Root\Entity\User;
use Root\Validator\UserValidator;

class UserController extends AbstractController
{
    private $entityManager;

    public function __construct()
    {
        $this->entityManager = Connection::getEntityManager();
    }

    public function add(): void
    {
        if (!$_POST) {
          $this->render('user/add');
          return;
        }

        if (!UserValidator::validateRequest($_POST)) {
            header('location: /novo-usuario');
            return;
        }

        $emailExists = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy([
                'email' => $_POST['email'],
            ]);

        if ($emailExists) {
            $_SESSION['errors'] = [
                'Email já existe',
            ];
            header('location: /novo-usuario');
            return;
        }

        $user = new User();
        $user->setName($_POST['name']);
        $user->setEmail($_POST['email']);
        $user->setPassword(
            password_hash($_POST['password'], PASSWORD_ARGON2I)
        );
        $user->setType('Atendente');

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        header('location: /usuarios');
    }

    public function list(): void
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();

        $this->render('user/list', $users);
    }

    public function profile(): void
    {
        $this->render('user/profile');
    }

    public function remove(): void
    {
        $user = $this->entityManager->getRepository(User::class)->find($_GET['id']);

        if (!$user) {
            $_SESSION['errors'] = ['Usuário não encontrado'];
            header('location: /usuarios');
            return;
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        header('location: /usuarios');
    }

    public function edit(): void
    {
        $user = $this->entityManager
            ->getRepository(User::class)
            ->find($_GET['id']);

        if (!$user) {
            $_SESSION['errors'] = ['Usuário não encontrado'];
            $this->list();
            return;
        }

        if ($_POST) {
            $user->getSkills()->clear();

            foreach ($_POST['skills'] as $skillId) {
                $skill = $this->entityManager
                    ->getRepository(Skill::class)
                    ->find($skillId);

                $user->getSkills()->add($skill);
            }


            $user->setType($_POST['type']);
            $user->setName($_POST['name']);
            $user->setEmail($_POST['email']);
            $user->setStatus(
                $_POST['status'] === 'ativo'?true:false
            );

            if ($_POST['password']) {
                $user->setPassword(
                    password_hash($_POST['password'], PASSWORD_ARGON2I)
                );
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            header('location: /usuarios');
            return;
        }

        $skills = $this
            ->entityManager
            ->getRepository(Skill::class)
            ->findAll();

        $this->render('user/edit', [
            'user' => $user,
            'skills' => $skills,
        ]);
    }
}
