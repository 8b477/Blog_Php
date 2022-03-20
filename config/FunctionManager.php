<?php

namespace App\config;

use App\config\Connect;
use PDO;

class FunctionManager
{

    public static function getAllArticles()
    {
        $req = Connect::getPDO()->prepare('SELECT id, title, date_add FROM articles ORDER BY id DESC');
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        $req->closeCursor();
        return $data;
    }


//fonction qui récupère un article
    public static function getArticle($id){
        $req = Connect::getPDO()->prepare('SELECT * FROM articles WHERE id = ?');
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
    public static function addComment($articleId, $author, $comment){
        $req = Connect::getPDO()->prepare('INSERT INTO comment (articleId, author, comment, date) VALUES (?, ?, ?, NOW())');
        $req->execute(array($articleId, $author, $comment));
        $req->closeCursor();
    }

//recupère les commentaires a part rapport a l'id de l'article en question

    public static function getComments($id){
        $req = Connect::getPDO()->prepare('SELECT * FROM comment WHERE articleId = ?');
        $req->execute(array($id));
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        $req->closeCursor();
        return $data;
    }

}