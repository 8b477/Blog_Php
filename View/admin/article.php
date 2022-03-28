<?php


use App\Config\Connect;
use App\Manager\ArticleManager;
use App\Manager\CommentManager;

require_once(__DIR__ . '/../../include.php');

//Check access
if ($_SESSION['role'] != 'admin')
{
    header('Location: /index.php');
}
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

                //Empty author and comment.
                unset($author);
                unset($comment);
            }
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
        <h1 class="dotted">Nom de l'article :
            <span class="name-article"><?= $article->title ?></span>
        </h1>

        <h3 class="dotted">Date de publication : <time class="time"><?= $article->date_add ?></time></h3>

        <h3>Contenu de l'article : </h3>
        <p><?= $article->content ?></p>
        <!-- Action form for article-->
        <form action="" method="POST">
            <div class="input-area-admin">
                <p>
                    <textarea name="article_m" id="article_m_id" cols="100" rows="10"><?= $article->content ?></textarea>
                </p>
                <input type="submit" value="Modifié/article" name="modA">
                <input type="submit" value="Supprimé/article" name="supA">
            </div>

        </form>


        <h3 class="background">Commentaire(s)</h3>
        <?php
        foreach ($comments as $comment){
            ?><p class="author">Utilisateur : <?= $comment->author ?></p>
            <time class="time">Date de publication : <?= $comment->date ?></time>
            <p class="comment">Commentaire(s) : <?= $comment->comment ?></p>

            <!-- Action form for comment -->
            <form action="" method="POST">
                <p>
                    <input class="comment-admin" type="text" name="comm" id="comm-id" value="<?= $comment->comment ?>">
                </p>
                <input type="submit" value="Modifié/commentaire" name="modC">
                <input type="submit" value="Supprimé/commentaire" name="modS">
            </form>
            <?php

        }
        ?>
    </div>

<?php
//modif article
    if (isset($_POST['modA']) && !empty($_POST['article_m']))
    {
        $pdo = Connect::getPDO();
        $req = $pdo->prepare('UPDATE articles SET content = ? WHERE id = ?');
        $req->execute([$_POST['article_m'], $article->id]);
    }

    if (isset($_POST['supA']))
    {
        $pdo = Connect::getPDO();
        $req = $pdo->prepare('DELETE FROM articles WHERE id = ?');
        $req->execute([$article->id]);
        header('Location: /../../public/admin/admin.php');
    }

    //modif comment

    if (isset($_POST['modC']) && !empty($_POST['comm']))
    {
        $pdo = Connect::getPDO();
        $req = $pdo->prepare('UPDATE comment SET comment = ? WHERE id = ?');
        $req->execute([$_POST['comm'], $comment->id]);
    }

    if (isset($_POST['modS']))
    {
        $pdo = Connect::getPDO();
        $req = $pdo->prepare('DELETE FROM comment WHERE articleId = ?');
        $req->execute([$article->id]);
        header('Location: /../../public/admin/admin.php');
    }