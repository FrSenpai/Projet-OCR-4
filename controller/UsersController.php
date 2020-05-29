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

    public function addUser($pseudo, $password) {
        
        $passwordHash = hash('sha256', $password);
        $this->user->setPseudo($pseudo);
        //On vérifie qu'un pseudo similaire ne soit pas déjà existant
        $verifyUser = $this->usersManager->getUserByPseudo($this->user);

        if ($verifyUser === false) {
            $this->user->setPass($passwordHash);

            $addUser = $this->usersManager->addUser($this->user);

            if ($addUser === false) {
                echo nl2br('<p> Impossible d\'ajouter l\'utilisateur... </p>
                    <a href="index.php?action=register"> Revenir en arrière ? </a>');
            } else {
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['password'] = $passwordHash;
    
                header('Location: index.php');
            }
        } else {
           echo nl2br('<p> Le nom d\'utilisateur existe déjà </p>
                <a href="index.php?action=register"> Revenir en arrière ? </a>');
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
                echo nl2br('Le mot de passe saisi ne correspond pas à celui stocké dans la base de donnée');
            }
            
        } else {
            echo nl2br('Le pseudo saisi ne semble pas correspondre à un pseudo existant.');
        }
        
    }

    public function logout() {
        session_destroy();
        header('Location: index.php');
    }

    public function registerView() {
        require('view/frontend/registerView.php');
    }

    

    // A test
    public function banUser($pseudo) {
        $this->user->setPseudo($pseudo);

        $bannedUser = $this->usersManager->deleteUserByPseudo($this->user);
        $commentsUser = $this->commentsManager->deleteCommentByUser($this->user);
        
        if ($bannedUser === false || $commentsUser === false) {
            echo nl2br('Impossible de bannir l\'utilisateur');
        } else {
            header('Location: index.php?action=adminPanel');
        }
    }
}