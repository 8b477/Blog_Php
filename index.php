<?php

use App\config\FunctionManager;
use App\Manager\ArticleManager;

require_once('./include.php');

$articles = ArticleManager::getAllArticles();
?>

    <h1>Mes différents articles</h1>

    <?php foreach($articles as $article) {?>
        <h2><?= $article->title ?></h2>
        <time><?= $article->date_add ?></time>
        <p><a href="View/article.php?id=<?= $article->id ?>">Lire la suite</a></p>
    <?php } ?>

