<?php
require_once('model/PostsManager.php');
require_once('model/CommentsManager.php');
require_once('model/UsersManager.php');

use Projet\model\CommentsManager;

function adminPanelView() {
    $commentsManager = new CommentsManager;
    $comments = $commentsManager->getCommentsReported();
    require('view/backend/dashboard.php');
}

