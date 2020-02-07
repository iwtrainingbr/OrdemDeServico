<?php

declare(strict_types=1);

namespace Root\Security;

use Root\Entity\User;

class PermissionSecurity
{
    public static function isLogged(): bool
    {
        return isset($_SESSION['user_logged']);
    }

    public static function userHasPermission(string $userType): void
    {
        $user = $_SESSION['user_logged'] ?? false;

        if ($user) {
            $user = unserialize($user, ['class' => User::class]);
        }

        if (!$user || $user->getType() !== $userType) {
            $_SESSION['errors'] = ['Você não ter permissão'];
            header('location: /');
            exit;
        }
    }
}