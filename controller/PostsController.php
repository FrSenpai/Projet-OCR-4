<?php 

namespace Projet\controller;

require_once('model/PostsManager.php');
require_once('model/Post.php');


use Projet\model\{
    PostsManager,
    Post,
    CommentsManager
};
use Exception;

class PostsController {
    private $postsManager;
    private $post;
    private $commentsManager;

    public function __construct() {
        $this->postsManager = new PostsManager();
        $this->post = new Post();
        $this->commentsManager = new CommentsManager();
    }

    public static function exception_handler($e) {
        ob_start();
        ?> 
        <p class="errorMsg">Erreur : <?= $e->getMessage(); ?></p>
        <?php
        $content = ob_get_clean();
        require('view/frontend/template.php');
    }

    public function listPosts() {
        $posts = $this->postsManager->getPosts();
        require('view/frontend/homeView.php');
    }

    public function viewPostById($postId) {
        $this->post->setId($postId);

        $postById = $this->postsManager->viewPostById($this->post);
        $comments = $this->commentsManager->getComments($this->post);

        if ($comments === false || $postById === false) {
            throw new Exception('L\'article et/ou les commentaires ne sont pas disponibles');
        } else {
            require('view/frontend/postById.php');
        }
    
        
    }

    public function adminListPosts($limite, $page) {
        $nbElements = $this->postsManager->countNbPosts();
        $nombreDePages = ceil($nbElements / $limite);
        //On vérifie que l'utilisateur n'essaye pas de rentrer une valeur supérieure au nombre de page
        if ($page <= $nombreDePages) {
            $debut = ($page - 1) * $limite;
            $nbPost = $this->postsManager->getPostsWithPagination($limite, $debut);
            require('view/backend/postsManagement.php');
        } else {
            throw new Exception('Il semble que le numéro de page n\'existe pas.');
        }
    }

    public function sendNewPost($title, $content) {
            $this->post->setTitle($title);
            $this->post->setContent($content);

            $addPost = $this->postsManager->addPost($this->post);
            if ($addPost === false) {
                throw new Exception('Il semble y avoir eu un problème lors de l\'ajout de l\'article.');
            } else {
                header("Location: index.php?action=adminPostsManagement");
            }
    }

    public function editPost($postId) {
        $this->post->setId($postId);

        $post = $this->postsManager->viewPostById($this->post);
        
        if ($post === false) {
            throw new Exception('Il semble y avoir un problème lors de l\'affichage de l\'article souhaité.');
        } else {
            require('view/backend/editPost.php');
        }

        
    }

    public function sendEditedPost($postId, $title, $content) {
            $this->post->setId($postId);
            $this->post->setTitle($title);
            $this->post->setContent($content);

            $sendPost = $this->postsManager->editPost($this->post);

            if ($sendPost === false) {
                throw new Exception('Il semble y avoir eu un problème lors de l\'ajout de l\'article.');
            } else {
                header("Location: index.php?action=adminPanel");
            } 
    }

    public function deletePostAndRelatedComments($postId) {
        $this->post->setId($postId);

        $deletePost = $this->postsManager->deletePost($this->post);
        $deleteComment = $this->commentsManager->deleteCommentByPostId($this->post);

        if ($deletePost === false || $deleteComment === false) {
            throw new Exception('Il semble y avoir eu un problème lors de la suppression de l\'article.');
        } else {
            header("Location: index.php?action=adminPostsManagement");
        }
    }


}