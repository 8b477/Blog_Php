<?php

use App\config\Connect;
use App\config\FunctionManager;

require_once (__DIR__ . '/../include.php');

    if (!empty($_POST) && !empty($_POST['mail']))
    {
        $pdo = Connect::getPDO();
        $req = $pdo->prepare('SELECT * FROM users WHERE mail = ? AND confirmed_at IS NOT NULL');
        $req->execute([$_POST['mail']]);
        $user = $req->fetch();
        if ($user)
        {
            session_start();
            $reset_token = FunctionManager::str_random(60);
            $pdo->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?')
                ->execute([$reset_token, $user->id]);
            $_SESSION['flash']['success'] = 'Les instructions du rappel du mot de passe vous ont été envoyées par e-mail !';
            mail($_POST['mail'], 'Réinitialisation du mot de passe', "Afin de récupéré votre mot de passe merci de cliquer sur ce lien\n\nhttp://localhost:8000/public/reset.php?id={$user->id}&token=$reset_token");
            header('Location: /public/connexion.php');
            exit();
        }
        else{
            $_SESSION['flash']['danger'] = 'Aucun compte ne correspond à cet adresse !';
        }
    }

?>
    <h1>Mot de passe oublié ?</h1>

    <form action="" method="post">

        <label for="mail-id">Entrez votre mail : </label>
        <p><input type="email" name="mail" id="mail-id"></p>
        <p><input type="submit" value="Confirmez !"></p>
    </form>
