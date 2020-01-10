<?php
namespace syh;

ini_set('display_errors', 'on');
error_reporting(E_ALL);
define('START_TIME', microtime(true));
define('ROOTPATH', __DIR__);
define('ROUTEPATH', ROOTPATH . DIRECTORY_SEPARATOR . 'route');

require ROOTPATH . DIRECTORY_SEPARATOR . 'learnphp' . DIRECTORY_SEPARATOR . 'Loader.php';

Loader::register();

Loader::addClassAlias([
    'App'     => facade\App::class,
    'Request' => facade\Request::class,
    'Route'   => facade\Route::class
]);

Container::get('app')->qstart();
