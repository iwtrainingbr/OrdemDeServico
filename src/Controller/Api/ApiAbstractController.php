<?php

declare(strict_types=1);

namespace Root\Controller\Api;

abstract class ApiAbstractController
{
    public function response($data): void
    {
        echo json_encode($data);
    }
}