<?php
namespace syh;
use Exception;

class Baseexception extends Exception
{
    public function __toString() {
        echo $this->message;
    }
}
