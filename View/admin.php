<?php

use App\Config\Connect;
use App\Config\FunctionManager;

require_once(__DIR__ . '/../include.php');


if (isset($_SESSION['auth'])){
    header('Location: /public/account/account.php');
    exit();
}


//Simple verification for a connection.
if (!empty($_POST) && !empty($_POST['username'] && !empty($_POST['password'])))
{
    $pdo = Connect::getPDO();
    $req = $pdo->prepare('SELECT * FROM users WHERE (username = :username OR mail = :username) AND confirmed_at IS NOT NULL');
    $req->execute(['username' => $_POST['username']]);
    $user = $req->fetch();

    if ($user)
    {
        if ($user->role_user !== 'admin')
        {
            $_SESSION['flash']['danger'] = 'Vous n\'avez pas les droits admin';
            header('Location: /View/admin.php');
            exit();
        }
        if (password_verify($_POST['password'], $user->password))
        {
            //Stock some data in my SESSION
            $_SESSION['auth'] = $user;
            $_SESSION['role'] = $user->role_user;
            $_SESSION['flash']['success'] = 'Vous êtes connecté !';


            header('Location: /public/admin/admin.php');
        }
    }
    else{
        $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorecte';
    }
}

?>

<h1>Admin connexion</h1>
<form class="form-connexion"  action="" method="POST" name="RegForm" onsubmit="return validateJs()">

    <!-- Simple form for connection -->
    <label for="username-id">Votre pseudo
        <a href="../public/account/forget.php">(Mot de passe oublié ?)</a>
    </label>
    <p>
        <input type="text" name="username" id="username-id" required>
    </p>

    <label for="pass-id">Votre Mot de passe</label>
    <p>
        <input type="password" name="password" id="pass-id" required>
    </p>

    <p>
        <input type="submit" value="connexion">
    </p>
</form>
<?php require_once (__DIR__ . '/../parts/footer.php'); ?>