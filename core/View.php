<?php

class View
{
    public string $title;
    public string $viewDir;
    public string $filePath;

    public function show(string $page = 'base', array $variables = []): void
    {
        $this->title = ucfirst($page);
        $this->filePath = '/' . $this->viewDir . '/' . $page;

        if (file_exists(ROOT . $this->filePath . '.php')) {
            require_once ROOT . '/views/template/main.php';
        }
        else {
            header("HTTP/1.1 404 Not Found");
        }
    }

    public function render(string $path, array $variables = []): string
    {
        if ($variables) {
            foreach ($variables as $name => $value) {
                $$name = $value;
            }
        }

        require_once ROOT . $path . '.php';
        return '';
    }
}
