<?php

//Logout page with message of confirmation.
session_start();

setcookie('remember', NULL, -1);

//Clean SESSION
unset($_SESSION['auth']);
unset($_SESSION['role']);

$_SESSION['flash']['success'] = 'Vous êtes bien déconnecter !';

header('Location: /View/connexion.php');