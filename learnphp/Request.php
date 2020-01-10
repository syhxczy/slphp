<?php
namespace syh;

class Request
{
    public $server;

    public function __construct()
    {
        $this->server = $_SERVER;
    }

}

