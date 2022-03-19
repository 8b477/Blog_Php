<?php

//fonction qui récupère tout les articles

function getAllArticles()
{
    require ('config/connect.php');
    $req = $bdd->prepare('SELECT id, title, date_add FROM articles ORDER BY id DESC');
    $req->execute();
    $data = $req->fetchAll(PDO::FETCH_OBJ);
    $req->closeCursor();
    return $data;


}


//fonction qui récupère un article
function getArticle($id){
    require ('config/connect.php');
    $req = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
    $req->execute(array($id));

    if ($req->rowCount() == 1){
        $data = $req->fetch(PDO::FETCH_OBJ);
        return $data;
    }
    else{
        header('Location: index.php');
        $req->closeCursor();
    }
}


//On ajoute un commentaire a un article déjà existant
function addComment($articleId, $author, $comment){
    require('config/connect.php');
    $req = $bdd->prepare('INSERT INTO comment (articleId, author, comment, date) VALUES (?, ?, ?, NOW())');
    $req->execute(array($articleId, $author, $comment));
    $req->closeCursor();
}

//recupère les commentaires a part rapport a l'id de l'article en question

function getComments($id){
    require ('config/connect.php');
    $req = $bdd->prepare('SELECT * FROM comment WHERE articleId = ?');
    $req->execute(array($id));
    $data = $req->fetchAll(PDO::FETCH_OBJ);
    $req->closeCursor();
    return $data;
}