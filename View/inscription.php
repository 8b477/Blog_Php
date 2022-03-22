<?php
                                //Page for inscription new user !
use App\Config\Connect;
use App\Config\FunctionManager;

require_once(__DIR__ . '/../include.php');
//session_start();
    if (!empty($_POST))
    {
        $errors = array();
        //Using a preg_match to avoid surprises.
        if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username']))
        {
            $errors['username'] = "Votre pseudo n'est pas valide caractères de (a) à (z) de 0 à 9 et underscore autorisé";
        }else{
            //If username is good check if exist in DB.
            $pdo = Connect::getPDO()->prepare('SELECT id FROM users WHERE username = ?');
            $pdo->execute([$_POST['username']]);
            $user = $pdo->fetch();

            if ($user)
            //If true return message error !
            {
                $errors['username'] = "ce speudo est déjà utilisé !";
            }
        }
        //Check mail with filter_var
        if (empty($_POST['mail']) || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
        {
            $errors['mail'] = "Votre adresse mail n'est pas valide !";
        }else{
            //Check if mail is exist in DB.
            $pdo = Connect::getPDO()->prepare('SELECT id FROM users WHERE mail = ?');
            $pdo->execute([$_POST['mail']]);
            $mail = $pdo->fetch();
            if ($mail)
            {
                //If true return message error !
                $errors['mail'] = "L'adresse mail est déjà utilisé !";
            }
        }
        //compare the two pass fields.
        if (empty($_POST['password']) || $_POST['password'] != $_POST['password-check'])
        {
            $errors['password'] = "Veuillez rentrer un mot de passe valide !";
        }
        //If table errors is null execute INSERT INTO.
        if (empty($errors))
        {
            $pdo = Connect::getPDO();
            $req = $pdo->prepare("INSERT INTO users SET username = ?, password = ?, mail = ?, confirmation_token = ?");
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            //Create a token to validate later by email.
            $token = FunctionManager::str_random(60);
            $req->execute([$_POST['username'], $password, $_POST['mail'], $token]);

            //Recover the last id for identified the new user.
            $user_id = $pdo->lastInsertId();

            //Send mail with link for validate inscription.

            //FIXE ME **************************************************************************************************
            mail($_POST['mail'], 'Confirmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien\n\nhttp://localhost:8000/public/account/confirm.php?id=$user_id&token=$token");

            $_SESSION['flash']['success'] = "un email de confirmation vous a été envoyé pour valider votre compte";

            //CHECK LE LIEN BRO
            header('Location: /View/connexion.php');
            exit();
        }
    }

?>
<?php
    //If table errors is not empty => show this one !
    if (!empty($errors))
    { ?>
        <div class="alert alert-danger">
            <p>Vous n'avez pas rempli le formulaire correctement</p>
            <ul>
                <!-- Display errors in a list -->
                <?php foreach ($errors as $error)
                {?>
                    <li><?= $error; ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php }
?>
        <!-- Simple form for inscription a new user -->
    <h1>Inscription</h1>

    <form action="" method="post">

        <label for="username-id">Entrez un pseudo : </label>
        <p><input type="text" name="username" id="username-id"></p>

        <label for="mail-id">Entrez votre adresse mail : </label>
        <p><input type="mail" name="mail" id="mail-id"></p>

        <label for="password-id">Entrez un mot de passe : </label>
        <p><input type="password" name="password" id="password-id"></p>

        <label for="pass-id-check">Confirmez le mot de passe : </label>
        <p><input type="password" name="password-check" id="password-id-check"></p>

        <p><input type="submit" value="inscription"></p>

    </form>


