<?php
namespace syh;

class Loader
{
    private static $classMaps = [];

    /**
     * PSR-4
     */
    private static $prefixLengthsPsr4 = [];
    private static $prefixDirsPsr4    = [];

    /**
     * 需要加载的文件
     */
    private static $files = [];

    /**
     * Composer安装路径
     */
    private static $composerPath;

    public static function register()
    {
        spl_autoload_register('syh\\Loader::autoload', true, true);
        
        self::$composerPath = ROOTPATH . DIRECTORY_SEPARATOR . 'vendor' 
            . DIRECTORY_SEPARATOR . 'composer' . DIRECTORY_SEPARATOR;
      
        if (is_dir(self::$composerPath)) {
            if (is_file(self::$composerPath . 'autoload_static.php')) {
                require self::$composerPath . 'autoload_static.php';

                $declaredClass = get_declared_classes();
                $composerClass = end($declaredClass);
                
                foreach (['prefixLengthsPsr4', 'prefixDirsPsr4', 'files'] as $attr) {
                    if (property_exists($composerClass, $attr)) {
                        self::${$attr} = $composerClass::${$attr};
                    }
                }
            }
        }
    }

    public static function autoload($class)
    {
        if ( isset(self::$classMaps[$class]) ) {
            $class = self::$classMaps[$class];
        }

        if ($file = self::findFile($class)) {
            if ( file_exists($file) && is_file($file) ) {
                include $file;
            }
            return true;
        }
    }

    private static function findFile($class)
    {
        // 查找 PSR-4
        $logicalPathPsr4 = strtr($class, '\\', DIRECTORY_SEPARATOR) . '.php';
        
        $first = $class[0];
        if (isset(self::$prefixLengthsPsr4[$first])) {
            foreach (self::$prefixLengthsPsr4[$first] as $prefix => $length) {
                if (0 === strpos($class, $prefix)) {
                    foreach (self::$prefixDirsPsr4[$prefix] as $dir) {
                        if (is_file($file = $dir . DIRECTORY_SEPARATOR . substr($logicalPathPsr4, $length))) {
                            return $file;
                        }
                    }
                }
            }
        }
        return false;
    }

}

