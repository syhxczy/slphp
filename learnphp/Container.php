<?php
namespace syh;

use ReflectionClass;
use ReflectionMethod;
use ReflectionFunction;
use ReflectionException;

class Container
{
    protected $class;
    protected static $instance;

    protected $bind = [
        'app'     => App::class,
        'request' => Request::class,
        'route'   => Route::class
    ];

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    public static function get($abstract, $vars=[])
    {
        return static::getInstance()->make($abstract, $vars);
    }

    public function run($abstract, $vars)
    {
        return $this->invokeMethod($abstract, $vars);
    }

    public function make($abstract, $vars=[])
    {
        if ( isset($this->bind[$abstract]) ) {
            $abstract =  $this->bind[$abstract];
        }
        $object = $this->invokeClass($abstract, $vars);
        return $object;
    }

    public function play($abstract, $vars=[])
    {
        if ($abstract instanceof \Closure) {
            return $this->invokeFunction($abstract, $vars);
        } else {
            return call_user_func($abstract, ...$vars);
        }
    }

    public function invokeClass($classString, $classData=[])
    {
        try {
            $class            = new ReflectionClass($classString);
            $constructor      = $class->getConstructor();
            $classArgs        = $constructor ? $this->doReflection($constructor, $classData) : [];
            $result           = $class->newInstanceArgs($classArgs);
        } catch (ReflectionException $e) {
            $result = 'class not exists: ' . $classString;
        }
        return $result;
    }

    public function invokeMethod($method, $methodData=[])
    {
        try {
            $class      = is_object($method[0]) ? $method[0] : $this->invokeClass($method[0]);
            $reflect    = new ReflectionMethod($class, $method[1]);
            $methodArgs = $this->doReflection($reflect, $methodData);
            $result     = $reflect->invokeArgs($class, $methodArgs);
        } catch (ReflectionException $e) {
            $result = 'method not exists';
        }
        return $result;
    }

    public function invokeFunction($functionString, $functionData=[])
    {
        try {
            $function     = new ReflectionFunction($functionString);
            $functionArgs = $this->doReflection($function, $functionData);
            $result       = $function->invokeArgs($functionArgs);
        } catch (ReflectionException $e) {
            $result = 'function not exists: ' . $functionString;
        }
        return $result;
    }
    
    private function doReflection($method, $methodData)
    {
        if ( $method->getNumberOfParameters()==0 ) {
            return [];
        }

        $i = 0;
        $parameters = $method->getParameters();
        foreach ($parameters as $param) {
            if ( is_null($param->getClass()) ) {
                $default = $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null;
                $val     = isset($methodData[$i]) ? $methodData[$i] : $default;
            } else {
                $class = $param->getClass()->getName();
                $val   = new $class;
            }
            $arguments[$i] = $val;
            $i++;
        }
        return $arguments;
    }

    public function __get($name)
    {
        return $this->make($name);
    }

}
