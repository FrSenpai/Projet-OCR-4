<?php 
namespace Projet\controller;

require_once('model/Comment.php');
require_once('model/CommentsManager.php');

use Projet\model\{
    Comment,
    CommentsManager,
    PostsManager,
    UsersManager
};

class CommentsController {
    private $commentsManager;
    private $usersManager;
    private $postsManager;
    private $comment;

    public function __construct() {
        $this->comment = new Comment();
        $this->commentsManager = new CommentsManager();
        $this->postsManager = new PostsManager();
        $this->usersManager = new UsersManager();
    }

    public function addComment($postId, $user, $content) {
        $this->comment->setPostId($postId);
        $this->comment->setUser($user);
        $this->comment->setContent($content);

        $comment = $this->commentsManager->addComment($this->comment);
    
        if ($comment === false) {
            echo nl2br('Impossible d\'ajouter le commentaire...');
        } else {
            header('Location: index.php?action=post&id='.$postId);
        }
    }

    public function reportComment($commentId, $postId) {
        $this->comment->setId($commentId);

        $comment = $this->commentsManager->reportComment($this->comment);
    
        if ($comment === false) {
            echo nl2br('Impossible de signaler le commentaire...');
        } else {
            header('Location: index.php?action=post&id='.$postId);
        }
    
    }

    public function deleteComment($commentId) {
        $this->comment->setId($commentId);

        $comment = $this->commentsManager->deleteComment($this->comment);

        if ($comment === false) {
            echo nl2br('Impossible de supprimer le commentaire...');
        } else {
            header('Location: index.php?action=adminPanel');
        }
    }

    public function unreportComment($commentId) {
        $this->comment->setId($commentId);

        $comment = $this->commentsManager->unreportComment($this->comment);

        if ($comment === false) {
            echo nl2br('Impossible d\'annuler le signalement du commentaire...');
        } else {
            header('Location: index.php?action=adminPanel');
        }
    }

}