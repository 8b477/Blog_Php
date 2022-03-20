<?php

use App\config\FunctionManager;
use App\Manager\ArticleManager;

require_once('./include.php');

$articles = ArticleManager::getAllArticles();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog</title>
</head>
<body>

    <h1>Mes différents articles</h1>

    <?php foreach($articles as $article) {?>
        <h2><?= $article->title ?></h2>
        <time><?= $article->date_add ?></time>
        <p><a href="View/article.php?id=<?= $article->id ?>">Lire la suite</a></p>
    <?php } ?>
</body>
</html>
