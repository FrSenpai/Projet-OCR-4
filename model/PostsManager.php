<?php 
require_once("model/Manager.php");
class PostsManager extends Manager {
    //TODO : Si système d'inscription/connexion, inclure l'auteur (getPosts && viewPostById)
    public function getPosts() {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts ORDER BY creation_date DESC LIMIT 0, 5');

        return $req;
    }

    //Recup un post via son id
    public function viewPostById($postId) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts WHERE id = ?');
        $req->execute(array($postId));

        $postById = $req->fetch();

        return $postById;
    }
    //Add post


    //Delete post

    //Edit post s

}