<?php

declare(strict_types=1);

namespace Root\Validator;

class SkillValidator
{
  public static function validateRequest(array $request): bool
  {
    $errors = [];

    if (!isset($_POST['name']) || strlen(trim($_POST['name'])) < 3) {
      $errors[] = 'Nome Inválido. 3 digitos no minimo.';
    }

    if (!isset($_POST['description']) || strlen(trim($_POST['description'])) < 10) {
      $errors[] = 'Descrição Inválida. 10 digitos no minimo.';
    }

    if (!empty($errors)) {
      $_SESSION['errors'] = $errors;

      return false;
    }

    return true;
  }
}
