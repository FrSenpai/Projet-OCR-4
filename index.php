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
                    throw new Exception('<p>Il semble y avoir eu un problème lors de l\'ajout du commentaire.</p>');
                }
            } else {
                throw new Exception('<p>Il semble y avoir eu un problème lors de l\'ajout du commentaire.</p>');
            }
        }
        //Signalement d'un commentaire
        if ($_GET['action'] == 'reportComment') {
            if (isset($_GET['commentId']) && $_GET['commentId'] > 0) {
                $comment = new CommentsController();
                $comment->reportComment($_GET['commentId'], $_GET['postId']);
            } else {
                throw new Exception('<p>Il semble y avoir eu un problème lors du signalement du commentaire.</p>');
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
                        throw new Exception('<p>Le format du mot de passe est incorrect.</p>');
                    }
                } else {
                    throw new Exception('<p>Le format du pseudo est incorrect.</p>');
                }
            } else {
                throw new Exception('<p>Vous devez remplir les champs.</p>');
            }
            
        }
        //On envoie les données de connexion
        if ($_GET['action'] == 'login') {
            if (isset($_POST['pseudo']) && isset($_POST['password'])) {
                $user = new UsersController();
                $user->login($_POST['pseudo'], $_POST['password']);
            } else {
                throw new Exception('<p>Les champs ne peuvent pas être vide.</p>');
            }
        } 
        //On se déconnecte
        if ($_GET['action'] == 'logout') {
            $user = new UsersController();
            $user->logout();
        }

        // /!\ Partie administration /!\ 
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
                } else {
                    throw new Exception('<p>Il semble y avoir eu un problème lors de la tentative de bannissement de l\'utilisateur.</p>');
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
                } else {
                    throw new Exception('<p>Il semble y avoir eu un problème lors de la suppression du commentaire.</p>');
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
                } else {
                    throw new Exception('<p>Vous ne pouvez pas ajouter un nouvel article vide.</p>
                    <a href="index.php?action=addPost"> Revenir en arrière ? </a>');
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
                } else {
                    throw new Exception('<p>Vous ne pouvez pas modifier l\'article en le rendant vide.</p>
                    <a href="index.php?action=addPost"> Revenir en arrière ? </a>');
                }
                
            }
            //Suppression d'un article
            if ($_GET['action'] == 'deletePost') {
                if (!empty($_GET['id']) && $_GET['id'] > 0) {
                    $posts = new PostsController();
                    $posts->deletePostAndRelatedComments($_GET['id']);
                } else {
                    throw new Exception('<p>Il semble y avoir eu un problème lors de la suppression de l\'article.</p>');
                }
                
            }
            //Annulation d'un signalement sur un commentaire
            if ($_GET['action'] == 'unreportComment') {
                if (!empty($_GET['id']) && $_GET['id'] > 0) {
                    $commentsManager = new CommentsController();
                    $commentsManager->unreportComment($_GET['id']);
                } else {
                    throw new Exception('<p>Il semble y avoir eu un problème lors de l\'annulation du signalement sur le commentaire</p>');
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