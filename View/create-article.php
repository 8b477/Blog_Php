<?php

use App\Config\Connect;

require_once(__DIR__ . '/../include.php');

if (isset($_POST))
{
    if (!empty($_POST['title-article']) && !empty($_POST['description-article']) && !empty($_POST['author']))
    {
       $titleArticle = trim(addslashes(strip_tags($_POST['title-article'])));
       $contentArticle = trim(addslashes(strip_tags($_POST['description-article'])));
       $auth = trim(addslashes(strip_tags($_POST['author'])));

        $pdo = Connect::getPDO();
        $req = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $req->execute([$auth]);
        $user = $req->fetch();

        if ($user)
        {
            $pdo = Connect::getPDO();
            $req = $pdo->prepare("INSERT INTO articles SET title = ?, content = ?, date_add = CURRENT_DATE");
            $req->execute([$titleArticle, $contentArticle]);
            header('Location: /View/articles.php');
            $_SESSION['flash']['success'] = 'Article ajouté !';
        }
    }
}
?>


        <!-- Simple form to write a article -->
<div class="wrapper-article">

    <form action="" method="POST">

        <label for="author">Pseudo :</label>
        <br>
        <!--  If user have account, username is write  -->
        <p>
            <input type="text" name="author" id="author-id" value="<?php if(!empty($_SESSION['auth'])){echo $_SESSION['auth']->username;}else{echo '';} ?>">
        </p>

        <label for="comment">Titre de l'article :</label>
        <br>
        <p>
            <input type="text" name="title-article" id="title-article-id">
        </p>

        <label for="description-article">Contenu de ton article :</label>
        <p>
            <textarea name="description-article" id="description-article" cols="50" rows="10"></textarea>
        </p>

        <input type="submit" value="send" name="btn-form">
    </form>
</div>

<?php require_once (__DIR__ . '/../parts/footer.php'); ?>