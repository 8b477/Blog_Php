<?php

use App\Manager\ArticleManager;

require_once(__DIR__ . '/../../include.php');

if ($_SESSION['role'] != 'admin')
{
    header('Location: /../../View/articles.php');
    exit();
}

//Call function getAllArticles for display All articles => in variable
$articles = ArticleManager::getAllArticles();
?>
    <h1>Espace Admin !</h1>

    <h3>Les différents articles</h3>

    <div class="wrapper">
        <!-- Loop on all articles and displays them  -->
        <?php foreach($articles as $article) {?>
            <h4><?= $article->title ?></h4>
            <time><?= $article->date_add ?></time>
            <p><a href="/View/admin/article.php?id=<?= $article->id ?>">Lire la suite</a></p>
        <?php } ?>
    </div>
