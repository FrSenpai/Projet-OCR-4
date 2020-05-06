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
    
    
    public function getPostsWithPagination($limite, $debut) {
        $db = $this->dbConnect();
        $nbPost = $db->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM posts LIMIT :limite OFFSET :debut");
        $nbPost->bindValue('limite', $limite, PDO::PARAM_INT);
        $nbPost->bindValue('debut', $debut, PDO::PARAM_INT);
        $nbPost->execute();

        return $nbPost;
    }

    public function countNbPosts() {
        $db = $this->dbConnect();
        $resultFoundRows = $db->query('SELECT COUNT(*) FROM posts');
        $nbRows = $resultFoundRows->fetchColumn();
        return $nbRows;
    }

}