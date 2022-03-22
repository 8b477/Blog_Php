<?php

namespace App\Manager;

use App\Config\Connect;
use PDO;

/**
 * Class manage comment from database
 */

class CommentManager
{


    /**
     * Add a comment to an existing article
     * @param $articleId
     * @param $author
     * @param $comment
     */
    public static function addComment($articleId, $author, $comment){
        $req = Connect::getPDO()->prepare('INSERT INTO comment (articleId, author, comment, date) VALUES (?, ?, ?, NOW())');
        $req->execute(array($articleId, $author, $comment));
        $req->closeCursor();
    }


    /**
     * Return comments linked to an article id
     * @param $id
     * @return array|false
     */
    public static function getComments($id){
        $req = Connect::getPDO()->prepare('SELECT * FROM comment WHERE articleId = ?');
        $req->execute(array($id));
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        $req->closeCursor();
        return $data;
    }
}