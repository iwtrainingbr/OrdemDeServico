<?php

declare(strict_types=1);

namespace Root\Controller;

use Root\Validator\SkillValidator;

class SkillController extends AbstractController
{
    public function add(): void
    {
        if (!$_POST) {
          $this->render('skill/add');
          return;
        }

        if (!SkillValidator::validateRequest($_POST)) {
          header('location: /nova-habilidade');
        }

        //enviar pro banco
    }

    public function list(): void
    {
        $this->render('skill/list');
    }
}
