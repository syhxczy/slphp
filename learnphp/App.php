<?php
namespace syh;
use Request;

class App extends Container
{
    public function qstart()
    {
        $pathInfo = ltrim($_SERVER['REQUEST_URI'], '/');
        $method   = $_SERVER['REQUEST_METHOD'];
        $this->routeInit();
        $route = new \syh\Route;
        $rules = $route->getRule($method);
        if ( !isset($rules) ) die('error');
        $rule = isset($rules[$pathInfo]) ? $rules[$pathInfo] : '';
        if ( !$rule ) die('error');
        $rule  = explode('\\', $rule);
        $fun   = array_pop($rule);
        $class = '\\app\\' . ucfirst($rule[0]) . '\\controller\\' . ucfirst($rule[1]);
        return $this->run([$class, $fun]);
    }

    public function routeInit()
    {
        $routePath = ROUTEPATH . DIRECTORY_SEPARATOR;
        $files     = scandir($routePath);
        foreach ($files as $file) {
            if ( strpos($file, '.php') ) {
                $filename = $routePath . $file;
                $rules = include $filename;
            }
        }
    }
}
