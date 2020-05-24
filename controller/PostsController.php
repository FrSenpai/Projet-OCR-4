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

        if(strlen($title) > 80) {
            echo nl2br('<p> Un titre ne doit contenir que 80 caractères. </p>
                    <a href="index.php?action=addPost"> Revenir en arrière ? </a>');
        } elseif (strlen($content) < 20) {
            echo nl2br('<p> Un post doit contenir au minimum 20 caractères. </p>
                    <a href="index.php?action=addPost"> Revenir en arrière ? </a>');
        } else {
            $this->postsManager->addPost($title, $content);

            header("Location: index.php?action=adminPanel");
        }


        
    }

    public function editPost($postId) {
        $post = $this->postsManager->viewPostById($postId);
        

        require('view/backend/editPost.php');
    }

    public function sendEditedPost($postId, $title, $content) {
        if(strlen($title) > 80) {
            echo nl2br('<p> Un titre ne doit contenir que 80 caractères. </p>
                    <a href="index.php?action=adminPostsManagement"> Revenir en arrière ? </a>');
        } elseif (strlen($content) < 20) {
            echo nl2br('<p> Un post doit contenir au minimum 20 caractères. </p>
                    <a href="index.php?action=adminPostsManagement"> Revenir en arrière ? </a>');
        } else {
            $this->postsManager->editPost($postId, $title, $content);
            header("Location: index.php?action=adminPanel");
        }

        
    }

    public function deletePostAndRelatedComments($postId) {
        $this->postsManager->deletePost($postId);
        $this->commentsManager->deleteCommentByPostId($postId);

        header("Location: index.php?action=adminPanel");
    }


}