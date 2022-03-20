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


    public static function logged()
    {
        if (session_status() == PHP_SESSION_NONE)
        {
            session_start();
        }
        if (!isset($_SESSION['auth']))
        {
            $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder à cette page";
            header('Location: public/connexion.php');
        }
    }
}