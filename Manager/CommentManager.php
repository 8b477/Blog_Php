<?php

namespace App\Manager;

use App\config\Connect;
use PDO;

class CommentManager
{


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