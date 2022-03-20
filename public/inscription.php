<?php

use App\config\FunctionManager;

require_once (__DIR__ . '/../include.php');

    if (!empty($_POST))
    {

        $errors = array();

        if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username']))
        {
            $errors['username'] = "Votre pseudo n'est pas valide caractères de (a) à (z) de 0 à 9 et underscore autorisé";
        }
        if (empty($_POST['mail']) || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
        {
            $errors['mail'] = "Votre adresse mail n'est pas valide !";
        }
        if (empty($_POST['pass']) || $_POST['pass'] != $_POST['pass-check'])
        {
            $errors['pass'] = "Veuillez rentrer un mot de passe valide !";
        }
        FunctionManager::debug($errors);
    }

?>

<form action="" method="post">

    <label for="username-id">Entrez un pseudo : </label>
    <p><input type="text" name="username" id="username-id"></p>

    <label for="mail-id">Entrez votre adresse mail : </label>
    <p><input type="mail" name="mail" id="mail-id"></p>

    <label for="pass-id">Entrez un mot de passe : </label>
    <p><input type="password" name="pass" id="pass-id"></p>

    <label for="pass-id-check">Confirmez le mot de passe : </label>
    <p><input type="password" name="pass-check" id="pass-id-check"></p>

    <p><input type="submit" value="inscription"></p>

</form>


