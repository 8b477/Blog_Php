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
        if (password_verify($_POST['password'], $user->password))
        {
            //Stock some data in my SESSION
            $_SESSION['auth'] = $user;
            $_SESSION['role'] = $user->role_user;
            $_SESSION['flash']['success'] = 'Vous êtes connecté !';

            //If user check remember => modified remember_token in my DB
            if ($_POST['remember'] == 1)
            {
                //Create a random key
                $remember_token = FunctionManager::str_random(255);

                $pdo = Connect::getPDO();
                $pdo->prepare('UPDATE users SET remember_token = ? WHERE id = ?')
                    ->execute([$remember_token, $user->id]);

                //Save data in cookie + duration (60 * 24) * 7 = one week
                setcookie('remember', $user->id . '==' . $remember_token . sha1($user->id . '8b477'), time() + 60 * 60 * 24 * 7);
            }
            header('Location: /public/account/account.php');
            exit();
        }
    }
        else{
            $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorecte';
        }
    }

?>
    <h1>Connexion</h1>
    <form class="form-connexion" action="" method="POST" name="RegForm" onsubmit="return validateJs()">

        <!-- Simple form for connection -->
        <label for="username-id" class="form-label">Votre pseudo
            <a href="../public/account/forget.php">(Mot de passe oublié ?)</a>
        </label>
        <p>
            <input type="text" name="username" id="username-id" required>
        </p>

        <label for="pass-id">Votre Mot de passe</label>
        <p>
            <input type="password" name="password" id="pass-id" required>
        </p>

        <!-- CheckBox for remember of me -->
        <p>
            <label for="checkbox-id">
                <input type="checkbox" name="remember" id="checkbox-id" value="1"/> Se souvenir de moi
            </label>
        </p>

        <p>
            <input type="submit" value="connexion">
        </p>
    </form>
<?php require_once (__DIR__ . '/../parts/footer.php'); ?>