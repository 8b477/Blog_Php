<?php

namespace App\config;


class FunctionManager
{
    public static function debug($var)
    {
        echo '<pre>' . print_r($var, true) .'</pre>';
    }

}