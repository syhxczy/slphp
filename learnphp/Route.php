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
        // C:\Users\syh\AppData\Roaming
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
        // \u4e00-\u9fa5
        // magnet:?xt=urn:btih:2A42EB57A8639BE8D7B6DB66890F1426F534E717
        $replacepArr = ['\/', '(', ')', '\d+', '[_a-zA-Z]+'];
        return str_replace($findArr, $replacepArr, $url);
    }

    public function compareUrl($pregmArr, $compareurl)
    {
        foreach ($pregmArr as $val) {
            if ( preg_match('/'.$val['pregm'].'$/', $compareurl, $pregMatch) ) {
                array_shift($pregMatch);
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

