<?php
namespace syh\Facade;
use syh\Facade;

class Request extends Facade
{
    public static function getFacadeClass()
    {
        return 'request';
    }
}

