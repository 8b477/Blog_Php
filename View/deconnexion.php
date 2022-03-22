<?php

//Logout page with message of confirmation.
session_start();

//Clean SESSION
unset($_SESSION['auth']);

$_SESSION['flash']['success'] = 'Vous êtes bien déconnecter !';

header('Location: /View/connexion.php');