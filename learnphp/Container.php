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

    public function run($abstract, ...$vars)
    {
        return $this->invokeMethod($abstract, $vars);
    }

    public function get($abstract, ...$vars)
    {
        $this->class = $this->invokeClass($abstract, $vars);
        return $this;
    }

    public function play($abstract, ...$vars)
    {
        if ($abstract instanceof \Closure) {
            return $this->invokeFunction($abstract, $vars);
        } else {
            return call_user_func($abstract, ...$vars);
        }
    }

    public function invokeClass($classString, $classData)
    {
        try {
            $class            = new ReflectionClass($classString);
            static::$instance = $class;
            $constructor      = $class->getConstructor();
            $classArgs        = $constructor ? $this->doReflection($constructor, $classData) : [];
            $result           = $class->newInstanceArgs($classArgs);
        } catch (ReflectionException $e) {
            $result = 'class not exists: ' . $classString;
        }
        return $result;
    }

    public function invokeMethod($methodString, $methodData)
    {
        try {
            $class      = static::$instance;
            $method     = $class->getmethod($methodString);
            $methodArgs = $this->doReflection($method, $methodData);
            $result     = $method->invokeArgs($this->class, $methodArgs);
        } catch (ReflectionException $e) {
            $result = 'method not exists: ' . $methodString;
        }
        return $result;
    }

    public function invokeFunction($functionString, $functionData)
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

}
