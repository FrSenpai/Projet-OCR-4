<?php 

namespace Projet\model;
use Projet\model\Post;
use PDO;

require_once("model/Manager.php");


class PostsManager extends Manager {
    
    //Get a list of all posts
    public function getPosts() {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts ORDER BY creation_date DESC');
        return $req;
    }

    //Recup un post via son id
    public function viewPostById($post) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts WHERE id = ?');
        $req->execute(array($post->getId()));

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

    public function addPost($post) {
        $db = $this->dbConnect();
        $postAdded = $db->prepare("INSERT INTO posts(title, content, creation_date) VALUES(?,?,NOW())");
        $postAdded->execute(array($post->getTitle(), $post->getContent()));

        return $postAdded;
    }   

    public function editPost($post) {
        $db = $this->dbConnect();
        $req = $db->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        $postEdited = $req->execute(array($post->getTitle(), $post->getContent(), $post->getId()));

        return $postEdited;
    }

    public function deletePost($post) {
        $db = $this->dbConnect();
        $req = $db->prepare("DELETE FROM posts WHERE id =?");
        $deletedPost = $req->execute(array($post->getId()));

        return $deletedPost;
    }
 
}