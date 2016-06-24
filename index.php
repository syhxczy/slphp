<?php

define('APP_PATH',dirname($_SERVER['SCRIPT_FILENAME']));

$controller = (empty($_GET['controller'])) ? 'index' : $_GET['controller'] ;

$action = (empty($_GET['aciton'])) ? 'index' : $_GET['action'] ;

$controller_file=APP_PATH.'/app/controller/'.$controller.'/'.$action.'.php';

if(file_exists($controller_file)){
	require_once APP_PATH.'/common/function.php';
	require_once $controller_file;
}else{
	die('非法操作');
}

function __autoload($classname) {
    $filename = APP_PATH.'/config/'. $classname .".php";
    include_once($filename);
} 