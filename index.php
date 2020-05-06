<?php
session_start();

require('controller/frontend.php');
require('controller/backend.php');

try {
    //TODO : faire un swich avec get action
    if (isset($_GET['action'])) {
        // /!\ Partie front-end /!\
        //On veut check un article
        if ($_GET['action'] == 'post') {
            if (isset($_GET['id'])) {
                viewPostById();
            }
        } 
        //On veut add un commentaire à un article spécifique
        if ($_GET['action'] == 'addComment') {
            if (isset($_GET['postId']) && $_GET['postId'] > 0) {
                if (!empty($_SESSION['pseudo']) && !empty($_POST['content'])) {
                    addComment($_GET['postId'], $_SESSION['pseudo'], $_POST['content']);
                } else {
                    throw new Exception('Fail etape 2');
                }
            } else {
                throw new Exception('Fail etape 1');
            }
        }

        if ($_GET['action'] == 'reportComment') {
            if (isset($_GET['commentId']) && $_GET['commentId'] > 0) {
                reportComment($_GET['commentId'], $_GET['postId']);
            }
        }

        if ($_GET['action'] == 'register') {
            register();
        }

        if ($_GET['action'] == 'addUser') {
            if (isset($_POST['pseudo']) && isset($_POST['password'])) {
                //TODO : preg_match pour pseudo (x caractères max) / password (x caractères mini, x caractères max, autres)
                addUser($_POST['pseudo'], $_POST['password']);
            } else {
                throw new Exception('Vous devez remplir les champs');
            }
            
        }

        if ($_GET['action'] == 'login') {
            if (isset($_POST['pseudo']) && isset($_POST['password'])) {
                login($_POST['pseudo'], $_POST['password']);
            } else {
                throw new Exception('Nope etape 1');
            }
        } 

        if ($_GET['action'] == 'logout') {
            logout();
        }

        // /!\ Partie back-end /!\
        if (isset($_SESSION['isAdmin'])) {
            if ($_GET['action'] == 'adminPanel') {
                adminPanelView();
            }

            if ($_GET['action'] == 'banUser') {
                banUser($_POST['pseudo']);
            }

            if ($_GET['action'] == 'adminPostsManagement') {
                if (!empty($_GET['page'])) {
                    adminListPosts(2, $_GET['page']);
                } else {
                    adminListPosts(2, 1);
                }
                
            }
        }
        


    } else {
        listPosts();
    }
    
}
catch(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}