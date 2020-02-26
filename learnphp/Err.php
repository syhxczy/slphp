<?php
namespace syh;

class Err
{
    
    public function __construct()
    {
        error_reporting(E_ALL);
        set_error_handler([$this, 'error']);
        set_exception_handler([$this, 'exception']);
        register_shutdown_function([$this, 'finalError']);
    }

    public function error($type, $message, $file, $line)
    {
        $type = array_search($type, get_defined_constants());
        $this->showMessage($type, $message, $file, $line);
    }

    public function exception($e)
    {
        $type = get_class($e);
        $message = $e->getMessage();
        $file = $e->getFile();
        $line = $e->getLine();
        $this->showMessage($type, $message, $file, $line);
    }

    public function finalError()
    {
        $error = error_get_last();
        if ($error) {
            $type = array_search($error['type'], get_defined_constants());;
            $message = $error['message'];
            $file = $error['file'];
            $line = $error['line'];
            $this->showMessage($type, $message, $file, $line);
        }
    }

    public function showMessage($type, $message, $file, $line)
    {
        echo "错误类型：{$type}".PHP_EOL;
        echo "错误信息：{$message}".PHP_EOL;
        echo "所在文件：{$file}".PHP_EOL;
        echo "所在行数：{$line}".PHP_EOL;
        die;
    }
}
