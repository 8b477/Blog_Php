<?php
                            //PAGE FOR RESET PASSWORD !

use App\Config\Connect;

require_once(__DIR__ . '/../../include.php');
require_once(__DIR__ . '/../../Config/FunctionManager.php');

    //Check if id and token is are my url.
    if (isset($_GET['id']) && isset($_GET['token']))
    {
        //If true check validity with my DB.
        $pdo = Connect::getPDO();
        $req = $pdo->prepare('SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND confirmed_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
        $req->execute([$_GET['id'], $_GET['token']]);
        $user = $req->fetch();

        if ($user)
        {
            if (!empty($_POST))
            {
                //If true, check that both fields are correct.
                if (!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm'])
                {
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                    //init reset_at and reset_token in DB
                    $pdo->prepare('UPDATE users SET password = ?, reset_at = NULL, reset_token = NULL')->execute([$password]);
                    session_start();
                    $_SESSION['flash']['success'] = "Votre mot de passe à bien été modifié !";
                    header('Location: /../../View/connexion.php');
                    exit();
                }
            }
        }else{
            session_start();
            $_SESSION['flash']['error'] = "Ce token n'est pas valide";
            header('Location: /../View/connexion.php');
            exit();
        }
    }
    else{
        header('Location: /../View/connexion.php');
        exit();
    }

?>

<!-- Simple form for forgot password. -->
    <h1>Reset mot de passe</h1>

    <form action="" method="POST">

        <label for="username-id">Votre mot de passe</label>
        <p>
            <input type="password" name="password" id="password-id">
        </p>

        <label for="pass-id">Confirmation du pass</label>
        <p>
            <input type="password" name="password_confirm" id="pass_id_confirm">
        </p>

        <p>
            <input type="submit" value="Validé !">
        </p>

    </form>
