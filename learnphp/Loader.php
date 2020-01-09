<?php
namespace syh;

class Loader
{
    public static $classMap = [
        'syh'   => ROOTPATH . DIRECTORY_SEPARATOR . 'learnphp',
        'app'   => ROOTPATH . DIRECTORY_SEPARATOR . 'app'
    ];

    public static function register()
    {
        spl_autoload_register('syh\\Loader::autoload', true, true);
    }

    public static function autoload($class)
    {
        if ($file = self::findFile($class)) {
            if ( file_exists($file) && is_file($file) ) {
                include $file;
            }
            return true;
        }
    }

    private static function findFile($class)
    {
        $vendor = substr($class, 0, strpos($class, '\\'));
        $vendorDir = self::$classMap[$vendor];
        $filePath = substr($class, strlen($vendor)) . '.php';
        return strtr($vendorDir . $filePath, '\\', DIRECTORY_SEPARATOR);
    }
}

