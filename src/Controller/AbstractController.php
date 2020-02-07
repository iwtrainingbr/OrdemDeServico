<?php

namespace Root\Controller;

abstract class AbstractController
{
    protected function render(string $viewName, array $data = []): void
    {
        include_once "../src/View/template/head.phtml";

        if (isset($_SESSION['user_logged'])) {
            include_once "../src/View/template/navbar.phtml";
        }

        include_once "../src/View/{$viewName}.phtml";
        include_once "../src/View/template/footer.phtml";
    }
}
