<?php
namespace app\index\controller;
use syh\Request;

class Index extends Base
{
    
    public function test($a, $b, Request $r)
    {
        echo $a+$b;
        print_r( get_included_files() );
    }
}

