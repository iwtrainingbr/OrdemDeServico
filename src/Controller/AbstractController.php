<?php

namespace Root\Controller;

class AbstractController
{
    protected function render(string $viewName): void
    {
        include_once "../src/View/template/head.phtml";
        include_once "../src/View/{$viewName}.phtml";
        include_once "../src/View/template/footer.phtml";
    }
}
