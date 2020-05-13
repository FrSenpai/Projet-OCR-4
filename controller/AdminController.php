<?php
namespace Projet\controller;

use Projet\model\{
    Comment,
    CommentsManager,
    PostsManager,
    UsersManager,
    User
};

class AdminController {
    private $commentsManager;
    private $usersManager;
    private $postsManager;
    private $comment;


    public function viewAdminPanel($limite, $debut) {
        //On a besoin d'afficher une pagination sur les commentaires report
        $user = new User();
        $user->showAdminPanel($limite, $debut);
        
    }
}