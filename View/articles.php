<?php use App\Manager\ArticleManager;

require_once(__DIR__ . '/../include.php');

//Call function getAllArticles for display All articles => in variable
$articles = ArticleManager::getAllArticles();
?>
    <h1>Mes différents articles</h1>

    <!-- Loop on all articles and displays them  -->
    <?php foreach($articles as $article) {?>
        <h2><?= $article->title ?></h2>
        <time><?= $article->date_add ?></time>

    <!-- Display a link for more details on article id -->
        <p><a href="/View/article.php?id=<?= $article->id ?>">Lire la suite</a></p>
    <?php } ?>