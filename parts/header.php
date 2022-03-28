<?php
require_once (__DIR__ . '/../Config/FunctionManager.php');

use App\Config\FunctionManager;

FunctionManager::autoLog();

if (session_status() == PHP_SESSION_NONE)
{
    session_start();
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                        <!-- Css -->
    <link rel="stylesheet" href="/public/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
                     <!-- Font import -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Concert+One&display=swap" rel="stylesheet">
                 <!-- Display the correct title -->
    <title>Blog<?php if (isset($_GET['id'])) echo '_Article ' .$_GET['id'] ?></title>

</head>

<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <header class="mb-auto">
        <div>
            <h3 class="float-md-start mb-0">Mon blog</h3>
            <nav class="nav nav-masthead justify-content-center float-md-end">
                <a class="nav-link active" aria-current="page" href="/index.php">Home</a>
               <?php if (isset($_SESSION['role']) == 'admin')
                   { ?>
                       <a class="nav-link" href="/../../public/admin/admin.php">Articles</a>
                  <?php } else{ ?>
                   <a class="nav-link" href="/../../View/articles.php">Articles</a>
                   <?php } ?>


                <!-- Displays the list adapted if the user is logged in or not  -->
                <?php
                        if (isset($_SESSION['auth']))
                            {
                              ?>  <a class="nav-link" href="../../View/deconnexion.php">Deconnexion</a> <?php
                            }
                else{ ?>
                <a class="nav-link" href="/View/connexion.php">Connexion</a>
                <a class="nav-link" href="/View/inscription.php">Inscription</a>
                <a class="nav-link" href="/View/admin.php">Admin</a>
                <?php } ?>

            </nav>
        </div>
    </header>
    <body>
            <!-- Clean $_SESSION -->
<?php
    if (isset($_SESSION['flash']))
    {
        foreach ($_SESSION['flash'] as $type => $message)
        {?>
            <div class="alert alert-<?= $type; ?>">
            <?= $message; ?>
            </div>
        <?php }
        unset($_SESSION['flash']);
    }
?>