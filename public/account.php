<?php

use App\config\Connect;

require_once (__DIR__ . '/../include.php');
require_once (__DIR__ . '/../Config/FunctionManager.php');

\App\config\FunctionManager::logged();

    if (!empty($_POST))
    {
        if (empty($_POST['password']) || $_POST['password'] != $_POST['password-confirm'])
        {
            $_SESSION['flash']['danger'] = "Les mots de passes ne correspondent pas !";
        }
        else{
            $user_id = $_SESSION['auth']->id;
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $pdo = Connect::getPDO();
            $req = $pdo->prepare('UPDATE users SET password = ?')->execute([$password]);
            $_SESSION['flash']['success'] = "Votre mot de passe à bien été mis à jour !";

        }
    }
?>

<h1>Bienvenue <?= $_SESSION['auth']->username ?>!</h1>

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

