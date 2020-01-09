<?php
namespace syh;

function dd($data)
{
    print_r($data);
    die;
}

ini_set('display_errors', 'on');
error_reporting(E_ALL);
define('ROOTPATH', __DIR__);
define('learnphp',__DIR__ . DIRECTORY_SEPARATOR . 'learnphp' . DIRECTORY_SEPARATOR);
include learnphp . 'Loader.php';

Loader::register();

$container = new Container();
$tes = [1,2,3];
$container->get('\app\index\controller\Index')->run('test', 1);
// class Test
// {
//     public function hello()
//     {
//         return 'hello world';
//     }
// }
