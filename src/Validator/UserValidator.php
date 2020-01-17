<?php

declare(strict_types=1);

namespace Root\Validator;

class UserValidator
{
  public static function validateRequest(array $request): bool
  {
    $errors = [];

    if (!isset($_POST['name']) || strlen(trim($_POST['name'])) < 3) {
      $errors[] = 'Nome Inválido. 3 digitos no minimo.';
    }

    if (
      !isset($_POST['email']) ||
      !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
    ) {
      $errors[] = 'Email inválido.';
    }

    if (!isset($_POST['password']) || strlen(trim($_POST['password'])) < 8) {
      $errors[] = 'Senha inválida, precisa de 8 digitos no minimo.';
    }

    if (!empty($errors)) {
      $_SESSION['errors'] = $errors;

      return false;
    }

    return true;
  }
}
