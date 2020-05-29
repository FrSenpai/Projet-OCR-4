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
    private $user;

    public function __construct() {
        $this->user = new User();
    }

    public function viewAdminPanel($limite, $debut) {
        $user = new User();
        $user->showAdminPanel($limite, $debut);
    }

    public function viewAddPost() {
        require('view/backend/addPosts.php');
    }
}