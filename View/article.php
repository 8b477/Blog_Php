<?php


use App\Manager\ArticleManager;
use App\Manager\CommentManager;

require_once(__DIR__ . '/../include.php');

//Check if GET not exist and if is not numeric.
if (!isset($_GET['id']) || !is_numeric($_GET['id']))
    {
            header('Location: /admin/admin.php');
    }

else{
    //Recover value of GET.
    extract((array)$_GET['id']);
    $id = strip_tags($_GET['id']);
    }

//show the article and its comments.
$article = ArticleManager::getArticle($id);
$comments = CommentManager::getComments($id);

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

    <div class="wrapper-article">
    <!-- Display some informations of article -->
        <h1 class="underline"><?= $article->title ?></h1>
        <time class="time"><?= $article->date_add ?></time>
        <p class="content"><?= $article->content ?></p>

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
                                        <!--  If user have account, username is write  -->
            <p>
                <input type="text" name="author" id="author-id" value="<?php if(!empty($_SESSION['auth'])){echo $_SESSION['auth']->username;}else{echo '';} ?>">
            </p>

            <label for="comment">Commentaire :</label>
            <br>
            <p>
                <textarea name="comment" id="comment-id" cols="55" rows="4"><?php if (isset($comment)) echo $comment ?></textarea>
            </p>

            <input type="submit" value="send" name="btn-form">
        </form>

        <h2 class="underline">Commentaires</h2>

            <!-- Show all comment for article -->
        <?php
        foreach ($comments as $comment){
            ?><p class="author"><?= $comment->author ?></p>
              <time class="time"><?= $comment->date ?></time>
              <p class="comment"><?= $comment->comment ?></p><?php
        }
        ?>
    </div>
</body>
</html>
