<?php

declare(strict_types=1);

namespace Root\Controller\Api;

use Root\Adapter\Connection;
use Root\Entity\Skill;

class SkillApiController extends ApiAbstractController
{
    private $entityManager;
    private $repository;

    public function __construct()
    {
        header('Content-Type: application/json');
        $this->entityManager = Connection::getEntityManager();
        $this->repository = $this->entityManager->getRepository(Skill::class);
    }

    public function main(): void
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->get();
                break;

            case 'POST':
                $this->post();
                break;

            default:
                $this->response([
                    'error' => 'Metodo não permitido',
                ]);
        }
    }

    public function post(): void
    {
        $json = json_decode(file_get_contents('php://input'));

        $skill = new Skill();
        $skill->setName($json->name);
        $skill->setDescription($json->description);

        $this->entityManager->persist($skill);
        $this->entityManager->flush();

        $this->response([
            'message' => 'Habilidade cadastrada',
        ]);
    }

    public function get(): void
    {
        $skills = $this->repository->findAll();

        $json = [];

        foreach ($skills as $skill) {
            $json[] = $skill->getValues();
        }

        $this->response($json);
    }
}