<?php
require('controller/backend.php');
require_once('controller/PostsController.php');
require_once('controller/UsersController.php');
require_once('controller/CommentsController.php');

use Projet\controller\{
    PostsController,
    UsersController,
    CommentsController
};

session_start();

try {
    //TODO : faire un swich avec get action
    if (isset($_GET['action'])) {
        // /!\ Partie front-end /!\
        //On veut check un article
        if ($_GET['action'] == 'post') {
            if (isset($_GET['id'])) {
                $post = new PostsController();
                $post->viewPostById();
            }
        } 
        //On veut add un commentaire à un article spécifique
        if ($_GET['action'] == 'addComment') {
            if (isset($_GET['postId']) && $_GET['postId'] > 0) {
                if (!empty($_SESSION['pseudo']) && !empty($_POST['content'])) {
                    $comment = new CommentsController();
                    $comment->addComment($_GET['postId'], $_SESSION['pseudo'], $_POST['content']);
                } else {
                    throw new Exception('Fail etape 2');
                }
            } else {
                throw new Exception('Fail etape 1');
            }
        }

        if ($_GET['action'] == 'reportComment') {
            if (isset($_GET['commentId']) && $_GET['commentId'] > 0) {
                $comment = new CommentsController();
                $comment->reportComment($_GET['commentId'], $_GET['postId']);
            }
        }

        if ($_GET['action'] == 'register') {
            $user = new UsersController();
            $user->registerView();
        }

        if ($_GET['action'] == 'addUser') {
            if (isset($_POST['pseudo']) && isset($_POST['password'])) {
                //TODO : preg_match pour pseudo (x caractères max) / password (x caractères mini, x caractères max, autres)
                $user = new UsersController();
                $user->addUser($_POST['pseudo'], $_POST['password']);
            } else {
                throw new Exception('Vous devez remplir les champs');
            }
            
        }

        if ($_GET['action'] == 'login') {
            if (isset($_POST['pseudo']) && isset($_POST['password'])) {
                $user = new UsersController();
                $user->login($_POST['pseudo'], $_POST['password']);
            } else {
                throw new Exception('Nope etape 1');
            }
        } 

        if ($_GET['action'] == 'logout') {
            $user = new UsersController();
            $user->logout();
        }

        // /!\ Partie back-end /!\
        if (isset($_SESSION['isAdmin'])) {
            if ($_GET['action'] == 'adminPanel') {
                adminPanelView();
            }

            if ($_GET['action'] == 'banUser') {
                $user = new UsersController();
                $user->banUser($_GET['pseudo']);
            }

            if ($_GET['action'] == 'adminPostsManagement') {
                $posts = new PostsController;
                if (!empty($_GET['page'])) {
                    //Si $_GET['page'] inférieur ou égal a nbdePage
                    $posts->adminListPosts(2, $_GET['page']);
                } else {
                    $posts->adminListPosts(2, 1);
                }
            }

            if ($_GET['action'] == 'deleteComment') {
                $comments = new CommentsController;
                $comments->deleteComment($_GET['commentId']);
            }
        }
    } else {
        $posts = new PostsController();
        $posts->listPosts();
    }
    
}
catch(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}

//TODO : Insérer TinyMCE une fois pour le call quand on a besoin 