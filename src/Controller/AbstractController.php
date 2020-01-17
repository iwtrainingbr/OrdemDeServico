<?php

namespace Root\Controller;

class AbstractController
{
    protected function render(string $viewName, array $data = []): void
    {
        include_once "../src/View/template/head.phtml";
        include_once "../src/View/{$viewName}.phtml";
        include_once "../src/View/template/footer.phtml";
    }
}
