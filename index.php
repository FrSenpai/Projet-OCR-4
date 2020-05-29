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
    if (isset($_GET['action'])) {
        // /!\ Partie front-end /!\

        //On veut check un article
        if ($_GET['action'] == 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $post = new PostsController();
                $post->viewPostById($_GET['id']);
            } else {
                throw new Exception('Il semble y avoir eu un problème lors de l\'affichage de l\'article.
                <a href="index.php"> Revenir en arrière ? </a>');
            }
        } 

        //On veut add un commentaire à un article spécifique
        if ($_GET['action'] == 'addComment') {
            if (isset($_GET['postId']) && $_GET['postId'] > 0) {
                if (!empty($_SESSION['pseudo']) && !empty($_POST['content'])) {
                    if(strlen($_POST['content']) > 5) {
                        $comment = new CommentsController();
                        $comment->addComment($_GET['postId'], $_SESSION['pseudo'], $_POST['content']);
                    } else {
                        throw new Exception('Un commentaire doit contenir au minimum 5 caractères.
                        <a href="index.php?action=post&id='.$_GET['postId'].'"> Revenir en arrière ? </a>');
                    }
                    
                } else {
                    throw new Exception('Il semble y avoir eu un problème lors de l\'ajout du commentaire.
                    <a href="index.php?action=post&id='.$_GET['postId'].'"> Revenir en arrière ? </a>');
                }
            } else {
                throw new Exception('Il semble y avoir eu un problème lors de l\'ajout du commentaire.
                <a href="index.php?action=post&id='.$_GET['postId'].'"> Revenir en arrière ? </a>');
            }
        }

        //Signalement d'un commentaire
        if ($_GET['action'] == 'reportComment') {
            if (isset($_GET['commentId']) && $_GET['commentId'] > 0) {
                $comment = new CommentsController();
                $comment->reportComment($_GET['commentId'], $_GET['postId']);
            } else {
                throw new Exception('Il semble y avoir eu un problème lors du signalement du commentaire.
                <a href="index.php"> Revenir en arrière ? </a>');
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
                        throw new Exception('Le format du mot de passe est incorrect.
                        <a href="index.php?action=register"> Revenir en arrière ? </a>');
                    }
                } else {
                    throw new Exception('Le format du pseudo est incorrect.
                    <a href="index.php?action=register"> Revenir en arrière ? </a>');
                }
            } else {
                throw new Exception('Vous devez remplir les champs.
                <a href="index.php?action=register"> Revenir en arrière ? </a>');
            }
            
        }

        //On envoie les données de connexion
        if ($_GET['action'] == 'login') {
            if (isset($_POST['pseudo']) && isset($_POST['password'])) {
                $user = new UsersController();
                $user->login($_POST['pseudo'], $_POST['password']);
            } else {
                throw new Exception('Les champs de connexion ne peuvent pas être vide.
                <a href="index.php"> Revenir en arrière ? </a>');
            }
        } 
        
        //On se déconnecte
        if ($_GET['action'] == 'logout') {
            $user = new UsersController();
            $user->logout();
        }

        // /!\ Partie administration /!\ 
            if ($_GET['action'] == 'adminPanel') {
                if (isset($_SESSION['isAdmin'])) {
                    if (!empty($_GET['page'])) {
                        $admin = new AdminController();
                        $admin->viewAdminPanel(5, $_GET['page']);
                    } else {
                        $admin = new AdminController();
                        $admin->viewAdminPanel(5, 1);
                    }
                } else {
                    throw new Exception('Vous ne pouvez pas accéder à cette partie du site car vous n\'êtes pas un administrateur.
                    <a href="index.php"> Revenir à l\'accueil ? </a>');
                }
            }

            //Bannir un utilisateur
            if ($_GET['action'] == 'banUser') {
                if (isset($_SESSION['isAdmin'])) {
                    if (!empty($_GET['pseudo'])) {
                        $user = new UsersController();
                        $user->banUser($_GET['pseudo']);
                    } else {
                        throw new Exception('Il semble y avoir eu un problème lors de la tentative de bannissement de l\'utilisateur.
                        <a href="index.php?action=adminPanel"> Revenir en arrière ? </a>');
                    }
                } else {
                    throw new Exception('Vous ne pouvez pas accéder à cette partie du site car vous n\'êtes pas un administrateur.
                    <a href="index.php"> Revenir à l\'accueil ? </a>');
                }
            }

            // Gestion des articles
            if ($_GET['action'] == 'adminPostsManagement') {
                if (isset($_SESSION['isAdmin'])) {
                    $posts = new PostsController();
                    if (!empty($_GET['page'])) {
                        $posts->adminListPosts(5, $_GET['page']);
                    } else {
                        $posts->adminListPosts(5, 1);
                    }
                } else {
                    throw new Exception('Vous ne pouvez pas accéder à cette partie du site car vous n\'êtes pas un administrateur.
                        <a href="index.php"> Revenir à l\'accueil ? </a>');
                }
                
            }

            //Suppression d'un commentaire
            if ($_GET['action'] == 'deleteComment') {
                if (isset($_SESSION['isAdmin'])) {
                    if (!empty($_GET['commentId']) && $_GET['commentId'] > 0) {
                        $comments = new CommentsController();
                        $comments->deleteComment($_GET['commentId']);
                    } else {
                        throw new Exception('Il semble y avoir eu un problème lors de la suppression du commentaire.
                        <a href="index.php?action=adminPanel"> Revenir en arrière ? </a>');
                    }
                } else {
                    throw new Exception('Vous ne pouvez pas accéder à cette partie du site car vous n\'êtes pas un administrateur.
                        <a href="index.php"> Revenir à l\'accueil ? </a>');
                }
                
                
            }
            //Page de création d'un article
            if ($_GET['action'] == 'addPost') {
                if (isset($_SESSION['isAdmin'])) {
                    $admin = new AdminController();
                    $admin->viewAddPost();
                } else {
                    throw new Exception('Vous ne pouvez pas accéder à cette partie du site car vous n\'êtes pas un administrateur.
                        <a href="index.php"> Revenir à l\'accueil ? </a>');
                }
                
            }
            //Envoie des données d'un nouvel article
            if ($_GET['action'] == 'sendNewPost') {
                if (isset($_SESSION['isAdmin'])) {
                    if (!empty($_POST['postTitle']) && !empty($_POST['postContent'])) {
                        if (strlen($_POST['postTitle']) >= 5 && strlen($_POST['postTitle']) < 255) {
                            if (strlen(strip_tags($_POST['postContent'])) >= 10) {
                                $posts = new PostsController();
                                $posts->sendNewPost($_POST['postTitle'],$_POST['postContent']);
                            } else {
                                throw new Exception('Un article doit au minimum contenir 10 caractères.
                                <a href="index.php?action=adminPostsManagement"> Revenir en arrière ? </a>');
                            }
                        } else {
                            throw new Exception('Un titre doit au minimum contenir 5 caractères et au maximum 255 caractères.
                                <a href="index.php?action=adminPostsManagement"> Revenir en arrière ? </a>');
                        }  
                    } else {
                        throw new Exception('Vous ne pouvez pas ajouter un nouvel article vide.
                        <a href="index.php?action=addPost"> Revenir en arrière ? </a>');
                    }
                } else {
                    throw new Exception('Vous ne pouvez pas accéder à cette partie du site car vous n\'êtes pas un administrateur.
                        <a href="index.php"> Revenir à l\'accueil ? </a>');
                }
            }
            //Page d'édition d'un article
            if ($_GET['action'] == 'editPost') {
                if (isset($_SESSION['isAdmin'])) {
                    if (isset($_GET['id']) && $_GET['id'] > 0) {
                        $posts = new PostsController();
                        $posts->editPost($_GET['id']);
                    }
                } else {
                    throw new Exception('Vous ne pouvez pas accéder à cette partie du site car vous n\'êtes pas un administrateur.
                        <a href="index.php"> Revenir à l\'accueil ? </a>');
                }
                
            }
            //Envoie des données de l'article édité
            if ($_GET['action'] == 'sendEditedPost') {
                if (isset($_SESSION['isAdmin'])) {
                    if (!empty($_GET['id']) && !empty($_POST['postTitle']) && !empty($_POST['postContent'])) {
                        if (strlen($_POST['postTitle']) >= 5 && strlen($_POST['postTitle']) < 255) {
                            if (strlen(strip_tags($_POST['postContent'])) >= 10) {
                                $posts = new PostsController();
                                $posts->sendEditedPost($_GET['id'], addslashes($_POST['postTitle']) , addslashes($_POST['postContent']));
                            } else {
                                throw new Exception('Un article doit au minimum contenir 10 caractères.
                                <a href="index.php?action=editPost&id='.$_GET['id'].'"> Revenir en arrière ? </a>');
                            }
                        } else {
                            throw new Exception('Un titre doit au minimum contenir 5 caractères et au maximum 255 caractères.
                                <a href="index.php?action=editPost&id='.$_GET['id'].'"> Revenir en arrière ? </a>');
                        }
                    
                    } else {
                        throw new Exception('Vous ne pouvez pas modifier l\'article en le rendant vide.
                        <a href="index.php?action=adminPostsManagement"> Revenir en arrière ? </a>');
                    }
                } else {
                    throw new Exception('Vous ne pouvez pas accéder à cette partie du site car vous n\'êtes pas un administrateur.
                        <a href="index.php"> Revenir à l\'accueil ? </a>');
                }
            }

            //Suppression d'un article
            if ($_GET['action'] == 'deletePost') {
                if (isset($_SESSION['isAdmin'])) {
                    if (!empty($_GET['id']) && $_GET['id'] > 0) {
                        $posts = new PostsController();
                        $posts->deletePostAndRelatedComments($_GET['id']);
                    } else {
                        throw new Exception('Il semble y avoir eu un problème lors de la suppression de l\'article.
                        <a href="index.php?action=adminPostsManagement"> Revenir en arrière ? </a>');
                    }
                } else {
                    throw new Exception('Vous ne pouvez pas accéder à cette partie du site car vous n\'êtes pas un administrateur.
                        <a href="index.php"> Revenir à l\'accueil ? </a>');
                }
            }

            //Annulation d'un signalement sur un commentaire
            if ($_GET['action'] == 'unreportComment') {
                if (isset($_SESSION['isAdmin'])) {
                    if (!empty($_GET['id']) && $_GET['id'] > 0) {
                        $commentsManager = new CommentsController();
                        $commentsManager->unreportComment($_GET['id']);
                    } else {
                        throw new Exception('Il semble y avoir eu un problème lors de l\'annulation du signalement sur le commentaire.
                        <a href="index.php?action=adminPanel"> Revenir en arrière ? </a>');
                    }
                } else {
                    throw new Exception('Vous ne pouvez pas accéder à cette partie du site car vous n\'êtes pas un administrateur.
                        <a href="index.php"> Revenir à l\'accueil ? </a>');
                }
                
            }
        
    } else {
        $posts = new PostsController();
        $posts->listPosts();
    }
    
}
catch(Exception $e) {
    echo '<p style="font-size:35px;text-align:center;">Erreur : ' . $e->getMessage() . '</p>';
}