<?php 

namespace Projet\model;
use Projet\model\Post;
use PDO;

require_once("model/Manager.php");


class PostsManager extends Manager {
    
    //Get a list of all posts
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
        $nbPost = $db->prepare("SELECT * FROM posts ORDER BY creation_date DESC LIMIT :limite OFFSET :debut");
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

    public function addPost($title, $content) {
        $db = $this->dbConnect();
        $postAdded = $db->prepare("INSERT INTO posts(title, content, creation_date) VALUES(?,?,NOW())");
        $postAdded->execute(array($title, $content));

        return $postAdded;
    }   

    public function editPost($postId, $title, $content) {
        $db = $this->dbConnect();
        $post = $db->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        $postEdited = $post->execute(array($title, $content, $postId));

        return $postEdited;
    }

    public function deletePost($postId) {
        $db = $this->dbConnect();
        $post = $db->prepare("DELETE FROM posts WHERE id =?");
        $deletedPost = $post->execute(array($postId));

        return $deletedPost;
    }
 
}