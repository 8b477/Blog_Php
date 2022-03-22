<?php
                                 //This page is for recover password !
use App\Config\Connect;
use App\Config\FunctionManager;

require_once(__DIR__ . '/../../include.php');

    //Check if POST is not empty.
    if (!empty($_POST) && !empty($_POST['mail']))
    {
        //Connect to DB and check is mail exist and confirmed !
        $pdo = Connect::getPDO();
        $req = $pdo->prepare('SELECT * FROM users WHERE mail = ? AND confirmed_at IS NOT NULL');
        $req->execute([$_POST['mail']]);
        $user = $req->fetch();
        if ($user)
        {
            //If true start a session
            session_start();

            //Prepare token for mail with function in my class FunctionManager.
            $reset_token = FunctionManager::str_random(60);
            $pdo->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?')
                ->execute([$reset_token, $user->id]);
            $_SESSION['flash']['success'] = 'Les instructions du rappel du mot de passe vous ont été envoyées par e-mail !';

            //Send an email with the user ID as a parameter and the generated token.
            mail($_POST['mail'], 'Réinitialisation du mot de passe', "Afin de récupéré votre mot de passe merci de cliquer sur ce lien\n\nhttp://localhost:8000/public/account/reset.php?id={$user->id}&token=$reset_token");
            header('Location: /../View/connexion.php');
            exit();
        }
        else{
            $_SESSION['flash']['danger'] = 'Aucun compte ne correspond à cet adresse !';
        }
    }

?>
    <!-- Simple form for send mail and check if mail exist in my DB. -->
    <h1>Mot de passe oublié ?</h1>

    <form action="" method="post">

        <label for="mail-id">Entrez votre mail : </label>
        <p><input type="email" name="mail" id="mail-id"></p>
        <p><input type="submit" value="Confirmez !"></p>
    </form>
