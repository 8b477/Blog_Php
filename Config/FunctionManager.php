<?php

namespace App\config;

/**
 * Some function utils
 */
class FunctionManager
{
    /**
     * Debug function
     * @param $var
     */
    public static function debug($var)
    {
        echo '<pre>' . print_r($var, true) .'</pre>';
    }

    /**
     * Return token
     * @param $length
     * @return false|string
     */
    public static function str_random($length){
        $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
       return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
    }

    /**
     * Check if user is logged
     */
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