<?php
namespace syh;

class Route
{
    protected static $rules = [];
    protected static $pregmMatchs = [];

    public function getRules()
    {
        return static::$rules;
    }

    public function dispath($method, $url)
    {
        if ( !isset(static::$rules[$method]) ) return;
        $result = $this->compareUrl(static::$pregmMatchs[$method], $url);
        if ( !$result ) return;
        $rule    = explode('\\', $result['run']);
        $fun     = array_pop($rule);
        $class   = '\\app\\' . ucfirst($rule[0]) . '\\controller\\' . ucfirst($rule[1]);
        $data    = $result['parame'];
        return [
            'run'  => [$class, $fun],
            'data' => $data
        ];
    }

    public function get($url, $runMethod)
    {
        $pregmMatch = $this->replacepPregm($url);
        static::$pregmMatchs['GET'][] = [
            'pregm' => $pregmMatch,
            'run'   => $runMethod
        ];
        static::$rules['GET'][$url] = $runMethod;
    }

    public function replacepPregm($url)
    {
        $findArr = ['/', '<', '>', 'id', 'name'];
        $replacepArr = ['\/', '(', ')', '\d+', '[\u4e00-\u9fa5_a-zA-Z]+'];
        return str_replace($findArr, $replacepArr, $url);
    }

    public function compareUrl($pregmArr, $compareurl)
    {
        foreach ($pregmArr as $val) {
            if ( preg_match('/'.$val['pregm'].'$/', $compareurl, $pregMatch) ) {
                array_shift($pregMatch);
                // dd($pregmArr);
                $result = [
                    'run'    => $val['run'],
                    'parame' =>$pregMatch
                ];
                break;
            }
        }
        return isset($result) ? $result : '';
    }
}

