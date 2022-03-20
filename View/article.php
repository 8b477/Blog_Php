<?php

use App\config\FunctionManager;
use App\Manager\ArticleManager;
use App\Manager\CommentManager;

require_once(__DIR__ . '/../include.php');


if (!isset($_GET['id']) || !is_numeric($_GET['id']))
    header('Location: index.php');

else{
    extract($_GET);
    $id = strip_tags($id);


    if (!empty($_POST)){
        extract($_POST);
        $errors = array();

        $author = strip_tags($author);
        $comment = strip_tags($comment);

        if (empty($author))
            array_push($errors, 'Entrez un pseudo');

        if (empty($comment))
                array_push($errors, 'Entrez un commentaire');

        if (count($errors) == 0){
            $comment = CommentManager::addComment($id, $author, $comment);

            $success = 'Votre commentaire a été publié !';

            unset($author);
            unset($comment);
        }
    }
    $article = ArticleManager::getArticle($id);
    $comments = CommentManager::getComments($id);
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $article->title ?></title>
</head>
<body>
    <a href="../index.php">Retour aux articles</a>
    <h1><?= $article->title ?></h1>
    <time><?= $article->date_add ?></time>
    <p><?= $article->content ?></p>

    <?php
        if (isset($success)){
            echo $success;
        }
        if (!empty($errors)){
            foreach ($errors as $error){ ?>
                <p><?= $error ?></p>
          <?php  }
        }
    ?>

    <form action="" method="POST">

        <label for="author">Pseudo :</label>
        <br>
        <p><input type="text" name="author" id="author-id" value="<?php if (isset($author)) echo $author ?>"></p>

        <label for="comment">Commentaire :</label>
        <br>
        <p><textarea name="comment" id="comment-id" cols="30" rows="10"><?php if (isset($comment)) echo $comment ?></textarea></p>

        <input type="submit" value="send" name="btn-form">
    </form>

    <h2>Commentaires</h2>

    <?php
    foreach ($comments as $comment){
        ?><p><?= $comment->author ?></p>
          <time><?= $comment->date ?></time>
          <p><?= $comment->comment ?></p><?php
    }
    ?>

</body>
</html>
