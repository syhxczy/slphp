<?php
namespace syh;

function dd($data)
{
    print_r($data);
    die;
}

ini_set('display_errors', 'on');
error_reporting(E_ALL);
define('START_TIME', microtime(true));
define('ROOTPATH', __DIR__);
define('ROUTEPATH', ROOTPATH . DIRECTORY_SEPARATOR . 'route');

require ROOTPATH . DIRECTORY_SEPARATOR . 'learnphp' . DIRECTORY_SEPARATOR . 'Loader.php';

Loader::register();
Container::get('app')->qstart();
