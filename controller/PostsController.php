<?php 

namespace Projet\controller;
require_once('model/PostsManager.php');
require_once('model/Post.php');


use Projet\model\{
    PostsManager,
    Post,
    CommentsManager
};

class PostsController {
    private $postsManager;
    private $post;
    private $commentsManager;

    public function __construct() {
        $this->postsManager = new PostsManager();
        $this->post = new Post();
        $this->commentsManager = new CommentsManager();
    }

    public function listPosts() {
        $posts = $this->postsManager->getPosts();
        require('view/frontend/homeView.php');
    }

    public function viewPostById($postId) {
        $postById = $this->postsManager->viewPostById($postId);
        $comments = $this->commentsManager->getComments($postId);

        if ($comments === false || $postById === false) {
            echo nl2br('<p>Le contenu demandé ne semble pas être disponible.</p>');
        } else {
            require('view/frontend/postById.php');
        }
    
        
    }

    public function adminListPosts($limite, $page) {
        $debut = ($page - 1) * $limite;
        
        $nbPost = $this->postsManager->getPostsWithPagination($limite, $debut);
        $nbElements = $this->postsManager->countNbPosts();
        $nombreDePages = ceil($nbElements / $limite);
    
        require('view/backend/postsManagement.php');
    }

    public function sendNewPost($title, $content) {

        if(strlen($title) > 80 || strlen($title) < 5 || strlen($content) < 20) {
            echo nl2br('<p> Un titre doit contenir au minimum 5 caractères et au maximum 80 caractères.</p>
                    <p>Le contenu de l\'article doit contenir au minimum 20 caractères.</p>
                    <a href="index.php?action=addPost"> Revenir en arrière ? </a>');
        } else {
            $addPost = $this->postsManager->addPost($title, $content);
            if ($addPost === false) {
                echo nl2br('<p>Il semble y avoir eu un problème lors de l\'ajout de l\'article.</p>');
            } else {
                header("Location: index.php?action=adminPostsManagement");
            }
            
        }


        
    }

    public function editPost($postId) {
        $post = $this->postsManager->viewPostById($postId);
        
        if ($post === false) {
            echo nl2br('<p>Il semble y avoir eu un problème lors de l\'édition de l\'article. </p>');
        } else {
            require('view/backend/editPost.php');
        }

        
    }

    public function sendEditedPost($postId, $title, $content) {
        if(strlen($title) > 80) {
            echo nl2br('<p> Un titre ne doit contenir que 80 caractères. </p>
                    <a href="index.php?action=adminPostsManagement"> Revenir en arrière ? </a>');
        } elseif (strlen($content) < 20) {
            echo nl2br('<p> Un post doit contenir au minimum 20 caractères. </p>
                    <a href="index.php?action=adminPostsManagement"> Revenir en arrière ? </a>');
        } else {
            $sendPost = $this->postsManager->editPost($postId, $title, $content);

            if ($sendPost === false) {
                echo nl2br('<p>Il semble y avoir eu un problème lors de l\'ajout de l\'article.</p>');
            } else {
                header("Location: index.php?action=adminPanel");
            }
            
        }

        
    }

    public function deletePostAndRelatedComments($postId) {
        $deletePost = $this->postsManager->deletePost($postId);
        $deleteComment = $this->commentsManager->deleteCommentByPostId($postId);

        if ($deletePost === false || $deleteComment === false) {
            echo nl2br('<p>Il semble y avoir eu un problème lors de la suppression de l\'article.</p>');
        } else {
            header("Location: index.php?action=adminPostsManagement");
        }
    }


}