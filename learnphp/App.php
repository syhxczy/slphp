<?php
namespace syh;

class App extends Container
{
    public function qstart()
    {
        $this->init();

        $server = $this->request->server;
        $pathInfo = ltrim($server['REQUEST_URI'], '/');
        $method   = $server['REQUEST_METHOD'];
        
        $this->routeInit();
        $dispath = $this->route->dispath($method, $pathInfo);
        if (!$dispath) die('url异常');
        
        return $this->run($dispath['run'], $dispath['data']);
    }

    public function init()
    {
        $configPath = ROOTPATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR;
        // 加载公共文件
        if (is_file($configPath . 'common.php')) {
            include_once $configPath . 'common.php';
        }
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
