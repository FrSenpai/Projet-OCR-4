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

    public function viewPostById() {
        $postsManager = new PostsManager();
        $commentsManager = new CommentsManager();
    
        $postById = $postsManager->viewPostById($_GET['id']);
        $comments = $commentsManager->getComments($_GET['id']);
    
        require('view/frontend/postById.php');
    }

    public function adminListPosts($limite, $page) {
        $debut = ($page - 1) * $limite;
        
        $postsManager = new PostsManager();
        $nbPost = $postsManager->getPostsWithPagination($limite, $debut);
        $nbElements = $postsManager->countNbPosts();
        $nombreDePages = ceil($nbElements / $limite);
    
        require('view/backend/postsManagement.php');
    }

    public function sendNewPost($title, $content) {
        $postsManager = new PostsManager();
        $postsManager->addPost($title, $content);

        header("Location: index.php?action=adminPanel");
    }
}