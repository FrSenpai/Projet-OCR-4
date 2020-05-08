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
        $this->commentsManager = new CommentsManager(); //Voir si vraiment utile à un moment
        $this->usersManager = new UsersManager();
        $this->user = new User();
    }

    public function addUser($pseudo, $password) {
        
        $passwordHash = hash('sha256', $password);
        //TODO : vérification pseudo existant, longueur mini/maxi, a-Z0-9
        $addUser = $this->usersManager->addUser($pseudo, $passwordHash);
    
        if ($addUser === false) {
            throw new Exception('Impossible d\'ajouter l\'utilisateur');
        } else {
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['password'] = $passwordHash;
    
            header('Location: index.php');
        }
    }

    public function login($pseudo, $password) {
        $passwordHash = hash('sha256', $password);
        $user = $this->usersManager->getUserByPseudo($pseudo);
        
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
                print('Le mdp pas ok :(');
            }
            
        } else {
            print('Mauvais pseudo :(');
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
        $bannedUser = $this->usersManager->deleteUserByPseudo($pseudo);
    
        if ($bannedUser === false) {
            throw new Exception('Impossible de bannir l\'utilisateur');
        } else {
            header('Location: index.php?action=adminPanel');
        }
    }
}