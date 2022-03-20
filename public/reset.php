<?php

use App\config\Connect;

require_once (__DIR__ . '/../include.php');
require_once (__DIR__ . '/../Config/FunctionManager.php');
    if (isset($_GET['id']) && isset($_GET['token']))
    {
        $pdo = Connect::getPDO();
        $req = $pdo->prepare('SELECT * FROM users WHERE id = ? AND reset_token = ? AND confirmed_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
        $req->execute([$_GET['id'], $_GET['token']]);
        $user = $req->fetch();

        if ($user)
        {
            if (!empty($_POST))
            {
                if (!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm'])
                {
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    $pdo->prepare('UPDATE users SET password = ?')->execute();
                    session_start();
                    $_SESSION['flash']['success'] = "Votre mot de passe à bien été modifié !";
                    header('Location: /public/account.php');
                    exit();
                }
            }
        }else{
            session_start();
            $_SESSION['flash']['error'] = "Ce token n'est pas valide";
            header('Location: /public/connexion.php');
            exit();
        }
    }
    else{
        header('Location: /public/connexion.php');
        exit();
    }

?>
<h1>Reset mot de passe</h1>
<form action="" method="POST">

    <label for="username-id">Votre mot de passe</label>
    <p><input type="password" name="password" id="password-id"></p>

    <label for="pass-id">Confirmation du pass</label>
    <p><input type="password" name="password_confirm" id="pass_id_confirm"></p>

    <p><input type="submit" value="Validé !"></p>
</form>
