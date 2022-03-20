<?php

session_start();
unset($_SESSION['auth']);
$_SESSION['flash']['success'] = 'Vous êtes bien déconnecter !';
header('Location: /public/connexion.php');