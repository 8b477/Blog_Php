<?php

use App\Config\Connect;

require_once(__DIR__ . '/../../include.php');

//Here i check url with superglobal GET.
$user_id= $_GET['id'];
$token = $_GET['token'];

$req = Connect::getPDO()->prepare('SELECT * FROM users WHERE id = ?');

//Recover id user.
$req->execute([$user_id]);
$user = $req->fetch();
session_start();

//Compare GET with data in my DB
if ($user && $user->confirmation_token == $token){
    session_start();
    $req = Connect::getPDO()->prepare('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?');
    $req->execute([$user_id]);
    $_SESSION['flash']['success'] = 'votre compte à bien été validé !';
    $_SESSION['auth'] = $user;
    header('Location: /public/account/account.php');
}else{
    $_SESSION['flash']['danger'] = "Ce token n'est plus valide";
    header('Location: /View/inscription.php');
}
