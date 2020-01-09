<?php
namespace syh;

class Route
{
    protected $request;
    protected static $rules = [];

    public function getRules()
    {
        return static::$rules;
    }

    public function getRule($type)
    {
        return static::$rules[$type];
    }

    public static function get($url, $runMethod)
    {
        static::$rules['GET'][$url] = $runMethod;
    }
}

