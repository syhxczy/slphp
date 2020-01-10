<?php
namespace syh;

class Facade
{
    public static function createFacade()
    {
        $class = static::getFacadeClass();
        return Container::getInstance()->make($class);
    }

    public static function __callStatic($method, $arguments)
    {
        return call_user_func_array([static::createFacade(), $method], $arguments);
    }

    public static function getFacadeClass()
    {
        
    }
}

