<?php


use App\Manager\ArticleManager;
use App\Manager\CommentManager;

require_once(__DIR__ . '/../include.php');

//Check if GET not exist and if is not numeric.
if (!isset($_GET['id']) || !is_numeric($_GET['id']))
    header('Location: index.php');

else{
    //Recover value of GET.
    extract($_GET);
    $id = strip_tags($id);

    //Check data before add comment
    if (!empty($_POST)){
        //If POST is not empty recover value.
        extract($_POST);
        $errors = array();

        $author = strip_tags($author);
        $comment = strip_tags($comment);

        if (empty($author))
            //Display error message if author is not complete.
            array_push($errors, 'Entrez un pseudo');

        if (empty($comment))
                 //Display error message if comment is not complete.
                array_push($errors, 'Entrez un commentaire');

        if (count($errors) == 0){
            //If no errors, the comment is add.
            $comment = CommentManager::addComment($id, $author, $comment);

            $success = 'Votre commentaire a été publié !';

            //Empty author and comment.
            unset($author);
            unset($comment);
        }
    }
    //show the article and its comments.
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

    <!-- Display name of article -->
    <title><?= $article->title ?></title>
</head>
<body>

<!-- Display some informations of article -->
    <h1><?= $article->title ?></h1>
    <time><?= $article->date_add ?></time>
    <p><?= $article->content ?></p>

    <?php
    //Display message or success errors.
        if (isset($success)){
            echo $success;
        }
        if (!empty($errors)){
            foreach ($errors as $error){ ?>
                <p><?= $error ?></p>
          <?php  }
        }
    ?>

    <!-- Simple form to write a comment -->
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

        <!-- Show all comment for article -->
    <?php
    foreach ($comments as $comment){
        ?><p><?= $comment->author ?></p>
          <time><?= $comment->date ?></time>
          <p><?= $comment->comment ?></p><?php
    }
    ?>

</body>
</html>
