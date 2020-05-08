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
        $comment = $this->commentsManager->addComment($postId, $user, $content);
    
        if ($comment === false) {
            throw new Exception('Impossible d\'ajouter le commentaire...');
        } else {
            header('Location: index.php?action=post&id='.$postId);
        }
    }

    public function reportComment($commentId, $postId) {

        $comment = $this->commentsManager->reportComment($commentId);
    
        if ($comment === false) {
            throw new Exception('Impossible de signaler le commentaire...');
        } else {
            header('Location: index.php?action=post&id='.$postId);
        }
    
    }
}