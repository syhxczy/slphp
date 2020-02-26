<?php
namespace syh;

ini_set('display_errors', 'on');

define('START_TIME', microtime(true));
define('ROOTPATH', __DIR__);
define('ROUTEPATH', ROOTPATH . DIRECTORY_SEPARATOR . 'route');

require ROOTPATH . DIRECTORY_SEPARATOR . 'learnphp' . DIRECTORY_SEPARATOR . 'Loader.php';

Loader::register();

Loader::addClassAlias([
    'App'     => Facade\App::class,
    'Request' => Facade\Request::class,
    'Route'   => Facade\Route::class
]);

Container::get('app')->qstart();
