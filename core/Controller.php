<?php

class Controller
{
    public View $view;

    public function __construct()
    {
        $this->view = new View;
    }

    public function render(string $page, array $variables = []): string
    {
        $this->view->show($page, $variables);
        return '';
    }
}
