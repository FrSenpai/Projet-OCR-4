<?php 
require_once('model/Manager.php');

class UsersManager extends Manager {
    //Get user

    
    //Add user
    public function addUser($pseudo, $password) {
        $db = $this->dbConnect();
        $newUser = $db->prepare('INSERT INTO users(pseudo, pass, isAdmin) VALUES(?, ?, 0)');
        $affectedUser = $newUser->execute(array($pseudo, $password));

        return $affectedUser;
    }

    //On vérifie que l'utilisateur ai rentré les bonnes informations
    public function verifyPseudo($pseudo) {
        $db = $this->dbConnect();
        $user = $db->query('SELECT pseudo, pass, isAdmin FROM users WHERE pseudo =\''.$pseudo.'\'');
        $affectedUser = $user->fetch();
        return $affectedUser;
    }

    
    //Count user

    //Delete user
}