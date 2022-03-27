<?php

use App\Config\Connect;
use App\config\FunctionManager;

require_once(__DIR__ . '/../../include.php');
require_once(__DIR__ . '/../../Config/FunctionManager.php');

FunctionManager::logged();

    if (!empty($_POST))
    {       //Check if password is correct if not display a error message.
        if (empty($_POST['password']) || $_POST['password'] != $_POST['password-confirm'])
        {
            $_SESSION['flash']['danger'] = "Les mots de passes ne correspondent pas !";
        }
        else{
            //Recover id user, hash pass => Update DB with new pass and display success message.
            $user_id = $_SESSION['auth']->id;
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $pdo = Connect::getPDO();
            $req = $pdo->prepare('UPDATE users SET password = ?')->execute([$password]);
            $_SESSION['flash']['success'] = "Votre mot de passe à bien été mis à jour !";

        }
    }
?>
        <!-- Display perso title -->
<h1>Bienvenue sur ton compte <?= $_SESSION['auth']->username ?> !</h1>

        <!-- Form for change pass -->
<h2>Nouveaux mot de passe</h2>

    <form action="" method="post">
        <div class="form-group">
            <input type="password" name="password" id="password-id" placeholder="Nouveau mot de passe">
        </div>
        <div class="form-groupe">
            <input type="password" name="password-confirm" id="password-confirm-id" placeholder="Confirmation du pass">
        </div>
        <button class="btn-primary">Changer mon mot de passe</button>
    </form>


<?php

