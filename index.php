<?php
require('controller/frontend.php');

try {
    
    
    //TODO : faire un swich avec get action
    if (isset($_GET['action'])) {

        //On veut check un article
        if ($_GET['action'] == 'post') {
            if (isset($_GET['id'])) {
                viewPostById();
            }
        } 
        //On veut add un commentaire à un article spécifique
        if ($_GET['action'] == 'addComment') {
            if (isset($_GET['postId']) && $_GET['postId'] > 0) {
                if (!empty($_POST['user']) && !empty($_POST['content'])) {
                    addComment($_GET['postId'], $_POST['user'], $_POST['content']);
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
            addUser($_POST['pseudo'], $_POST['password']);
        }
    } else {
        listPosts();
    }
    
}
catch(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}