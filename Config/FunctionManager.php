<?php

namespace App\Config;

use App\Config\Connect;


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
            header('Location: /public/account/connexion.php');
        }
    }

    /**
     * Reconnection auto with COOKIE
     */
    public static function autoLog(){

        //test cookie if good reco auto
        if (isset($_COOKIE['remember']) && !isset($_SESSION['auth']))
        {
            require_once (__DIR__ . '/Connect.php');

            $remember_token = $_COOKIE['remember'];
            $part = explode('==', $remember_token);
            $user_id = $part[0];
            $req = Connect::getPDO()->prepare('SELECT * FROM users WHERE id = ?');
            $req->execute([$user_id]);
            $user = $req->fetch();

            if ($user)
            {
                $expected = $user_id . '==' . $user->remember_token . sha1($user_id . '8b477');

                if ($expected == $remember_token)
                {
                    session_start();
                    $_SESSION['auth'] = $user;
                    setcookie('remember', $remember_token, time() + 60 * 60 * 24 * 7);
                }

            }else{
                setcookie('remember', NULL, -1);
            }
        }
    }
}