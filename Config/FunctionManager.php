<?php

namespace App\config;


class FunctionManager
{
    public static function debug($var)
    {
        echo '<pre>' . print_r($var, true) .'</pre>';
    }

    public static function str_random($length){
        $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
       return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
    }

}