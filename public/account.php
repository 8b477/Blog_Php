<?php
require_once (__DIR__ . '/../include.php');
require_once (__DIR__ . '/../Config/FunctionManager.php');

\App\config\FunctionManager::logged();

?>

<h1>Bienvenue <?= $_SESSION['auth']->username ?>!</h1>



<?php

