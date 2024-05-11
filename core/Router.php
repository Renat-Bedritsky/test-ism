<?php

class Router
{
    public array $routes;
    public string $uri;
    public string $module = '';
    public string $controller;
    public string $action;
    public array $params = [];
    public array $pathSet;
    private array $coreFiles = ['Asset', 'Controller', 'Model', 'View'];

    public function __construct()
    {
        $this->routes = include(ROOT . '/config/routes.php');
        $this->uri = $_SERVER['REQUEST_URI'];
    }

    public function run()
    {
        foreach ($this->routes as $request => $response) {
            $request = preg_replace('/\//', '\\/', $request);

            if (preg_match("/^\/($request)$/u", $this->uri)) {
                $str = preg_replace("/^\/($request)$/u", $response, $this->uri);
                $this->pathSet = explode('/', $str);

                $controllerDir = $this->setControllerDir($this->pathSet[0]);

                $this->controller = array_shift($this->pathSet);
                $this->action = array_shift($this->pathSet);

                if (!empty($this->pathSet)) {
                    $this->params[] = current($this->pathSet);
                }

                $controllerName = ucfirst($this->controller) . 'Controller';
                $actionName = 'action' . ucfirst($this->action);

                $this->includeCoreFiles();

                include "$controllerDir/$controllerName.php";

                $controller = new $controllerName;
                $controller->view->viewDir = $this->setViewDir();
                $controller->$actionName($this->params);

                break;
            }
        }

        if (!$this->action) {
            header("HTTP/1.1 404 Not Found");
        }
    }

    private function setControllerDir($module): string
    {
        $modulePath = ROOT . '/modules/' . $module;

        if (file_exists($modulePath)){
            $this->module = array_shift($this->pathSet);
            return "modules/$this->module/controllers";
        } else {
            return 'controllers';
        }
    }

    private function setViewDir(): string
    {
        if ($this->module) {
            return 'modules/' . $this->module . '/views/' . $this->controller;
        } else {
            return 'views/' . $this->controller;
        }
    }

    private function includeCoreFiles()
    {
        foreach ($this->coreFiles as $coreFile) {
            require_once "core/$coreFile.php";
        }
    }
}
