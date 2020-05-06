<?php
require_once('model/PostsManager.php');
require_once('model/CommentsManager.php');
require_once('model/UsersManager.php');

function adminPanelView() {
    require('view/backend/dashboard.php');
}

function banUser($pseudo) {
    $usersManager = new UsersManager();
    $bannedUser = $usersManager->deleteUserByPseudo($pseudo);

    if ($bannedUser === false) {
        throw new Exception('Impossible de bannir l\'utilisateur');
    } else {
        header('Location: index.php?action=adminPanel');
    }
}

function adminListPosts($limite, $page) {
    $debut = ($page - 1) * $limite;
    
    $postsManager = new PostsManager();
    $nbPost = $postsManager->getPostsWithPagination($limite, $debut);
    $nbElements = $postsManager->countNbPosts();
    $nombreDePages = ceil($nbElements / $limite);

    require('view/backend/postsManagement.php');
}