<?php 

namespace Projet\controller;
require_once('model/UsersManager.php');
require_once('model/User.php');
use Projet\model\{
    PostsManager,
    CommentsManager,
    UsersManager,
    User
};
use Exception;

class UsersController {

private $postsManager;
private $commentsManager;
private $usersManager;
private $user;

    public function __construct() {
        $this->postsManager = new PostsManager();
        $this->commentsManager = new CommentsManager();
        $this->usersManager = new UsersManager();
        $this->user = new User();
    }

    public static function exception_handler($e) {
        ob_start();
        ?> 
        <p class="errorMsg">Erreur : <?= $e->getMessage(); ?></p>
        <?php
        $content = ob_get_clean();
        require('view/frontend/template.php');
    }

    public function addUser($pseudo, $password) {
        
        $passwordHash = hash('sha256', $password);
        $this->user->setPseudo($pseudo);
        //On vérifie qu'un pseudo similaire ne soit pas déjà existant
        $verifyUser = $this->usersManager->getUserByPseudo($this->user);

        if ($verifyUser === false) {
            $this->user->setPass($passwordHash);

            $addUser = $this->usersManager->addUser($this->user);

            if ($addUser === false) {
                throw new Exception('Impossible d\'ajouter l\'utilisateur... <a href="index.php?action=register"> Revenir en arrière ? </a>');
            } else {
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['password'] = $passwordHash;
                header('Location: index.php');
            }
        } else {
            throw new Exception('Le nom d\utilisateur existe déjà.<a href="index.php?action=register">Revenir en arrière ?</a>');
        }
    }

    public function login($pseudo, $password) {
        $passwordHash = hash('sha256', $password);
        $this->user->setPseudo($pseudo);

        $user = $this->usersManager->getUserByPseudo($this->user);
        
        if (preg_match("/$pseudo/i", $user['pseudo'])) {
            if(preg_match("/$passwordHash/i", $user['pass'])) {
                //Si tout est bon, on attribue les $_SESSION
                $_SESSION['pseudo'] = $user['pseudo'];
                $_SESSION['pass'] = $user['pass'];
    
                if ($user['isAdmin'] > 0) {
                    $_SESSION['isAdmin'] = $user['isAdmin'];
                }
                
                header('Location: index.php');
            } else {
                throw new Exception('Le mot de passe saisi ne correspond pas à celui stocké dans la base de donnée.<a href="index.php">Revenir en arrière ?</a>');
            }
            
        } else {
            throw new Exception('Le pseudo saisi ne semble pas correspondre à un pseudo existant.<a href="index.php">Revenir en arrière ?</a>');
        }
        
    }

    public function logout() {
        session_destroy();
        header('Location: index.php');
    }

    public function registerView() {
        require('view/frontend/registerView.php');
    }

    public function banUser($pseudo) {
        $this->user->setPseudo($pseudo);

        $bannedUser = $this->usersManager->deleteUserByPseudo($this->user);
        $commentsUser = $this->commentsManager->deleteCommentByUser($this->user);
        
        if ($bannedUser === false || $commentsUser === false) {
            throw new Exception('Impossible de bannir l\'utilisateur.<a href="index.php?action=adminPanel">Revenir en arrière ?</a>');
        } else {
            header('Location: index.php?action=adminPanel');
        }
    }
}