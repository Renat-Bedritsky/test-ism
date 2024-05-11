<?php

class Asset
{
    public string $path = '';
    public array $css = [];
    public array $js = [];

    public function __construct()
    {
        if ($this->path === '') pdd('$resource not specified');
        if ($this->css) $this->registerCss();
        if ($this->js) $this->registerJs();
    }

    private function registerCss()
    {
        foreach ($this->css as $css) {
            echo "<link rel='stylesheet' href='/$this->path/$css'>";
        }
    }

    private function registerJs()
    {
        foreach ($this->js as $js) {
            echo "<script defer src='/$this->path/$js'></script>";
        }
    }
}