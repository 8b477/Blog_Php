<?php

namespace App\Manager;

use App\config\Connect;
use PDO;

class ArticleManager
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
}