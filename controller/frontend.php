<?php 
//TODO : Essayer de faire ça en classe & faire un autoload des classes
require_once('model/PostsManager.php');
require_once('model/CommentsManager.php');

function listPosts() {
    $postsManager = new PostsManager();
    $posts = $postsManager->getPosts();

    require('view/frontend/homeView.php');
}

function viewPostById() {
    $postsManager = new PostsManager();
    $commentsManager = new CommentsManager();

    $postById = $postsManager->viewPostById($_GET['id']);
    $comments = $commentsManager->getComments($_GET['id']);

    require('view/frontend/postById.php');
}

function addComment($postId, $user, $content) {
    $commentsManager = new CommentsManager();
    $comment = $commentsManager->addComment($postId, $user, $content);

    if ($comment === false) {
        throw new Exception('Impossible d\'ajouter le commentaire...');
    } else {
        header('Location: index.php?action=post&id='.$postId);
    }
}

function reportComment($commentId, $postId) {
    $commentsManager = new CommentsManager();
    $comment = $commentsManager->reportComment($commentId);

    if ($comment === false) {
        throw new Exception('Impossible de signaler le commentaire...');
    } else {
        header('Location: index.php?action=post&id='.$postId);
    }

}