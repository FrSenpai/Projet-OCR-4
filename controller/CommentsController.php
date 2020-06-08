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
use Exception;

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

    public static function exception_handler($e) {
        $title = 'Erreur !';
        ob_start();
        ?> 
        <p class="errorMsg">Erreur : <?= $e->getMessage(); ?></p>
        <?php
        $content = ob_get_clean();
        require('view/frontend/template.php');
    }

    public function addComment($postId, $user, $content) {
        $this->comment->setPostId($postId);
        $this->comment->setUser($user);
        $this->comment->setContent($content);

        $comment = $this->commentsManager->addComment($this->comment);
    
        if ($comment === false) {
            throw new Exception('Impossible d\'ajouter le commentaire.');
        } else {
            header('Location: index.php?action=post&id='.$postId);
        }
    }

    public function reportComment($commentId, $postId) {
        $this->comment->setId($commentId);

        $comment = $this->commentsManager->reportComment($this->comment);
    
        if ($comment === false) {
            throw new Exception('Impossible de signaler le commentaire.');
        } else {
            header('Location: index.php?action=post&id='.$postId);
        }
    
    }

    public function deleteComment($commentId) {
        $this->comment->setId($commentId);

        $comment = $this->commentsManager->deleteComment($this->comment);

        if ($comment === false) {
            throw new Exception('Impossible de supprimer le commentaire.');
        } else {
            header('Location: index.php?action=adminPanel');
        }
    }

    public function unreportComment($commentId) {
        $this->comment->setId($commentId);

        $comment = $this->commentsManager->unreportComment($this->comment);

        if ($comment === false) {
            throw new Exception('Impossible d\'annuler le signalement du commentaire.');
        } else {
            header('Location: index.php?action=adminPanel');
        }
    }

}