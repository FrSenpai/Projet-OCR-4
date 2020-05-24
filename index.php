<?php
require_once('controller/PostsController.php');
require_once('controller/UsersController.php');
require_once('controller/CommentsController.php');
require_once('controller/AdminController.php');

use Projet\controller\{
    PostsController,
    UsersController,
    CommentsController,
    AdminController
};

session_start();

try {
    //TODO : faire un swich avec get action
    if (isset($_GET['action'])) {
        // /!\ Partie front-end /!\
        //On veut check un article
        if ($_GET['action'] == 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $post = new PostsController();
                $post->viewPostById($_GET['id']);
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
        //Signalement d'un commentaire
        if ($_GET['action'] == 'reportComment') {
            if (isset($_GET['commentId']) && $_GET['commentId'] > 0) {
                $comment = new CommentsController();
                $comment->reportComment($_GET['commentId'], $_GET['postId']);
            }
        }
        //On affiche la page d'inscription
        if ($_GET['action'] == 'register') {
            $user = new UsersController();
            $user->registerView();
        }
        //On envoie les données d'inscriptions
        if ($_GET['action'] == 'addUser') {
            if (isset($_POST['pseudo']) && isset($_POST['password'])) {
                if (preg_match("#^[a-zA-Z0-9_]{3,16}$#i", $_POST['pseudo'])) {

                    if (preg_match("#^[a-zA-Z0-9_]{3,16}$#i", $_POST['password'])) {
                        $user = new UsersController();
                        $user->addUser($_POST['pseudo'], $_POST['password']);
                    } else {
                        throw new Exception('Le format du mdp est incorrect');
                    }
                } else {
                    throw new Exception('Le format du pseudo est incorrect');
                }
            } else {
                throw new Exception('Vous devez remplir les champs');
            }
            
        }
        //On envoie les données de connexion
        if ($_GET['action'] == 'login') {
            if (isset($_POST['pseudo']) && isset($_POST['password'])) {
                $user = new UsersController();
                $user->login($_POST['pseudo'], $_POST['password']);
            } else {
                throw new Exception('Nope etape 1');
            }
        } 
        //On se déconnecte
        if ($_GET['action'] == 'logout') {
            $user = new UsersController();
            $user->logout();
        }

        // /!\ Partie administration /!\ TODO : Revoir la vérification si admin --> ...
        if (isset($_SESSION['isAdmin'])) {
            if ($_GET['action'] == 'adminPanel') {
                if (!empty($_GET['page'])) {
                    $admin = new AdminController();
                    $admin->viewAdminPanel(5, $_GET['page']);
                } else {
                    $admin = new AdminController();
                    $admin->viewAdminPanel(5, 1);
                }
                
            }
            //Bannir un utilisateur
            if ($_GET['action'] == 'banUser') {
                if (!empty($_GET['pseudo'])) {
                    $user = new UsersController();
                    $user->banUser($_GET['pseudo']);
                }
                
            }
            // Gestion des articles
            if ($_GET['action'] == 'adminPostsManagement') {
                $posts = new PostsController();
                if (!empty($_GET['page'])) {
                    $posts->adminListPosts(5, $_GET['page']);
                } else {
                    $posts->adminListPosts(5, 1);
                }
            }
            //Suppression d'un commentaire
            if ($_GET['action'] == 'deleteComment') {
                if (!empty($_GET['commentId']) && $_GET['commentId'] > 0) {
                    $comments = new CommentsController();
                    $comments->deleteComment($_GET['commentId']);
                }
                
            }
            //Page de création d'un article
            if ($_GET['action'] == 'addPost') {
                $admin = new AdminController();
                $admin->viewAddPost();
            }
            //Envoie des données d'un nouvel article
            if ($_GET['action'] == 'sendNewPost') {
                if (!empty($_POST['postTitle']) && !empty($_POST['postContent'])) {
                    $posts = new PostsController();
                    $posts->sendNewPost($_POST['postTitle'] ,$_POST['postContent'] );
                }
                
            }
            //Page d'édition d'un article
            if ($_GET['action'] == 'editPost') {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $posts = new PostsController();
                    $posts->editPost($_GET['id']);
                }
            }
            //Envoie des données de l'article édité
            if ($_GET['action'] == 'sendEditedPost') {
                if (!empty($_GET['id']) && !empty($_POST['postTitle']) && !empty($_POST['postContent'])) {
                    $posts = new PostsController();
                    $posts->sendEditedPost($_GET['id'], addslashes($_POST['postTitle']) , addslashes($_POST['postContent']));
                }
                
            }
            //Suppression d'un article
            if ($_GET['action'] == 'deletePost') {
                if (!empty($_GET['id']) && $_GET['id'] > 0) {
                    $posts = new PostsController();
                    $posts->deletePostAndRelatedComments($_GET['id']);
                }
                
            }
            //Annulation d'un signalement sur un commentaire
            if ($_GET['action'] == 'unreportComment') {
                if (!empty($_GET['id']) && $_GET['id'] > 0) {
                    $commentsManager = new CommentsController();
                    $commentsManager->unreportComment($_GET['id']);
                }
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