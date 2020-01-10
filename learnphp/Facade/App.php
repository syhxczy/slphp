<?php
namespace syh\Facade;
use syh\Facade;

class App extends Facade
{
    public static function getFacadeClass()
    {
        return 'app';
    }
}
