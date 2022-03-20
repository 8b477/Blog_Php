<?php
require_once (__DIR__ . '/../include.php');

    if (isset($_POST['username']) && isset($_POST['pass']))
    {
        $username = trim(addslashes(strip_tags($_POST['username'])));
        $pass = trim(addslashes(strip_tags($_POST['pass'])));
    }

?>

<form action="" method="post">

    <label for="username-id">Votre pseudo</label>
    <p><input type="text" name="username" id="username-id"></p>

    <label for="pass-id">Votre Mot de passe</label>
    <p><input type="password" name="pass" id="pass-id"></p>

    <p><input type="submit" value="connexion"></p>
</form>
