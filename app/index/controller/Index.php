<?php
namespace app\index\controller;
use syh\Request;

class Index extends Base
{

    public function hello($a, Request $r)
    {
        echo 'hello '.$a
        print_r( get_included_files() );
    }

    public function test()
    {
    	echo 1;
    }
}

