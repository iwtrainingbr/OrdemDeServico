<?php

declare(strict_types=1);

namespace Root\Controller;

use Dompdf\Dompdf;
use Root\Adapter\Connection;
use Root\Entity\Skill;
use Root\Entity\User;
use Root\Security\PermissionSecurity;
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
        PermissionSecurity::userHasPermission('Admin');

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
        PermissionSecurity::userHasPermission('Admin');

        $users = $this->entityManager->getRepository(User::class)->findAll();

        $this->render('user/list', $users);
    }

    public function profile(): void
    {
        $this->render('user/profile');
    }

    public function remove(): void
    {
        PermissionSecurity::userHasPermission('Admin');

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
        PermissionSecurity::userHasPermission('Admin');

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

    public function pdf(): void
    {
        PermissionSecurity::userHasPermission('Admin');

        $users = $this->entityManager->getRepository(User::class)->findAll();

        $tbody = '';
        foreach ($users as $user) {
            $tbody .= "
                <tr>
                    <td>{$user->getName()}</td>
                    <td>{$user->getEmail()}</td>
                    <td>{$user->getCreatedAt()->format('d/m/Y H:i:s')}</td>
                </tr>
            ";
        }

        $today = date('d/m/Y H:i:s');

        $html = "
            <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css'>
            
            <h1>Relatório de Usuários</h1>
            <p>
                <strong>Gerado em: </strong>{$today}
            </p>
                
            <hr>
            
            <table class='table table-striped'>
                <thead class='thead-dark'>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Cadastrado em</th>
                </thead>
                <tbody>
                    <tr></tr>
                    {$tbody}
                </tbody>
            </table>
        ";

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        $dompdf->render();

        $filename = 'relatorios-usuarios-'.date('Ymd-His').'.pdf';

        $dompdf->stream($filename, [
            'Attachment' => 0,
        ]);
    }
}
